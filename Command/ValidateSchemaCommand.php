<?php

namespace Visca\Bundle\LicomBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Visca\Bundle\LicomBundle\Schema\Loader;
use Visca\Bundle\LicomBundle\Schema\Validation\SchemaValidator;

/**
 * Class ValidateSchemaCommand.
 */
class ValidateSchemaCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('visca:licom:schema:validate')
            ->setDescription('Validate the schema')
            ->addArgument(
                'host',
                InputArgument::REQUIRED
            )->addArgument(
                'user',
                InputArgument::REQUIRED
            )->addArgument(
                'password',
                InputArgument::REQUIRED
            )->addArgument(
                'database',
                InputArgument::REQUIRED
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();

        $xmlDefinition = $loader->load(
            $input->getArgument('host'),
            $input->getArgument('user'),
            $input->getArgument('password'),
            $input->getArgument('database')
        );

        $schemaValidator = new SchemaValidator();
        $report = $schemaValidator->validate($xmlDefinition);

        if (count($report) > 0) {
            $output->write(print_r($report), true);
        }
    }
}
