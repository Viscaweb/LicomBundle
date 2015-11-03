<?php

namespace Visca\Bundle\LicomBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

/**
 * Class GenerateEntityFromFixtureCommand.
 */
class GenerateEntityFromFixtureCommand extends ContainerAwareCommand
{
    protected $destinationPath = '@ViscaLicomBundle/Resources/config/fixtures/alice/types';

    protected $fixturesType = [];
    protected $entityType;
    protected $entityMain;
    protected $entityMainFile;
    protected $entityAlone;

    /**
     * Sets information about the command.
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:createViewEntityFromFixture')
            ->setDescription('Generate view Entities with adapters & factories from the fixture of a EntityType.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Absolute path for EntityType fixture?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setFixturesType($input);

        $this->processFixtures($output);
    }

    /**
     * @param InputInterface $input
     */
    protected function setFixturesType(InputInterface $input)
    {
        $file = $input->getArgument('file');

        if (substr($file, -8) !== 'Type.yml') {
            throw new \LogicException("file {$file} must be a *Type.yml file.");
        }

        $parser = new Parser();

        $this->fixturesType = $parser
            ->parse(
                file_get_contents($file)
            );

        if (!is_array($this->fixturesType)) {
            throw new \LogicException("file {$file} is not a valid yaml file.");
        }

        $this->setEntityType();

        $this->setEntityMain();
        $this->setEntityMainFile();
    }

    /**
     * set entityType and check it.
     */
    protected function setEntityType()
    {
        $keys = array_keys($this->fixturesType);
        $this->entityType = reset($keys);

        if (substr($this->entityType, -4) !== 'Type') {
            throw new \LogicException(
                "Entity {$this->entityType} in the fixture file must be a *Type."
            );
        }
    }

    /**
     * set entityMain and entityAlone.
     */
    protected function setEntityMain()
    {
        $this->entityMain = str_replace('Type', '', $this->entityType);

        $this->entityAlone = basename(
            str_replace('\\', '/', $this->entityMain)
        );
    }

    /**
     * set the file that has de main entity.
     */
    protected function setEntityMainFile()
    {
        $this->entityMainFile = 'src/'.
            str_replace('\\', '/', $this->entityMain).
            '.php';

        if (!is_readable($this->entityMainFile)) {
            throw new \LogicException(
                "File {$this->entityMainFile} is not readable."
            );
        }
    }

    /**
     * @param OutputInterface $output
     */
    protected function processFixtures(OutputInterface $output)
    {
        foreach ($this->fixturesType[$this->entityType] as $key => $entityType) {
            if (!isset($entityType['code'])) {
                throw new \LogicException(
                    "Fixture {$key} is not a valid EntityType fixture ".
                    'generated with app/console visca:licom:type-fixtures:generate'
                );
            }

            $output->writeln("Processing {$entityType['code']}");

            $this->createEntity($entityType['code']);
            $this->createAdapter($entityType['code']);
            $this->createFactory($entityType['code']);

            $output->writeln('');
        }
    }

    /**
     * @param string $type
     */
    protected function createEntity($type)
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile);
        @mkdir($entityFolder);

        $entityClass = <<< CLASS
<?php

namespace {$this->entityMain};

use {$this->entityMain}\Abstracts\Abstract{$this->entityAlone};

/**
 * Class {$type}
 */
class {$type} extends Abstract{$this->entityAlone}
{
}

CLASS;

        $this->filePutContents(
            $entityFolder.
            '/'.
            $type.
            '.php',
            $entityClass
        );

        $this->createEntityAbstract();
    }

    /**
     * write the class in a file.
     *
     * @param string $file
     * @param string $content
     * @param bool   $onlyIfNew put contents only if the file not exists.
     *
     * @return bool|int
     */
    protected function filePutContents($file, $content, $onlyIfNew = true)
    {
        if (file_exists($file) and $onlyIfNew) {
            return false;
        }

        return file_put_contents($file, $content);
    }

    /**
     * Ceate Abstract for Entity.
     */
    protected function createEntityAbstract()
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile).
            '/Abstracts';
        @mkdir($entityFolder);

        $entityClass = <<< CLASS
<?php

namespace {$this->entityMain}\Abstracts;

/**
 * Class Abstract$this->entityAlone}
 */
abstract class Abstract{$this->entityAlone}

CLASS;

        $tmpClass = file_get_contents($this->entityMainFile);

        $pos = strpos($tmpClass, '{');

        $entityClass .= substr($tmpClass, $pos);

        $this->filePutContents(
            $entityFolder.
            '/Abstract'.
            $this->entityAlone.
            '.php',
            $entityClass
        );
    }

    /**
     * @param string $type
     */
    protected function createAdapter($type)
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile);
        $entityFolder = str_replace('/Entity/', '/Adapter/', $entityFolder);
        @mkdir($entityFolder);

        $entityMain = str_replace('\\Entity\\', '\\Adapter\\', $this->entityMain);
        $factoryMain = str_replace('\\Entity\\', '\\Factory\\', $this->entityMain);

        $entityClass = <<< CLASS
<?php

namespace {$entityMain};

use {$entityMain}\Abstracts\Abstract{$this->entityAlone}Adapter;
use {$this->entityMain}\\{$type};
use {$this->entityMain};
use {$factoryMain}\\{$type}Factory;

/**
 * Class {$type}Adapter
 */
class {$type}Adapter extends Abstract{$this->entityAlone}Adapter
{
    /**
     * Adapt the inputObject to a {$type} entity
     *
     * @param  {$this->entityAlone} \$inputObject
     * @return {$type}
     */
    public function process({$this->entityAlone} \$inputObject)
    {
        \$factory = new {$type}Factory();
        \$final{$this->entityAlone} = \$this->create(
            \$inputObject,
            \$factory
        );

        return \$final{$this->entityAlone};
    }
}

CLASS;

        $file = $entityFolder.
            '/'.
            $type.
            'Adapter.php';

        $this->filePutContents(
            $file,
            $entityClass
        );

        $this->createAdapterAbstract();
    }

    /**
     * Create Abstract for Adapters.
     */
    protected function createAdapterAbstract()
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile);
        $entityFolder = str_replace('/Entity/', '/Adapter/', $entityFolder);
        $entityFolder .= '/Abstracts';
        @mkdir($entityFolder);

        $entityMain = str_replace('\\Entity\\', '\\Adapter\\', $this->entityMain);
        $factoryMain = str_replace('\\Entity\\', '\\Factory\\', $this->entityMain);

        $entityClass = <<< CLASS
<?php

namespace {$entityMain}\Abstracts;

use {$this->entityMain};
use {$this->entityMain}\Abstracts\Abstract{$this->entityAlone};
use {$factoryMain}\Abstracts\Abstract{$this->entityAlone}Factory;

/**
 * Class Abstract{$this->entityAlone}Adapter
 */
abstract class Abstract{$this->entityAlone}Adapter
{
    /**
     * Process the input object and return a {$this->entityAlone} View Entity
     *
     * @param {$this->entityAlone} \$inputObject
     * @return Abstract{$this->entityAlone}
     */
    abstract public function process({$this->entityAlone} \$inputObject);

    /**
     * Create the entitty from the factory and adapt generic data
     *
     * @param {$this->entityAlone} \$inputObject
     * @param Abstract{$this->entityAlone}Factory \$factory
     * @return Abstract{$this->entityAlone} \$final{$this->entityAlone}
     */
    protected function create(
        \$inputObject,
        Abstract{$this->entityAlone}Factory \$factory
    ) {
        \$final{$this->entityAlone}= \$factory->create();

        return \$final{$this->entityAlone};
    }
}

CLASS;

        $file = $entityFolder.
            '/Abstract'.
            $this->entityAlone.
            'Adapter.php';

        $this->filePutContents(
            $file,
            $entityClass
        );
    }

    /**
     * @param string $type
     */
    protected function createFactory($type)
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile);
        $entityFolder = str_replace('/Entity/', '/Factory/', $entityFolder);
        @mkdir($entityFolder);

        $entityMain = str_replace('\\Entity\\', '\\Factory\\', $this->entityMain);

        $entityClass = <<< CLASS
<?php

namespace {$entityMain};

use {$entityMain}\Abstracts\Abstract{$this->entityAlone}Factory;
use {$this->entityMain}\\{$type};

/**
 * Class {$type}Factory
 */
class {$type}Factory extends Abstract{$this->entityAlone}Factory
{
    /**
     * @return {$type}
     */
    public function create()
    {
        \$entity = new {$type}();

        return \$entity;
    }
}

CLASS;

        $file = $entityFolder.
            '/'.
            $type.
            'Factory.php';

        $this->filePutContents(
            $file,
            $entityClass
        );

        $this->createFactoryAbstract();
    }

    /**
     * create Abstract Factory.
     */
    protected function createFactoryAbstract()
    {
        $entityFolder = str_replace('.php', '', $this->entityMainFile);
        $entityFolder = str_replace('/Entity/', '/Factory/', $entityFolder);
        $entityFolder .= '/Abstracts';
        @mkdir($entityFolder);

        $entityMain = str_replace('\\Entity\\', '\\Factory\\', $this->entityMain);

        $entityClass = <<< CLASS
<?php

namespace {$entityMain}\Abstracts;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;

/**
 * Class Abstract{$this->entityAlone}Factory
 */
abstract class Abstract{$this->entityAlone}Factory extends AbstractFactory
{
}

CLASS;

        $file = $entityFolder.
            '/Abstract'.
            $this->entityAlone.
            'Factory.php';

        $this->filePutContents(
            $file,
            $entityClass
        );
    }
}
