<?php

namespace Visca\Bundle\LicomViewBundle\Command;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;
use Visca\Bundle\LicomBundle\Factory\MatchFactory;
use Visca\Bundle\LicomBundle\Factory\MatchParticipantFactory;
use Visca\Bundle\LicomViewBundle\Wrapper\SlugWrapper;

/**
 * Class SlugDebugCommand.
 */
class SlugDebugCommand extends ContainerAwareCommand
{
    protected $debugEntities = [
        'competition',
        'competition_category',
        'country',
        'participant',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:debug:slug')
            ->setDescription('Debugging the slug');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        /** @var SlugWrapper $slugWrapper */
        $slugWrapper = $container->get('visca_licom.provider.slug.wrapper');
        $entitiesToDebug = $this->getEntities($container);

        $table = new Table($output);
        $table->setHeaders(['Entity', 'Entity ID', 'Name', 'Slug']);

        $previousEntityClassName = false;
        /** @var Competition|CompetitionCategory|Country|Participant $entity */
        foreach ($entitiesToDebug as $entity) {
            $entityClassName = $this->getClassName($entity);
            /*
             * Separator
             */
            if ($previousEntityClassName !== false && $previousEntityClassName != $entityClassName) {
                $table->addRow(new TableSeparator());
            }
            $previousEntityClassName = $entityClassName;

            /*
             * Display slug
             */
            try {
                $slug = $slugWrapper
                    ->getSlugProvider($entity)
                    ->getSlug($entity);
            } catch (SlugNotAvailableException $ex) {
                $slug = '?';
            }
            $table->addRow(
                [
                    $entityClassName,
                    $entity->getId(),
                    $entity->getName(),
                    $slug,
                ]
            );
        }

        $table->render();
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Competition|CompetitionCategory|Country|Participant|Match
     */
    protected function getEntities(ContainerInterface $container)
    {
        $entities = array_merge(
            $this->getDynamicEntities($container),
            $this->getMatchEntities($container)
        );

        return $entities;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Match[]
     */
    protected function getMatchEntities(ContainerInterface $container)
    {
        $teamRepository = $container->get('visca_licom.repository.participant');

        $matchCollection = [];
        foreach ([[1, 2], [3, 4], [5, 6]] as $matchCounter => $participantIds) {
            $homeParticipantId = $participantIds[0];
            $awayParticipantId = $participantIds[1];

            /** @var Team $teamHome */
            $teamHome = $teamRepository->findOneBy(
                ['id' => $homeParticipantId]
            );
            /** @var Team $teamAway */
            $teamAway = $teamRepository->findOneBy(
                ['id' => $awayParticipantId]
            );

            $matchFactory = new MatchFactory();
            $matchParticipantFactory = new MatchParticipantFactory();

            $matchParticipantHome = $matchParticipantFactory->create();
            $matchParticipantHome
                ->setNumber(1)
                ->setParticipant($teamHome);

            $matchParticipantAway = $matchParticipantFactory->create();
            $matchParticipantAway
                ->setNumber(2)
                ->setParticipant($teamAway);

            $match = $matchFactory->create();
            $match
                ->setName('Match '.$matchCounter)
                ->addMatchParticipant($matchParticipantHome)
                ->addMatchParticipant($matchParticipantAway);
            $matchCollection[] = $match;
        }

        return $matchCollection;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Competition[]|CompetitionCategory[]|Country[]|Participant[]
     */
    protected function getDynamicEntities(ContainerInterface $container)
    {
        $repositoryServiceName = 'visca_licom.repository.%s';

        $entitiesCollection = [];
        foreach ($this->debugEntities as $entityName) {
            /** @var ObjectRepository $repository */
            $repository = $container->get(
                sprintf($repositoryServiceName, $entityName)
            );
            $randomOffset = 0;
            $randomEntities = $repository->findBy([], [], 10, $randomOffset);
            $entitiesCollection = array_merge(
                $entitiesCollection,
                $randomEntities
            );
        }

        return $entitiesCollection;
    }

    /**
     * @param $entity
     *
     * @return string
     */
    protected function getClassName($entity)
    {
        $classFullNamespace = get_class($entity);
        $className = preg_replace(
            '#^.*\\\\([^\\\\]+)$#',
            '$1',
            $classFullNamespace
        );

        return $className;
    }
}
