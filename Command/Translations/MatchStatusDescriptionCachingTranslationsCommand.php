<?php

namespace Visca\Bundle\LicomViewBundle\Command\Translations;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;

/**
 * Class MatchStatusDescriptionCachingTranslationsCommand.
 */
class MatchStatusDescriptionCachingTranslationsCommand extends AbstractTranslationsCommand
{
    const ENTITY = EntityCode::MATCH_STATUS_DESCRIPTION_CODE;
    const ENTITY_NAME = 'Match Status Description';

    protected $properties = [
        4 => ProfileTranslationGraphLabelCode::NAME_CODE,
        32 => ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:caching:match-status-description-translations')
            ->setDescription('Save match status description translations in cache')
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
        $output->writeln(
            '<info>Welcome to the Licom Match Status Description save translatios in cache command.</info>'
        );
        $progress = new ProgressBar($output);
        $limit = $input->getOption('limit');
        $entities = $this
            ->getContainer()
            ->get('visca_licom.repository.match_statusdescription')
            ->getAllIds($limit);

        $this->generateAllTranslations($entities, $progress);
        $progress->finish();
        $output->writeln('<info>End of command.</info>');
    }
}
