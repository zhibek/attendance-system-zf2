<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_Model_User
{

    protected $paginator = NULL;
    protected $numberPerPage = 10.0;

    public function __construct($em)
    {
        $repository = $em->getRepository('Attendance\Entity\User');
        $this->paginator = new Zend_Paginator(new Attendance_Paginator_Doctrine($repository));
    }

    public function setPage($currentPage)
    {
        $this->paginator->setCurrentPageNumber($currentPage);
    }

    public function setNumberPerPage($numberPerPage)
    {
        $this->numberPerPage = $numberPerPage;
    }

    public function setItemCountPerPage($numberPerPage)
    {
        $this->paginator->setItemCountPerPage($numberPerPage);
    }

    public function getNumberOfPages()
    {
        return (int) $this->paginator->count();
    }

    public function getCurrentItems()
    {
        return $this->paginator;
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();

        $form->populate((array) $result[0]);
    }

    public function editUser($userInfo)
    {
        $entity = new Attendance\Entity\User();
        $entity->id = $userInfo['id'];
        $entity->name = $userInfo['name'];
        $entity->username = $userInfo['userName'];
        $entity->password = $userInfo['password'];
        $entity->mobile = $userInfo['mobile'];
        $entity->manager = $userInfo['manager'];
        $entity->dateOfBirth = $userInfo['dateOfBirth'];
        $entity->startDate = $userInfo['startDate'];
        $entity->maritalStatus = $userInfo['maritalStatus'];
        $entity->description = $userInfo['description'];
        $entity->position = $userInfo['position'];
        $entity->branch = $userInfo['branch'];
        $entity->department = $userInfo['department'];
        $entity->photo = $userInfo['photo'];


        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\User u SET '
            . ' u.name = ?1, u.username = ?2  , u.password = ?3 , u.mobile = ?4 , u.manager = ?5, '
            . ' u.dateOfBirth = ?6 , u.startDate = ?7 , u.maritalStatus = ?8 ,'
            . ' u.description = ?9 , u.position = ?10 , u.branch = ?11 , u.department = ?12,'
            . ' u.photo =?13'
            . ' WHERE v.id = ?14');

        $updatequery->setParameter(1, $entity->name);
        $updatequery->setParameter(2, $entity->username);
        $updatequery->setParameter(3, $entity->password);
        $updatequery->setParameter(4, $entity->mobile);
        $updatequery->setParameter(5, $entity->manager);
        $updatequery->setParameter(6, $entity->dateOfBirth);
        $updatequery->setParameter(7, $entity->startDate);
        $updatequery->setParameter(8, $entity->maritalStatus);
        $updatequery->setParameter(9, $entity->description);
        $updatequery->setParameter(10, $entity->position);
        $updatequery->setParameter(11, $entity->branch);
        $updatequery->setParameter(12, $entity->department);
        $updatequery->setParameter(13, $entity->photo);
        $updatequery->setParameter(14, $entity->id);
        $updatequery->execute();
    }

}
