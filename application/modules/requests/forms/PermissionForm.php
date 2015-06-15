<?php

/**
 * Permission Request Form Class using Zend_Form
 * @author Moataz Mohamed
 * 
 *  */
class Requests_Form_PermissionForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');
        
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $UserModel = new Users_Model_User($em);

        $user = new Zend_Form_Element_Select('user');
        $user->setLabel('Department: ');
        $user->setAttrib('class', 'form-control');

        
        $allUsers = $UserModel->listAll();
        foreach ($allDepartments as $d) {
            $user->addMultiOption($d->id, $d->name);
        }
        
        // Permission Date 
        $date = new Zend_Form_Element_Text('date');
        $date->setAttribs(array(
                'class' => 'form-control time',
                
            ))->setRequired()
            ->addValidators(array(
                array('date', false, array('MM/dd/yyyy'))
            ))
            ->setLabel('Date: ');
        
        $fromTime = new Zend_Form_Element_Text('fromTime');
        $fromTime->setAttribs(array(
            'class' => 'form-control time',            
        ))->setRequired()
                ->setLabel('From Date: ');
       
        
        $toTime = new Zend_Form_Element_Text('toTime');
        $toTime->setAttribs(array(
            'class' => 'form-control time',
            
        ))
        ->setRequired()
        ->addValidator(array('regex', false, array(
                        'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                        'messages' => 'please pick time from the menu .... ')))
        ->setLabel('To Date: ');

                        
        
        $toTime->addValidator(new Attendance_Validate_CustomDateValidator(array('token' =>  'fromTime'))) ;
        
        
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
