<?php

/**
 * A command that uses the Alice data-generator to generate testing data 
 * 
 * Run using:
 * bin/cli schema:data-generate
 *
 * 
 * Note : please make use there is no 'CS Departement' in the department 
 * database table, so as not to violate any constrains
 * 
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
            $object->password = password_hash($object->password, PASSWORD_BCRYPT);
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            $object->branch = $branches['branch1']; //$repository->find(1);
            $object->position = $positions['position1'];
            $object->department = $departments['department1'];
        }
        
        $this->insertObjectsInDatabase($entityManager , $users);
        
        $holidays = $loader->load('application/data/fixtures/HolidayFixtures.yml');
        
        // append a date object for every user object
        foreach($holidays as $object)
        {
            $object->password = password_hash($object->password, PASSWORD_BCRYPT);
            
            $object->dateFrom = new \DateTime("now");
            $object->dateTo = new \DateTime("now");
            
        }
        
        $this->insertObjectsInDatabase($entityManager , $holidays);
        
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
