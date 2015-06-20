<?php

/**
 * Description of Myrequests
 *
 * @author Mohamed Ramadan
 */
class Requests_Model_Comment
{
    
    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
        $this->repository = $em->getRepository('Attendance\Entity\Permission');
    }
    
     public function addComment($commentInfo,$requestId)
    {
        $entity = new Attendance\Entity\Comment();
        $userRepository = $this->_em->getRepository('Attendance\Entity\User');
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $userId = $storage->read('id');
        var_dump($userRepository->find($userId));exit();
        $entity->user = $userRepository->find($userId);
        $entity->body = $commentInfo['comment'];
        $entity->request_id = $requestId;
        $entity->request_type = 2;
        $entity->created = new DateTime("now");
        $this->_em->persist($entity);
        $this->_em->flush(); 
    }
    
   
    public function listAllComments()
    {
        $data = $this->repository->findAll();
        return $data;
    }
        
    
    
}
