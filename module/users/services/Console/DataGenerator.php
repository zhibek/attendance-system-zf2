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
        $this->insertObjectsInDatabase($entityManager, $branches);

        $positions = $loader->load('application/data/fixtures/PositionFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $positions);

        $vacations = $loader->load('application/data/fixtures/VacationFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $vacations);

        $notification = $loader->load('application/data/fixtures/NotificationFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $notification); 

        $workFromHome = $loader->load('application/data/fixtures/WorkFromHomeFixtures.yml');
        foreach ($workFromHome as $key) {
            $key->startDate = new \DateTime("now");
            $key->endDate = new \DateTime("now");
            $key->dateOfSubmission = new \DateTime('now');
        }
        $this->insertObjectsInDatabase($entityManager, $workFromHome);

        $attendance = $loader->load('application/data/fixtures/AttendanceFixtures.yml');
        foreach ($attendance as $key) {
            $key->startTime = new \DateTime("now");
            $key->endTime = new \DateTime("now");
        }
        $this->insertObjectsInDatabase($entityManager, $attendance);

        $departments = $loader->load('application/data/fixtures/DepartmentFixtures.yml');
        $this->insertObjectsInDatabase($entityManager, $departments);

        $users = $loader->load('application/data/fixtures/UserFixtures.yml');
        // append a date object for every user object
        foreach ($users as $object) {
            if (isset($object->password))
                $object->password = \Attendance\Entity\User::hashPassword($object->password);
            $object->manager = $users['user26'];
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            $object->branch = $branches['branch1']; //$repository->find(1);
            $object->position = $positions['position1'];
            $object->department = $departments['department1'];
        }
        $this->insertObjectsInDatabase($entityManager, $users);

        $holidays = $loader->load('application/data/fixtures/HolidayFixtures.yml');
        // append a date object for every user object
        foreach ($holidays as $object) {
            $randomDate = new \DateTime($object->dateFrom);
            $object->dateFrom = clone $randomDate;
            $randomDate1 = new \DateTime($object->dateTo);
            $object->dateTo = clone $randomDate1;
        }
        $this->insertObjectsInDatabase($entityManager, $holidays);

        $permissions = $loader->load('application/data/fixtures/PermissionFixtures.yml');
        foreach ($permissions as $key) {
            $key->user = $users['user23'];
            $key->date = new \DateTime($key->date);
            $key->fromTime = new \DateTime($key->fromTime);
            $key->toTime = clone $key->fromTime;
            $key->toTime->modify('+' . rand(1, 8) . ' hour');
            $key->dateOfSubmission = new \DateTime($key->dateOfSubmission);
        }
        $this->insertObjectsInDatabase($entityManager, $permissions);

        $attendanceRecords = $loader->load('application/data/fixtures/AttendanceRecordFixtures.yml');

        foreach ($attendanceRecords as $key) {
            $key->branch = $branches['branch1'];
            $key->user = $users['user26'];
            $key->timeOut = clone $key->timeIn;
            $key->timeOut->modify('+' . rand(1, 8) . ' hour');
        }

        $this->insertObjectsInDatabase($entityManager, $attendanceRecords);

        $comments = $loader->load('application/data/fixtures/CommentFixtures.yml');

        foreach ($comments as $key) {
            $key->branch = $branches['branch1'];
            $key->user = $users['user' . $key->user];
            $key->created = new \DateTime($key->created);
        }

        $this->insertObjectsInDatabase($entityManager, $comments);

        $entityManager->flush();

        $output->writeln('Data Added');
    }

    private function insertObjectsInDatabase($entityManager, $objectsToInsert)
    {
        foreach ($objectsToInsert as $object) {
            $entityManager->persist($object);
        }
    }

}
