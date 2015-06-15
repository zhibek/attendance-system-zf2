<?php

/**
 * Permission Request Form Class using Zend_Form
 * @author Moataz Mohamed
 * 
 *  */
class Requests_Form_PermissionForm extends Zend_Form
{
    protected $entityManager;
    
    public function __construct($options = null,$em)
    {
        $this->entityManager = $em;
        unset($options['em']);
        parent::__construct($options);
    }


    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');
        
        $UserModel = new Users_Model_User($this->entityManager);

        $user = new Zend_Form_Element_Select('user');
        $user->setLabel('User: ');
        $user->setAttrib('class', 'form-control');

        
        $allUsers = $UserModel->listAll();
        foreach ($allUsers as $currentUser) {
            $user->addMultiOption($currentUser->id, $currentUser->name);
        }
        
        // Permission Date 
        $date = new Zend_Form_Element_Text('date');
        $date->setAttribs(array(
                'class' => 'form-control date',
                
            ))
            ->setRequired()
            ->addValidators(array(
                array('date', false, array('MM/dd/yyyy'))
            ))
            ->setLabel('Date: ');
        
        $fromTime = new Zend_Form_Element_Text('fromTime');
        $fromTime->setAttribs(array(
            'class' => 'form-control time',            
        ))
        ->setRequired()
        ->setLabel('From Time: ')
        ->addValidators(array(
            array('regex', false, array(
                        'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                        'messages' => 'please pick time from the menu .... '))
            
        ));
        
        $toTime = new Zend_Form_Element_Text('toTime');
        $toTime->setAttribs(array(
            'class' => 'form-control time',
        ))
        ->setRequired()
        ->setLabel('To Time: ')
        ->addValidators(array(
            array('regex', false, array(
                        'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                        'messages' => 'please pick time from the menu .... '))
            
        ));
                        
        
        $toTime->addValidator(new Attendance_Validate_Time(array('token' =>  'fromTime'))) ;
        
        
        // From-Time Permission
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Submit!'
        ));
        
        $this->addElements(array(
           
            $user,
            $date,
            $fromTime,
            $toTime,
            $submit
        ));
        
        
        
    }

}
