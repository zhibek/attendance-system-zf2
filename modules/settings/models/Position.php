<?php

/**
 * Description of Position
 *
 * @author ahmed
 */
class Settings_Model_Position
{

    protected $repository;

    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
        $this->repository = $em->getRepository('Attendance\Entity\Position');
    }

    public function listPositions()
    {
        return $this->repository->findAll();
    }

    public function newPosition($positionInfo)
    {
        $entity = new Attendance\Entity\Position();
        $entity->name = $positionInfo['name'];
        $entity->description = $positionInfo['description'];
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivatePosition()
    {
        $id = $this->_request->getParam('id');
        $entity = $this->repository->find($id);
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Position  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        $form->populate((array) $result[0]);
    }

    public function updatePosition($positionInfo)
    {
        $entity = new Attendance\Entity\Position();
        $entity->id = $positionInfo['id'];
        $entity->name = $positionInfo['name'];
        $entity->description = $positionInfo['description'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Position v SET v.name=?1,'
                . ' v.description=?2   WHERE v.id = ?3');
        $updatequery->setParameter(1, $entity->name);
        $updatequery->setParameter(2, $entity->description);
        $updatequery->setParameter(3, $entity->id);
        $updatequery->execute();
    }

}
