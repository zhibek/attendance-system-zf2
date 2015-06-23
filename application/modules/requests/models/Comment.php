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
        $this->repository = $em->getRepository('Attendance\Entity\Comment');
    }

    public function addComment($commentInfo, $requestId, $requestType)
    {
        $entity = new Attendance\Entity\Comment();

        $userRepository = $this->_em->getRepository('Attendance\Entity\User');

        $storage = Zend_Auth::getInstance()->getIdentity();

        $userId = $storage['id'];


        $entity->user = $userRepository->find($userId);


        $entity->body = $commentInfo['comment'];
        $entity->request_id = $requestId;
        $entity->request_type = $requestType;
        $entity->created = new DateTime("now");

        $this->_em->persist($entity);
        $this->_em->flush($entity);
    }

    public function listRequestComments($requestId , $requestType)
    {
       
        $query = $this->_em->createQuery('Select c FROM Attendance\Entity\Comment  c WHERE c.request_id = ?1 AND c.request_type = ?2');
        $query->setParameter(1, $requestId);
        $query->setParameter(2, $requestType);
        $result = $query->execute();
        
        foreach ($result as $rslt) {
            $rslt->created = date_format($rslt->created, 'Y-M-D H:i:s');
            $rslt->user = $this->getUserNameById($rslt->user);
        }
        return $result;
    }

    public function getCommentCreatorId($commentId)
    {
        $data = $this->repository->find($commentId);   
        return $data;
    }
    
    public function getcommentUserId($usrId)
    {
        $query = $this->_em->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $usrId);
        $result = $query->execute();
        return $result[0]->id;
    }

    public function getcommentRequestId($commentId)
    {
        $query = $this->_em->createQuery('Select c FROM Attendance\Entity\Comment  c WHERE c.id = ?1');
        $query->setParameter(1, $commentId);
        $result = $query->execute();

        return $result[0]->request_id;
    }

    public function deleteComment($commentId)
    {
        $query = $this->_em->createQuery('Delete FROM Attendance\Entity\Comment  c WHERE c.id = ?1');
        $query->setParameter(1, $commentId);
        $query->execute();
    }

    function getUserNameById($id)
    {
        $query = $this->_em->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        return $result[0]->name;
    }

}
