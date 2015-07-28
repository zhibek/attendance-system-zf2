<?php

/**
 * Description of Department
 *
 * @author ahmed
 */
class Settings_Model_Department
{

    protected $repository;

    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
        $this->repository = $em->getRepository('Attendance\Entity\Department');
    }

    public function listDepartments()
    {
        $departments = $this->repository->findAll();
        foreach ($departments as $dep) {
            switch ($dep->manager) {
                case Null:
                    $bran->manager      = (object)$bran->manager;
                    $dep->manager->name = "Manager Manager" ;
                    break;
            }
            $bran->manager = (object)$bran->manager;
            $dep->manager  = $dep->manager->name;
            switch ($dep->status) {
                case Attendance\Entity\Department::STATUS_ACTIVE :
                    $dep->status = 'Active';
                    $dep->active = TRUE;
                    break;
                case Attendance\Entity\Department::STATUS_DELETED :
                    $dep->status = 'Deleted';
                    $dep->active = FALSE;
                    break;
            }
        }
        return $departments;
    }

    public function newDepartment($departmentInfo)
    {

        $entity = new Attendance\Entity\Department();
        $entity->name = $departmentInfo['name'];
        $entity->description = $departmentInfo['description'];
        $entity->address = $departmentInfo['address'];
        $UserRepository = $this->_em->getRepository('Attendance\Entity\User');
        $entity->manager = $UserRepository->find($departmentInfo['manager']);
//        INSERT statements are not allowed in DQL, because entities and their
//        relations have to be introduced into the persistence context
//        through EntityManager#persist() to ensure consistency of your object model.
        $entity->status = 1;
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivateDepartment()
    {
        $id = $this->_request->getParam('id');
        $entity = $this->repository->find($id);
        $entity->status = 2;
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $result=$this->repository->findBy(array('id'=>$id));
        // here i do not need to fill the drop down menu with managers 
        // so i let the form fill'm for me
        unset($result[0]->manager);
        $form->populate((array) $result[0]);
    }

    public function updateDepartment($departmentInfo)
    {
        $entity = new Attendance\Entity\Department();
        $entity->id = $departmentInfo['id'];
        $entity->name = $departmentInfo['name'];
        $entity->description = $departmentInfo['description'];
        $entity->manager=$departmentInfo['manager'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Department v SET v.name=?1,'
                . ' v.description=?2 , v.manager=?3  WHERE v.id = ?4');
        $updatequery->setParameter(1, $entity->name);
        $updatequery->setParameter(2, $entity->description);
        $updatequery->setParameter(3, $entity->manager);
        $updatequery->setParameter(4, $entity->id);
        $updatequery->execute();
    }

}
