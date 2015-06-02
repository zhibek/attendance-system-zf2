<?php

Class Users_SignController extends Zend_Controller_Action {

    public function inti() {
        
    }

    public function indexAction() {
        //do something
    }

    // Sign Up action 
    public function upAction() {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Users_Form_User(array('em' => $em));  
        
        // Populate Element Branch
        $branch = $form->getElement("branch");
        $branchRepository = $em->getRepository('Attendance\Entity\Branch');
        $allBranches = $branchRepository->findAll();    
        foreach($allBranches as $b){
            $branch->addMultiOption($b->id,$b->name);
        }
        
        // Populate Element Position
        $position = $form->getElement('position');
        $positionRepository = $em->getRepository('Attendance\Entity\Position');
        $allPositions = $positionRepository->findAll();
        foreach($allPositions as $p){
            $position->addMultiOption($p->id,$p->name);
        }
        
        // Populate Element Manager
        $manager = $form->getElement('manager');
        $managerRepository = $em->getRepository('Attendance\Entity\User');
        $allManagers = $managerRepository->findAll();
        foreach($allManagers as $m){
            $manager->addMultiOption($m->id,$m->name);
        }
        
        // Populate Element Departments
        $department = $form->getElement('department');
        $departmentRepository = $em->getRepository('Attendance\Entity\Department');
        $allDepartments = $departmentRepository->findAll();
        foreach($allDepartments as $d)
        {
            $department->addMultiOption($d->id,$d->name);
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            // checking if the form is valid
            if ($form->isValid($request->getPost())) {     
                $userInfo = $this->_request->getParams();
                $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
                $entity = new Attendance\Entity\User();
                $entity->username = $userInfo['userName'];
                    $entity->name = $userInfo['name'];
                    $entity->password = md5($userInfo['password']);
                    $dateString = $userInfo['dateOfBirth'];
                    $date = new DateTime($dateString); 
                    $entity->dateOfBirth= $date;
                    $entity->mobile = $userInfo['mobile'];
                    $entity->description = $userInfo['description'];
                    $thisPosition = $em->getRepository('\Attendance\Entity\Position')->find($userInfo['position']);
                    $entity->position = $thisPosition;

                    $startDateString= $userInfo['startDate'];
                    $startDateObj = new DateTime($startDateString);
                    $entity->startDate= $startDateObj;
                    $entity->maritalStatus = $userInfo['maritalStatus'];
                    $thisBranch = $em->getRepository("\Attendance\Entity\Branch")->find($userInfo["branch"]);
                    $entity->branch = $thisBranch;   
                    $entity->department = new Attendance\Entity\Department('department');    
                    $thisDepartment = $em->getRepository('\Attendance\Entity\Department')->find($userInfo['department']);
                    $entity->department=$thisDepartment;   
                    
                    $entity->manager = new Attendance\Entity\User('manager');    
                    $thisManager = $em->getRepository('\Attendance\Entity\User')->find($userInfo['manager']);
                    $entity->manager=$thisManager; 
                    
                    $entity->vacationBalance = 21;
                    $entity->totalWorkingHoursThisMonth=0;
                    $entity->photo = $this->savePhoto();
                        
                $em->persist($entity);
                $em->flush();   
            }   
        }
        $this->view->userForm = $form;    
    }
    
    private function savePhoto()
    {
        $domain = "http://attendance.local";
        
        $upload = new Zend_File_Transfer_Adapter_Http();

        
        $imagesPath = APPLICATION_PATH.'/../public/upload/images/';
        
        $upload->setDestination($imagesPath);

        try {
        // upload received file(s)
            $upload->receive();
        } catch (Zend_File_Transfer_Exception $e) {
            $e->getMessage();
        }

        $name = $upload->getFileName('picture');

        $extention = pathinfo($name, PATHINFO_EXTENSION); 
        //$fileName = pathinfo($name, PATHINFO_FILENAME);
        
        //get random new name
        $newName = $this->getRandomName().uniqid();
        
        
        rename($name, APPLICATION_PATH . '/../public/upload/images/'.$newName.'.'.$extention); 
      
        
        return $domain.'/upload/images/'.$newName.'.'.$extention;
        
    }
    
    private function getRandomName()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
        .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        .'0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $cid= substr(implode('', $seed), 1, 51);
        
        
        return $cid;
    }


    
    
    
     public function editAction() {
         
        $form = new Users_Form_User();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $userModel = new Users_Model_User($em, $request);
        $userModel->populateForm($form);
        
        $this->view->editForm = $form;
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $userInfo = $this->_request->getParams();
                $userModel->editUser($userInfo);
                $this->redirect('/users/user/index');
            }
        }
         $this->view->userForm = $form; 
         
     }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}