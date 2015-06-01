<?php

/**

 * User Registeration Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Users_Form_User extends Zend_Form {

    public function init() {

        //$users = Doctrine_Core::getTable('User')->findAll();
//        foreach($users as $user) {
//            echo $user->username . " has phonenumbers: ";
//
//            foreach($user->Phonenumbers as $phonenumber) {
//                echo $phonenumber->phonenumber . "\n";
//            }
//        }
        //$em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
//        $em = $this->getActionController()->getInvokeArg('bootstrap')->getResource('entityManager');
//        $users = $em->findAll();
//        foreach ($users as $user) {
//            $this->$user->department;
//        }




        // Form Method
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        // User ID Element
        $userID = new Zend_Form_Element_Hidden('userID');


        // User Name Element
        $userName = new Zend_Form_Element_Text('username');
        $userName->
                setRequired()->
                setLabel('Username: ')->
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
        ))->setRequired();


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
//        foreach ($users as $user) {
//            $department->addMultiOption($user->department);
//        }
//        setAttrib('class', 'form-control');

//        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
//        $repository = $em->getRepository('Attendance\Entity\Branche');
//        $entities = $repository->findAll();

// User Branch  Element
        $branch = new Zend_Form_Element_Select('branche');
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


        // User Photo Element
        $photo = new Zend_Form_Element_File('photo');
        $photo->
                setLabel('Upload your photo: ')->
                setAttrib("class", "form-control")->
                setDestination('/var/www/public/images')->
                addValidator('Count', false, 1);
        $thedate = date_create();
        $photo->addFilter('Rename', array('target' => $thedate->format('U = Y-m-d H:i:s')))->
                addValidator('Size', false, 2097152)->
                setMaxFileSize(2097152)->
                addValidator('Extension', false, 'jpg,png,gif,jpeg')->
                receive()->
                setValueDisabled(true);
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
            $userID,
            $userName,
            $passwrod,
            $confirmPassword,
            $name,
            $mobile,
//            $photo,
            $maritalStatus,
            $description,
            $branch,
//            $department,
//            $position,
            $submit,
            $reset
        ));
    }

}
