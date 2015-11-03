<?php

namespace Visca\Bundle\LicomViewBundle\Command\Translations;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CachingAllTranslationsCommand.
 */
class CachingAllTranslationsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:caching:all-translations')
            ->setDescription('Save all translations in cache')
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                'Limit to import'
            );
    }

    /**
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = $input->getOption('limit');
        $this->competitionTranslations($limit, $output);
        $this->competitionCategoryTranslations($limit, $output);
        $this->competitionLegTranslations($limit, $output);
        $this->competitionRoundTranslations($limit, $output);
        $this->competitionStageTranslations($limit, $output);
        $this->countryTranslations($limit, $output);
        $this->matchIncidentTranslations($limit, $output);
        $this->matchStatusDescriptionTranslations($limit, $output);
        $this->participantTranslations($limit, $output);
        $this->sportTranslations($limit, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function sportTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:sport-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:sport-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function participantTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:participant-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:paticipant-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function matchStatusDescriptionTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:match-status-description-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:match-status-description-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function matchIncidentTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:match-incident-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:match-incident-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function competitionTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:competition-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:competition-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function competitionCategoryTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:competition-category-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:competition-category-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function competitionLegTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:competition-leg-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:competition-leg-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function competitionRoundTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:competition-round-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:competition-round-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function competitionStageTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:competition-stage-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:competition-stage-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }

    /**
     * @param int             $limit  Limit
     * @param OutputInterface $output Output
     *
     * @throws \Exception
     */
    private function countryTranslations($limit, OutputInterface $output)
    {
        $command = $this->getApplication()->find('visca:licom:caching:country-translations');
        $arguments = array(
            'command' => 'visca:licom:caching:country-translations',
            '--limit' => $limit,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
    }
}
