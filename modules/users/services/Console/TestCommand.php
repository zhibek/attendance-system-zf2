<?php

/**
 * A test command
 *
 * Run using:
 * bin/cli test:example
 *
 * Adapt this command to do what you require (and rename appropriately).
 *
 * New commands need to be added to the list in <root>/cli-commands.php
 * before they will be included in the command setup.
 */

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class Users_Service_Console_TestCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:example')
            ->setDescription('A test to show how to structure a command')
            ->setHelp(<<<EOT
This test command shows how to structure a command - please change the name, description and help text...
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $this->getHelper('em')->getEntityManager();

        // do nothing so far - just an example of how to structure a command
        $output->writeln('TEST');
   }

}