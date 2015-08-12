<?php

/**
 * Description of Vacation
 *
 * @author ahmed
 */
class Myattendance_Model_AttendanceRecord
{
    protected $repository;

    public function init()
    {
        // something  
    }

    public function __construct($em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('Attendance\Entity\AttendanceRecord');
        
    }

    public function newHoliday($holidayInfo)
    {
        $entity = $this->createEntity($holidayInfo);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function deactivateHoilday($id)
    {
        $result = $this->repository->find($id);
        $this->entityManager->remove($result);
        $this->entityManager->flush();
    }

    public function listAll()
    {
        return $this->repository->findAll();
    }
    
    public function filterByYear($dateFrom,$dateTo,$id)
    {
//       
        $query = $this->entityManager->createQuery('Select v FROM Attendance\Entity\AttendanceRecord  v WHERE v.timeIn BETWEEN :dateFrom AND :dateTo AND v.user = :id ');
        $query->setParameter('dateFrom',date("Y-m-d", strtotime($dateFrom)) );
        $query->setParameter('dateTo',date("Y-m-d", strtotime($dateTo)));
        $query->setParameter('id',$id);
        return $query->execute();
        
    }

    public function populateForm($form,$id)
    {
        
        $result = $this->repository->find($id);
        $result->dateFrom = date_format($result->dateFrom, 'm/d/Y');
        $result->dateTo = date_format($result->dateTo, 'm/d/Y');
        $form->populate((array)$result);
    }

    public function updateHoliday($holidayInfo)
    {
        $entity = $this->createEntity($holidayInfo);
        
        $entity->id = $holidayInfo['id'];
        
        $this->entityManager->merge($entity);
        $this->entityManager->flush();
    }
    
    private function createEntity($holidayInfo)
    {
        $entity = new Attendance\Entity\Holiday();
        $entity->name = $holidayInfo['name'];
        $entity->dateFrom = new DateTime($holidayInfo['dateFrom']) ;
        $entity->dateTo =  new DateTime($holidayInfo['dateTo']) ;
        return $entity;
    }

}
