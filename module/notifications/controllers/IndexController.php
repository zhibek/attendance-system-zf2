<?php

class Notifications_IndexController extends Zend_Controller_Action
{

    protected $entityManager;

    public function init()
    {
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->Model = new Notifications_Model_Notifications($this->entityManager);
    }

    public function indexAction()
    {
        $storage = Zend_Auth::getInstance()->getIdentity();
        $userUnSeenNotifications =$this->Model->listUnSeenNotifications($storage['id']);
        $this->view->unseenNotification = $userUnSeenNotifications;
        $userSeenNotifications = $this->Model->listSeenNotifications($storage['id']);
        $this->view->seenNotification = $userSeenNotifications;
    }

    public function seenAction()
    {
        $this->Model->seenNotification($this->_request->getParam('id'));
    }

}
