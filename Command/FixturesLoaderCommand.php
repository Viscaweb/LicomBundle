<?php

namespace Visca\Bundle\LicomBundle\Command;

use Nelmio\Alice\Fixtures;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FixturesLoaderCommand.
 */
class FixturesLoaderCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:fixtures:load')
            ->setDescription('Load Licom fixtures')
            ->addArgument(
                'set',
                InputArgument::REQUIRED,
                'The fixture set name'
            )->addOption(
                'em',
                null,
                InputOption::VALUE_REQUIRED,
                'The entity manager name',
                'licom'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $setName = $input->getArgument('set');
        $entityManagerName = $input->getOption('em');

        $objectManager = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager($entityManagerName);

        $this->dropSchema($entityManagerName, $output);
        $this->createSchema($entityManagerName, $output);

        Fixtures::load(
            $this->getFixtureSetFileNamePath($setName),
            $objectManager
        );

        /*
         * No exceptions ?
         * We are done
         */
        $output->writeln('Fixtures loaded');
    }

    /**
     * @param string          $entityManagerName
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    private function dropSchema($entityManagerName, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:schema:drop');
        $arguments = [
            'command' => 'doctrine:schema:drop',
            '--em' => $entityManagerName,
            '--force' => true,
        ];

        $input = new ArrayInput($arguments);
        $command->run($input, $output);
    }

    /**
     * @param string          $entityManagerName
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    private function createSchema($entityManagerName, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:schema:create');
        $arguments = [
            'command' => 'doctrine:schema:create',
            '--em' => $entityManagerName,
        ];

        $input = new ArrayInput($arguments);
        $command->run($input, $output);
    }

    /**
     * @param $setName
     *
     * @return string
     */
    private function getFixtureSetFileNamePath($setName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/fixtures/alice/sets/';

        return $this
            ->getContainer()
            ->get('kernel')
            ->locateResource(
                $baseFolder.'/'.$setName.'.yml',
                null,
                true
            );
    }
}
