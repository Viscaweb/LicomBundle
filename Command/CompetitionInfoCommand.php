<?php

namespace Visca\Bundle\LicomBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;

/**
 * Class CompetitionInfoCommand.
 */
class CompetitionInfoCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:competition:info')
            ->setDescription('Show information about a competition')
            ->addArgument(
                'competition',
                InputArgument::REQUIRED,
                'The competition id'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Competition $competition */
        $competition = $this
            ->getContainer()
            ->get('visca_licom.repository.competition')
            ->find($input->getArgument('competition'));

        $output->writeln($competition->getName());

        $seasons = $competition->getCompetitionSeason();
        foreach ($seasons as $season) {
            $output->writeln(
                sprintf('%sSeason: %s', str_repeat(' ', 4), $season->getName())
            );

            /** @var CompetitionSeasonStage[] $seasonStages */
            $seasonStages = $season->getCompetitionSeasonStage();
            foreach ($seasonStages as $seasonStage) {
                $output->writeln(
                    sprintf(
                        '%sStage: %s',
                        str_repeat(' ', 8),
                        $seasonStage->getCompetitionStage()->getName()
                    )
                );

                /** @var CompetitionRound[] $rounds */
                $rounds = $seasonStage->getCompetitionRound();
                foreach ($rounds as $round) {
                    $output->writeln(
                        sprintf(
                            '%sRound: %s',
                            str_repeat(' ', 12),
                            $round->getName()
                        )
                    );

                    /** @var CompetitionLeg[] $legs */
                    $legs = $round->getCompetitionLeg();
                    foreach ($legs as $leg) {
                        $output->writeln(
                            sprintf(
                                '%sLeg: %s',
                                str_repeat(' ', 16),
                                $leg->getName()
                            )
                        );
                    }
                }
            }
        }
    }
}
