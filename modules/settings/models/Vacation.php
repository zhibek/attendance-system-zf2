<?php

/**
 * Description of Vacation
 *
 * @author ahmed
 */
class Settings_Model_Vacation
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

    public function newVacation($vacationInfo)
    {
        $entity = new Attendance\Entity\Vacation();
        $entity->type = $vacationInfo['type'];
        $entity->description = $vacationInfo['description'];
        $entity->balance = $vacationInfo['balance'];
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function deactivateVacation()
    {
        $id = $this->_request->getParam('id');
        $repository = $this->_em->getRepository('Attendance\Entity\Vacation');
        $entity = $repository->find($id);
        $entity->active = 0;
        $this->_em->merge($entity);
        $this->_em->flush();
    }

    public function listAllVacations()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\Vacation');
        $vacations = $repository->findBy(array('active' => 1));
        return $vacations;
    }

    public function populateForm($form)
    {
        $id = $this->_request->getParam('id');
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Vacation  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        $form->populate((array) $result[0]);
    }

    public function updateVacation($vacationInfo)
    {
        $entity = new Attendance\Entity\Vacation();
        $entity->id = $vacationInfo['id'];
        $entity->type = $vacationInfo['type'];
        $entity->description = $vacationInfo['description'];
        $entity->balance = $vacationInfo['balance'];
        $updatequery = $this->_em->createQuery('UPDATE Attendance\Entity\Vacation v SET v.type=?1,'
                . ' v.description=?2  , v.balance=?3 WHERE v.id = ?4');
        $updatequery->setParameter(1, $entity->type);
        $updatequery->setParameter(2, $entity->description);
        $updatequery->setParameter(3, $entity->balance);
        $updatequery->setParameter(4, $entity->id);
        $updatequery->execute();
    }

}
