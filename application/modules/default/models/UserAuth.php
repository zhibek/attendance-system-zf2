<?php

class Default_Model_UserAuth {

    public function init() {
        // something  
    }
    
    public function __construct( $request , $em ) {
       $this->request=$request;
       $this->em=$em;
    }
    

    public  function authenticateMe(){
       
                //get value of username from post
                $username = $this->request->getParam('username');
                // get value of password from post
                $password = $this->request->getParam('password');
                // hashing password to compare
                
                $adapter = new Default_Service_Auth_Adapter($this->em, "Attendance/Entity/User", "username", "password");
                $adapter->setIdentity($username);
                $adapter->setCredential(md5($password));
                $result = $adapter->authenticate();

                if ($result->isValid()) {
                    //get data about user from db
                    $repository = $this->em->getRepository('Attendance\Entity\User');
                    $entities = $repository->findAll();
                    //createing new session namespace
                    $session = new Zend_Session_Namespace('session');
                    // submitting values inside $_SESSION
                    //to access session values $_SESSION['session']['name'] for ex
                    $session->id = $entities[0]->id;
                    $session->name = $entities[0]->name;
                    $session->username = $entities[0]->username;
                    $session->photo = $entities[0]->photo;
                    
                    $auth=  Default_Service_Auth_Adapter::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($entities[0]->id);
                    
                    
                    
                    
                    
//                    $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'username', 'password');
//                    $auth = Zend_Auth::getInstance();
//                    $storage = $auth->getStorage();
//                    $storage->write($authAdapter->getResultRowObject(array('id')));
                    
                   return 1;
                } else {
                    return 0;
                }
            }
    
}
