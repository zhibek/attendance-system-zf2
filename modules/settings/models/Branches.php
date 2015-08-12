<?php

/**
 * Description of Position
 *
 * @author AbdEl-Moneim
 */
class Settings_Model_Branches
{
    protected $repository;

    public function __construct($em, $request = null)
    {
        $this->_em        = $em;
        $this->_request   = $request;
        $this->repository = $this->_em->getRepository('Attendance\Entity\Branch');
    }

    public function BranchStatus()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\Branch');
        $data       = $repository->findAll();
        return $this->prepareForDisplay($data);
    }

    public function listBranches()
    {
        $branches= $this->repository->findAll();
        foreach ($branches as $bran) {
            switch ($bran->manager) {
                case Null:
                    $bran->manager       =(object)$bran->manager;
                    $bran->manager->name = "Manager manager" ;
                    break;
            }
            $bran->manager =(object)$bran->manager;
            $bran->manager = $bran->manager->name;
            if ($bran->status == 'Active') {
                 $bran->active = TRUE;
            }
        }
        return $branches;
    }

    public function newBranches($branchesInfo)
    {
        $entity      = new Attendance\Entity\Branch();
        $thisManager = $this->_em->getRepository('\Attendance\Entity\User')->find($branchesInfo['manager']);
        $entity->name        = $branchesInfo['name'];
        $entity->description = $branchesInfo['description'];
        $entity->address     = $branchesInfo['address'];
        $entity->manager     = $thisManager;
        $entity->status      = \Attendance\Entity\Branch::STATUS_ACTIVE;
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivateBranches()
    {
        $id     = $this->_request->getParam('id');
        $entity = $this->repository->find($id);
        $entity->status = Attendance\Entity\Branch::STATUS_INACTIVE;
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function populateForm($form)
    {
        $id     = $this->_request->getParam('id');
        $result = $this->repository->findBy(array('id'=>$id));
        unset($result[0]->manager);
        $form->populate((array) $result[0]);
    }

    public function updateBranches($branchesInfo)
    {
        $entity = new Attendance\Entity\Branch();
        $entity->id          = $branchesInfo['id'];
        $entity->name        = $branchesInfo['name'];
        $entity->description = $branchesInfo['description'];
        $entity->address     = $branchesInfo['address'];
        $entity->manager     = $branchesInfo['manager'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Branch v SET v.name=?1,'
                . ' v.description=?2 ,v.address=?3 , v.manager=?4  WHERE v.id = ?5');
        $updatequery->setParameter(1, $entity->name);
        $updatequery->setParameter(2, $entity->description);
        $updatequery->setParameter(3, $entity->address);
        $updatequery->setParameter(4, $entity->manager);
        $updatequery->setParameter(5, $entity->id);
        $updatequery->execute();
    }

    private function prepareForDisplay($data)
    {
        foreach ($data as $key) {
            switch ($key->status) {
                case Attendance\Entity\Branch::STATUS_ACTIVE :
                    $key->status = 'Active';
                    break;
                    case Attendance\Entity\Branch::STATUS_INACTIVE :
                    $key->status = 'InActive';
                    break;
            }
        }
        return $data;
    }
}
