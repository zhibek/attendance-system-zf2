<?php

class Users_Model_SaveUser
{

    protected $em;
    protected $request;

    public function __construct($em, $request = null)
    {
        $this->em      = $em;
        $this->request = $request;
    }

    public function saveUser($request , $userObj = null)
    {
        $userInfo = $request->getParams();
        $em       = $this->em;

        if (is_null($userObj)) {
            $entity = new Attendance\Entity\User();
        } else {
            $entity = $userObj;
        }

        $entity->username = $userInfo['username'];
        $entity->name     = $userInfo['name'];
        if (is_null($userObj)) {
            $entity->password = Attendance\Entity\User::hashPassword($userInfo['password']);
        }
        $dateString = $userInfo['dateOfBirth'];
        $date       = new DateTime($dateString);
        $entity->dateOfBirth = $date;
        $entity->mobile      = $userInfo['mobile'];
        $entity->description = $userInfo['description'];

        $thisPosition = $em->getRepository('\Attendance\Entity\Position')->find($userInfo['position']);
        $entity->position = $thisPosition;

        $startDateString = $userInfo['startDate'];
        $startDateObj    = new DateTime($startDateString);
        $entity->startDate     = $startDateObj;
        $entity->maritalStatus = $userInfo['maritalStatus'];

        $thisBranch = $em->getRepository("\Attendance\Entity\Branch")->find($userInfo["branch"]);
        $entity->branch = $thisBranch;

        $thisDepartment = $em->getRepository('\Attendance\Entity\Department')->find($userInfo['department']);
        $entity->department = $thisDepartment;

        $thisManager = $em->getRepository('\Attendance\Entity\User')->find($userInfo['manager']);
        $entity->manager = $thisManager;

        $entity->vacationBalance = \Attendance\Entity\User::DEFAULT_VACATION_BALANCE;
        $entity->totalWorkingHoursThisMonth = 0;

        $entity->role = $em->getRepository('\Attendance\Entity\Role')->find(1);

        if (is_null($userObj)) {
            $entity->photo = $this->savePhoto();
        }
        $entity->status = Attendance\Entity\User::STATUS_ACTIVE;

        $em->persist($entity);

        $em->flush();
    }

    protected function savePhoto()
    {
        $uploadResult = null;
        $upload       = new Zend_File_Transfer_Adapter_Http();
        $imagesPath   = APPLICATION_PATH . '/../public/upload/images/';
        $upload->setDestination($imagesPath);

        try {
            // upload received file(s)
            $upload->receive();
        } catch (Zend_File_Transfer_Exception $e) {
            $uploadResult = '/upload/images/defaultpic.png';
        }

        $name      = $upload->getFileName('photo');
        $extention = pathinfo($name, PATHINFO_EXTENSION);
        //get random new namez
        $newName = $this->getRandomName();

        rename($name, APPLICATION_PATH . '/../public/upload/images/' . $newName . '.' . $extention);

        $uploadResult = '/upload/images/' . $newName . '.' . $extention;
        return $uploadResult;
    }

    protected function getRandomName()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $cid = substr(implode('', $seed), 1, 10) . uniqid();


        return $cid;
    }

    public function populateForm($userObj, $form)
    {

        $user                = (array) $userObj;
        $user['dateOfBirth'] = $userObj->dateOfBirth->format('m/d/Y');
        $user['startDate']   = $userObj->startDate->format('m/d/Y');
        $user['branch']      = $userObj->branch->id;
        $user['department']  = $userObj->department->id;
        $user['position']    = $userObj->position->id;
        $user['manager']     = $userObj->manager->id;
        $user['image']       = $userObj->photo;
        $form->populate($user);
    }

    public function deleteUser()
    {
        $id           = $this->request->getParam('id');
        $user         = $this->em->getRepository('\Attendance\Entity\User')->find($id);
        $user->status = Attendance\Entity\User::STATUS_DELETED;
        $this->em->merge($user);
        $this->em->flush();
    }

}
