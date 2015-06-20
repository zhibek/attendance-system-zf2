<?php

class Default_Model_UserAuth
{

    public function __construct($request, $em)
    {
        $this->request = $request;
        $this->em = $em;
    }

    public function authenticateMe()
    {
        //get value of username from post
        $username = $this->request->getParam('username');
        // get value of password from post
        $password = $this->request->getParam('password');
        // hashing password to compare
        $adapter = new Default_Service_Auth_Adapter($this->em, "Attendance/Entity/User", "username", "password");
        $adapter->setIdentity($username);
        $adapter->setCredential($password);
        $result = $adapter->authenticate();

        return $result;
    }

    public function newSession()
    {
        $repository = $this->em->getRepository('Attendance\Entity\User');
        $entities = $repository->findBy(array(
            'username' => $this->request->getParam('username'),
        ));
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $storage->write(array(
            'id' => $entities[0]->id,
            'name' => $entities[0]->name,
            'username' => $entities[0]->username,
            'photo' => $entities[0]->photo,
            'role' => $entities[0]->role
        ));
    }

}
