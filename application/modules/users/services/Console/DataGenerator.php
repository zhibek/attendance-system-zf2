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

class Users_Service_Console_DataGenerator extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('schema:data-generate')
            ->setDescription('Use Alice to generate testing data')
            ->setHelp(<<<EOT
This command create 10 users , 1 branche , 1 postion , 1 department
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
        
        $loader = new \Nelmio\Alice\Fixtures\Loader();
        
        $branches = $loader->load('application/data/fixtures/BranchFixtures.yml');
        
        $this->insertObjectsInDatabase($entityManager , $branches);
        
        $positions = $loader->load('application/data/fixtures/PositionFixtures.yml');
        
        $this->insertObjectsInDatabase($entityManager , $positions);
        
        $departments = $loader->load('application/data/fixtures/DepartmentFixtures.yml');
        
        $this->insertObjectsInDatabase($entityManager , $departments);
        
        $users = $loader->load('application/data/fixtures/UserFixtures.yml');
        
        // append a date object for every user object
        foreach($users as $object)
        {
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            $object->branch = $branches['branch1']; //$repository->find(1);
            $object->position = $positions['position1'];
            $object->department = $departments['department1'];
        }
        
        $this->insertObjectsInDatabase($entityManager , $users);
        
        $entityManager->flush();
        
        $output->writeln('Data Added');
   }

   private function insertObjectsInDatabase($entityManager , $objectsToInsert )
   {
       foreach($objectsToInsert as $object)
        {
            $entityManager->persist($object);
        }
   }

}