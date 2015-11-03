<?php

namespace Visca\Bundle\LicomViewBundle\Command\Translations;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;

/** * Class CountryCachingTranslationsCommand.
 */
class CountryCachingTranslationsCommand extends AbstractTranslationsCommand
{
    const ENTITY = EntityCode::COUNTRY_CODE;
    const ENTITY_NAME = 'Country';

    protected $properties = [
        13 => ProfileTranslationGraphLabelCode::NAME_CODE,
        24 => ProfileTranslationGraphLabelCode::DEMONYMS_MALE_SIN_CODE,
        25 => ProfileTranslationGraphLabelCode::DEMONYMS_MALE_PLU_CODE,
        26 => ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_SIN_CODE,
        27 => ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_PLU_CODE,
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:caching:country-translations')
            ->setDescription('Save country translations in cache')
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                'Limit to import'
            )
        ;
    }

    /**
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Welcome to the Licom Country Caching save translatios in cache command.</info>');
        $progress = new ProgressBar($output);
        $limit = $input->getOption('limit');
        $entities = $this
            ->getContainer()
            ->get('visca_licom.repository.country')
            ->getAllIds($limit);

        $this->generateAllTranslations($entities, $progress);
        $progress->finish();
        $output->writeln('<info>End of command.</info>');
    }
}
