<?php

namespace Visca\Bundle\LicomViewBundle\Command\Translations;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;

/**
 * Class ParticipantCachingTranslationsCommand.
 */
class ParticipantCachingTranslationsCommand extends AbstractTranslationsCommand
{
    const ENTITY = EntityCode::PARTICIPANT_CODE;
    const ENTITY_NAME = 'Participant';

    protected $properties = [
        11 => ProfileTranslationGraphLabelCode::NAME_CODE,
        31 => ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
        21 => ProfileTranslationGraphLabelCode::TRIGRAPH_CODE,
        //TODO add all nicknames and all demonyms
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:caching:participant-translations')
            ->setDescription('Save participant translations in cache')
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
        $output->writeln('<info>Welcome to the Licom Participant Caching save translatios in cache command.</info>');
        $progress = new ProgressBar($output);
        $limit = $input->getOption('limit');
        $entities = $this
            ->getContainer()
            ->get('visca_licom.repository.participant')
            ->getAllIds($limit);

        $this->generateAllTranslations($entities, $progress);
        $progress->finish();
        $output->writeln('<info>End of command.</info>');
    }
}
