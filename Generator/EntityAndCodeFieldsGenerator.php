<?php

namespace Visca\Bundle\LicomBundle\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use InvalidArgumentException;
use Symfony\Component\Templating\EngineInterface;
use Visca\Bundle\DoctrineBundle\Generator\Interfaces\ClassGeneratorInterface;
use Visca\Bundle\DoctrineBundle\Naming\Classes\Interfaces\ClassNamingInterface;
use Visca\Bundle\DoctrineBundle\Naming\Constant\Interfaces\ConstantNamingInterface;
use Visca\Bundle\LicomBundle\Entity\Entity;

/**
 * Class EntityAndCodeFieldsGenerator.
 */
final class EntityAndCodeFieldsGenerator implements ClassGeneratorInterface
{
    protected $ignoredEntities = [
        /*
         * We ignore this entity because the code already contains the entity.
         * We can't just refactor it because some code contains the entity + a word:
         *  - 'LiveCompetitionTable'
         */
        'Visca\Bundle\LicomBundle\Entity\StandingView',
    ];

    const FIELD_CODE = 'code';

    const RELATION_ENTITY = 'entity';

    /*
     * &1 => Entity Name (i.e. 'MATCH', 'COMPETITION', etc..)
     * &2 => Code Name (i.i.e 'NAME', 'SHORTNAME', 'SLUG', etc..)
     */
    const CONSTANT_FORMAT = '%s_%s';

    /**
     * @var ClassNamingInterface
     */
    private $classNaming;

    /**
     * @var ConstantNamingInterface
     */
    private $constantNaming;

    /**
     * @var EngineInterface
     */
    private $templateEngine;

    /**
     * @var string
     */
    private $templateFile;

    /**
     * @param EngineInterface         $templateEngine
     * @param ConstantNamingInterface $constantNaming
     * @param ClassNamingInterface    $classNaming
     * @param string                  $templateFile
     */
    public function __construct(
        ClassNamingInterface $classNaming,
        ConstantNamingInterface $constantNaming,
        EngineInterface $templateEngine,
        $templateFile
    ) {
        $this->templateFile = $templateFile;
        $this->classNaming = $classNaming;
        $this->constantNaming = $constantNaming;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param ClassMetadataInfo $metaData Meta Data
     *
     * @return bool
     */
    public function supports(ClassMetadataInfo $metaData)
    {
        if (in_array($metaData->getName(), $this->ignoredEntities)) {
            return false;
        }

        $fields = $metaData->getFieldNames();
        $relations = $metaData->getAssociationMappings();

        return (
            isset($relations[self::RELATION_ENTITY]) &&
            in_array(self::FIELD_CODE, $fields)
        );
    }

    /**
     * @param ClassMetadataInfo      $metadata
     * @param EntityManagerInterface $entityManager
     * @param string                 $destinationPath
     */
    public function generate(
        ClassMetadataInfo $metadata,
        EntityManagerInterface $entityManager,
        $destinationPath
    ) {
        $repository = $entityManager->getRepository($metadata->getName());
        $entities = $repository->findAll();

        $this->generateClassContent(
            $metadata,
            $entities,
            $destinationPath
        );
    }

    /**
     * @param ClassMetadataInfo $metadata
     * @param array             $entities
     * @param string            $destinationPath
     *
     * @return string
     */
    private function generateClassContent(
        ClassMetadataInfo $metadata,
        array $entities,
        $destinationPath
    ) {
        $className = $metadata->getName();
        $baseClassName = $this->classNaming->getClassname($className);
        $namespace = $this->classNaming->getNamespace($className);

        $fieldName = self::FIELD_CODE;
        $constantNamespace = $namespace.'\\'.ucfirst($fieldName);
        $constantBaseClassName = $baseClassName.ucfirst($fieldName);
        $constantClassName = $constantNamespace.'\\'.$constantBaseClassName;

        $identifierName = $metadata->getIdentifier()[0];

        $constantList = $this->buildConstantsList(
            $identifierName,
            $className,
            $entities
        );

        if (count($entities) == 0) {
            return;
        }

        $classContent = $this
            ->templateEngine
            ->render(
                $this->templateFile,
                [
                    'className' => $constantBaseClassName,
                    'namespace' => $constantNamespace,
                    'constantsList' => $constantList,
                ]
            );

        $classPath =
            $destinationPath.str_replace('\\', '/', $constantClassName).'.php';

        $classDir = dirname($classPath);

        if (!file_exists($classDir)) {
            mkdir($classDir, 0777, true);
        }

        file_put_contents($classPath, $classContent);
    }

    /**
     * @param string $identifierName
     * @param string $className      Of the main entity
     * @param array  $entities
     *
     * @return array
     */
    private function buildConstantsList(
        $identifierName,
        $className,
        array $entities
    ) {
        $constantsList = [];

        $fieldName = self::FIELD_CODE;

        foreach ($entities as $entity) {
            // Check the presence of the value getter
            $valueGetter = 'get'.$fieldName;
            if (!method_exists($entity, $valueGetter)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Missing getter "%s" in class "%s"',
                        $valueGetter,
                        get_class($entity)
                    )
                );
            }
            $value = $entity->$valueGetter();

            // Check the presence of the identifier getter
            $idGetter = 'get'.$identifierName;
            if (!method_exists($entity, $idGetter)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Missing getter "%s" in class "%s"',
                        $idGetter,
                        get_class($entity)
                    )
                );
            }
            $constantValue = $entity->$idGetter();

            // Check the presence of the 'entity' getter
            $entityGetter = 'get'.ucfirst(self::RELATION_ENTITY);
            if (!method_exists($entity, $entityGetter)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Missing getter "%s" in class "%s"',
                        $idGetter,
                        get_class($entity)
                    )
                );
            }
            /** @var Entity $linkedEntity */
            $linkedEntity = $entity->$entityGetter();

            /*
             * Sometimes no entity is linked.
             * Example: ProfileEntity_graphLabel, code = 'top-sports'
             */
            if (!($linkedEntity instanceof Entity)) {
                continue;
            }
            $constantNameEntity = $linkedEntity->getCode();

            $constantNameCode = $this->constantNaming->getName(
                $className,
                $fieldName,
                $value
            );
            $constantName = sprintf(
                self::CONSTANT_FORMAT,
                strtoupper($constantNameEntity),
                $constantNameCode
            );

            $constantsList[$constantName] = $constantValue;
        }

        return $constantsList;
    }
}
