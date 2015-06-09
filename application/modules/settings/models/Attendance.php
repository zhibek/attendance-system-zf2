<?php

/**
 * Description of Attendance
 *
 * @author ahmed
 */
class Settings_Model_Attendance
{

    public function init()
    {
        // something  
    }

    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
    }

    public function listAttendances()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\Attendance');
        $attendances = $repository->findAll();
        foreach ($attendances as $key) {
            $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Branch  v WHERE v.id = ?1')->setParameter(1, $key->branch);
            $result = $query->execute();
            $key->branch = $result[0]->name;
        }

        return $attendances;
    }

    public function newAttendance($attendanceInfo)
    {
        $entity = new Attendance\Entity\Attendance();
        $entity->branch = $attendanceInfo['branch'];
        $entity->startDate = $attendanceInfo['startdate'];
        $entity->endDate = $attendanceInfo['enddate'];

//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivateVacation()
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('DELETE FROM Attendance\Entity\Attendance  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $query->execute();
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Attendance  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        unset($result->branch);
        $form->populate((array) $result[0]);
    }

    public function updateAttendance($attendanceInfo)
    {
        $entity = new Attendance\Entity\Attendance();
        $entity->id = $attendanceInfo['id'];
        $entity->branch = $attendanceInfo['branch'];
        $entity->startDate = $attendanceInfo['startdate'];
        $entity->endDate = $attendanceInfo['enddate'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Attendance v SET v.branch=?1,'
                . ' v.startDate=?2  , v.endDate=?3 WHERE v.id = ?4');
        $updatequery->setParameter(1, $entity->branch);
        $updatequery->setParameter(2, $entity->startDate);
        $updatequery->setParameter(3, $entity->endDate);
        $updatequery->setParameter(4, $entity->id);
        $updatequery->execute();
    }

}
