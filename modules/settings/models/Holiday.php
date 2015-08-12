<?php

/**
 * Description of Vacation
 *
 * @author ahmed
 */
class Settings_Model_Holiday
{
    protected $repository;

    public function init()
    {
        // something  
    }

    public function __construct($em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('Attendance\Entity\Holiday');
        
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
        $result->active = 0;
        $this->entityManager->merge($result);
        $this->entityManager->flush();
    }

    public function listAll()
    {
        return $this->repository->findBy(array('active' => 1));
    }
    
    public function filterByYear($year)
    {
//       
        $query = $this->entityManager->createQuery('Select v FROM Attendance\Entity\Holiday  v WHERE v.dateFrom BETWEEN :year AND :yearPlus');
        $query->setParameter('year',$year.'-1-1' );
        $query->setParameter('yearPlus', new DateTime(($year+1).'-1-1') );
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

    public function allHoliday($holidayList) {
        $allevents = array();
        foreach ($holidayList as $holiday) {
            $events['id']     = $holiday->id;
            $events['title']  = $holiday->name;
            $events['start']  = date_format($holiday->dateFrom, 'Y-m-d');
            $events['end']    = date_format($holiday->dateFrom, 'Y-m-d');
            $events['allDay'] = FALSE;
            array_push($allevents, $events);
        }
        return $allevents;
    }

}
