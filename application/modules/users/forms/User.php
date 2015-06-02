<?php

/**
 * User Registeration Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Users_Form_User extends Zend_Form {
    
    protected $em;
    
    public function __construct($options = null) {
        $this->em = $options['em'];
        parent::__construct($options);
    }
    
    public function init() {
        
        Zend_Dojo::enableForm($this);
        // Form Method
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        // User ID Element
        $id = new Zend_Form_Element_Hidden('id');

        // User Name Element
        $userName = new Zend_Form_Element_Text('userName');
        $userName->
                setRequired()->
                setLabel('UserName: ')->
                addFilter('StringTrim')->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter User Name'
        ));


        // User Password Element
        $passwrod = new Zend_Form_Element_Password('password');
        $passwrod->
                setRequired()->
                setLabel('Password: ')->
                addValidator('StringLength', false, array(8))->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter User Password'
        ));


        // Confirm Password Element
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->
                setRequired()->
                setLabel('ConfirmPassword: ')->
                addValidator('StringLength', false, array(8))->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Confirm User Password'
        ));


        // User Appeared Name Element
        $name = new Zend_Form_Element('name');
        $name->
                setRequired()->
                setLabel('YourName: ')->
                addFilter('StringTrim')->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter User\'s appeared name'
        ));



        // User Mobile Element
        $mobile = new Zend_Form_Element('mobile');
        $mobile->
                setRequired()->
                setLabel('Mobile: ')->
                addFilter('StringTrim')->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter User Mobile #'
        ));
         
        
        // User Date Of Birth Element
        $dateOfBirth = new Zend_Form_Element_Text('dateOfBirth');
        $dateOfBirth->setAttribs(array(
            'class' => 'form-control',
            'placeholder' => 'Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('DateOfBirth: ');
        
        
        // User Start Date
        $startDate = new Zend_Form_Element_Text('startDate');
        $startDate->setAttribs(array(
            'class' => 'form-control',
            'placeholder' => 'Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('StartDate: ');


        // User Vacation Balance
        $vacationBalance = new Zend_Dojo_Form_Element_NumberSpinner('vacationBalance');     
        $vacationBalance->setAttribs(array(
            'class' => 'form-control',
            'max' => '21',
            'min' =>'0'    
        ))->setRequired()
                ->setLabel('VacationBalance: ');
        
        
        // User Description Element 
        $description = new Zend_Form_Element_Textarea('description');
        $description->
                setLabel('Description: ')->
                addFilter('StringTrim')->
                setAttribs(array(
                    'class' => 'form-control',
                    'rows' => '5',
                    'placeholder' => 'Enter User description'
        ));

        // User Marital Status Element
        $maritalStatus = new Zend_Form_Element_Select('maritalStatus');
        $maritalStatus->
                setLabel('MaritalStatus: ')->
                addMultiOption('single', 'Single')->
                addMultiOption('married', 'Married')->
                setAttrib('class', 'form-control');


        // User Department  Element
        $department = new Zend_Form_Element_Select('department');
        $department->
                setLabel('Department: ');
        $department->setAttrib('class', 'form-control');

        // User Branch  Element
        $branch = new Zend_Form_Element_Select('branch');
        $branch->
                setLabel('Branch: ')->
                setOptions(array(
                    " " => " "
                ))->
                setAttrib('class', 'form-control');

        
        // User Position  Element
        $position = new Zend_Form_Element_Select('position');
        $position->
                setLabel('Position: ')->
                setOptions(array(
                    " " => " "
                ))->
                setAttrib('class', 'form-control');
        
        // User Manager  Element
        $manager = new Zend_Form_Element_Select('manager');
        $manager->
                setLabel('Manager: ')->
                setOptions(array(
                    " " => " "
                ))->
                setAttrib('class', 'form-control');
        
        

        
        
        $photo = new Zend_Form_Element_File('photo', array(
            'label' => 'Picture',
            'required' => true,
            'MaxFileSize' => 2097152, // 2097152 BYTES = 2 MEGABYTES
            'validators' => array(
                array('Count', false, 1),
                array('Size', false, 2097152),
                array('Extension', false, 'gif,jpg,png'),
                array('ImageSize', false, array('minwidth' => 100,
                                                'minheight' => 100,
                                                'maxwidth' => 1000,
                                                'maxheight' => 1000))
            )
        ));

      

        // Submit Button Element
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Submit!'
        ));

        
        // Reset Button Element
        $reset = new Zend_Form_Element_Reset("reset");
        $reset->
                setAttribs(array(
                    'class' => 'btn btn-danger',
                    'value' => 'Reset!'
        ));


        // Add Elements to the Form
        $this->addElements(array(
            $id,
            $userName,
            $passwrod,
            $confirmPassword,
            $name,
            $mobile,
            $dateOfBirth,
            $startDate,
            $maritalStatus,
            $description,
            $branch,
            $department,
            $manager,
            $position,
            $photo,
            $submit,
            $reset,
            
        ));
        
    }

}