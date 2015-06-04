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
//        $attendanceInfo=0
        foreach ($attendances[0] as $key => $value) {
            $attendanceInfo->id = $attendances[0]->id;
            $attendanceInfo->branch = $attendances[0]->branch;
            $attendanceInfo->startDate = date_format($attendances[0]->startDate, 'H:i:s');
            $attendanceInfo->endDate = date_format($attendances[0]->endDate, 'H:i:s');
        }
        return $attendanceInfo;
    }

    public function newAttendance($attendanceInfo)
    {
        $entity = new Attendance\Entity\Attendance();
        $entity->type = $attendanceInfo['branch'];
        $entity->description = $attendanceInfo['startDate'];
        $entity->balance = $attendanceInfo['endDate'];
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

}
