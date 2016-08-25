<?php

namespace Visca\Bundle\LicomBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateFixturesFromDbCommand.
 */
class GenerateFixturesFromDbCommand extends ContainerAwareCommand
{
    protected $entitiesToDump = [
        '*\\BettingOutcomeScopeType',
        '*\\BettingOutcomeSubType',
        '*\\BettingOutcomeType',
        '*\\CompetitionStageType',
        '*\\Bookmaker',
        '*\\BettingOfferProvider',
        '*\\MatchAuxType',
        '*\\MatchAuxProfileType',
        '*\\MatchIncidentType',
        '*\\MatchStatusDescription',
        '*\\MatchResultType',
        '*\\MatchStatsType',
        '*\\MatchCommentType',
        '*\\MatchIncidentType',
        '*\\MatchIncidentAuxType',
        '*\\MatchLineupParticipantType',
        '*\\MatchParticipantAuxType',
        '*\\MediaType',
        '*\\MediaTheme',
        '*\\StandingType',
        '*\\CompetitionCategory',
        '*\\CompetitionStageType',
        '*\\CompetitionGraphLabel',
        '*\\CompetitionRoundGraphLabel',
        '*\\CompetitionSeasonGraphLabel',
        '*\\CompetitionSeasonStageGraphLabel',
        '*\\AuxType',
        '*\\Label',
        '*\\ProfileType',
        '*\\ProfileRuleType',
        '*\\ProfileTranslationGraphLabel',
        '*\\ProfileEntityGraphLabel',
        '*\\Entity',
        '*\\EventType',
        '*\\ParticipantAuxType',
        '*\\Localization',
        '*\\LocalizationTranslationType',
        '*\\LocalizationTranslationGraphLabel',
        '*\\StandingColumn',
        '*\\StandingColumnScope',
        '*\\StandingColumnGroup',
        '*\\StandingType',
        '*\\StandingCommentGraphLabel',
        '*\\StandingView',
        '*\\StandingViewGraph',
        '*\\StandingViewGraphLabel',
        '*\\StandingPromotion',
        '*\\StandingPromotionType',
        '*\\Sport',
        '*\\Country',
    ];

    protected $destinationPath = '@ViscaLicomBundle/Resources/config/fixtures/alice/types';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:type-fixtures:generate')
            ->setDescription('Generate all require type fixtures')
            ->addOption(
                'em',
                null,
                InputOption::VALUE_REQUIRED,
                'The entity manager name',
                'licom'
            )->addOption(
                'entity',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'The entity to dump (Ex: *\Sport)'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getContainer()->get('kernel');

        $entityManagerName = $input->getOption('em');
        $entitiesFiltered = $input->getOption('entity');

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $destinationPath = $this
            ->getContainer()
            ->get('kernel')
            ->locateResource($this->destinationPath);

        if (null !== $entitiesFiltered) {
            foreach ($entitiesFiltered as $entityFiltered) {
                $this->executeDump(
                    $entityManagerName,
                    $destinationPath,
                    $entityFiltered,
                    $output
                );
            }
        } else {
            foreach ($this->entitiesToDump as $entityToDump) {
                $this->executeDump(
                    $entityManagerName,
                    $destinationPath,
                    $entityToDump,
                    $output
                );
            }
        }
    }

    /**
     * @param string          $entityManagerName
     * @param string          $destinationPath
     * @param string          $entityToDump
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    private function executeDump(
        $entityManagerName,
        $destinationPath,
        $entityToDump,
        $output
    ) {
        $command = $this->getApplication()->find('sp:fixture-dumper:orm');

        $arguments = [
            'command' => 'sp:fixture-dumper:orm',
            '--format' => 'yml',
            '--em' => $entityManagerName,
            '--filter' => $entityToDump,
            '--no-interaction' => true,
            '--force' => true,
            'path' => $destinationPath,
        ];

        $input = new ArrayInput($arguments);
        $command->run($input, $output);
    }
}
