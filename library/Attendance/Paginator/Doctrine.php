<?php

class Attendance_Paginator_Doctrine implements Zend_Paginator_Adapter_Interface
{
    protected $repository;
    
    public function __construct( $db)
    {
        $this->repository = $db;
    }
    
    public function count($mode = 'COUNT_NORMAL') {
        
        return (int)$this->repository->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
                
    }

    public function getItems($offset, $itemCountPerPage) {
        return  $this->repository->findBy(array(),null,$itemCountPerPage, $offset);//($pageNumber-1) for zero based count
    }

}