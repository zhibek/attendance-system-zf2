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
        $attendances = $repository->findBy(array('active' => 1));
        foreach ($attendances as $key) {
            $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Branch  v WHERE v.id = ?1')->setParameter(1, $key->branch);
            $result = $query->execute();
            $key->branch = $result[0]->name;
            $key->startTime = date_format($key->startTime, 'H:i:s');
            $key->endTime = date_format($key->endTime, 'H:i:s');
        }

        return $attendances;
    }

    public function newAttendance($attendanceInfo)
    {
        $entity = new Attendance\Entity\Attendance();
        $entity->branch = $attendanceInfo['branch'];
        $attendanceInfo['startTime'] = new DateTime($attendanceInfo['startTime']);
        $entity->startTime = $attendanceInfo['startTime'];
        $attendanceInfo['endTime'] = new DateTime($attendanceInfo['endTime']);
        $entity->endTime = $attendanceInfo['endTime'];

//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivateAttendance()
    {
        $id = $this->_request->getParam('id');
        $repository = $this->_em->getRepository('Attendance\Entity\Attendance');
        $entity = $repository->find($id);
        $entity->active = 0;
        $this->_em->merge($entity);
        $this->_em->flush();
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Attendance  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        $result[0]->startTime = date_format($result[0]->startTime, 'H:i:s');
        $result[0]->endTime = date_format($result[0]->endTime, 'H:i:s');
        unset($result->branch);
        $form->populate((array) $result[0]);
    }

    public function updateAttendance($attendanceInfo)
    {
        $entity = new Attendance\Entity\Attendance();
        $entity->id = $attendanceInfo['id'];
        $entity->branch = $attendanceInfo['branch'];
        $entity->startTime = $attendanceInfo['startTime'];
        $entity->endTime = $attendanceInfo['endTime'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Attendance v SET v.branch=?1,'
                . ' v.startTime=?2  , v.endTime=?3 WHERE v.id = ?4');
        $updatequery->setParameter(1, $entity->branch);
        $updatequery->setParameter(2, $entity->startTime);
        $updatequery->setParameter(3, $entity->endTime);
        $updatequery->setParameter(4, $entity->id);
        $updatequery->execute();
    }

}
