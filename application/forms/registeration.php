<?php

/**

 * User Registeration Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Application_Form_Registeration extends Zend_Form
{
    public function init() {
        
        // Form Method
        $this -> setMethod('post');
        $this -> setAttrib('calss', 'form form-horizontal');
        
        // User ID Element
        $userID = new Zend_Form_Element_Hidden('userID');
        
        
        // User Name Element
        $userName = new Zend_Form_Element_Text('userName');
        $userName                        -> 
            setRequired()                -> 
            setLabel('Username: ')       -> 
            addFilter('StringTrim')      ->
            setAttribs(array(
                'class'       => 'form-control',
                'placeholder' => 'Enter User Name'
            ));
        
            
        // User Password Element
        $passwrod = new Zend_Form_Element('password');
        $passwrod                         -> 
            setRequired()                 ->
            setLabel('Password: ')        ->
            addValidator('StringLength',
                false, array(8))          ->
            setAttribs(array(
                'class'       => 'form-control',
                'placeholder' => 'Enter User Password'  
            ));
        
        
        // Confirm Password Element
        $confirmPassword = new Zend_Form_Element_Text('confirmPassword');
        $confirmPassword                  ->
            setRequired()                 -> 
            setLabel('ConfirmPassword: ') ->
            addValidator('StringLength',
                false, array(8))          ->
            setAttribs(array(
                'class'       => 'form-control',
                'placeholder' => 'Confirm User Password'
            ));
        
        
        // User Appeared Name Element
        $name = new Zend_Form_Element('name');
        $name                             ->
            setRequired()                 ->
            setLabel('YourName: ')        ->
            addFilter('StringTrim')       ->
            setAttribs(array(
                'class'       => 'form-control',
                'placeholder' => 'Enter User\'s appeared name'
            ));
        
        
        
        // User Mobile Element
        $mobile = new Zend_Form_Element('mobile');
        $mobile                           ->
            setRequired()                 ->
            setLabel('Mobile: ')          ->
            addFilter('StringTrim')       ->
            setAttribs(array(
                'class'       => 'form-control',
                'placeholder' => 'Enter User Mobile #'
            ));
        
        
        // User Date Of Birth Element
        $dateOfBirth = new Zend_Form_Element_Text('dateOfBirth');
        $dateOfBirth->setAttribs(array(
            'class'=>'form-control',
            'placeholder'=>'Example: 10/10/2010',
            
        ))->setRequired();
        
        
        // User Description Element 
        $description = new Zend_Form_Element_Textarea('description');
        $description                      -> 
            setLabel('Description: ')     -> 
            addFilter('StringTrim')       -> 
            setAttribs(array(
                'class'       => 'form-control',
                'rows'        => '5',
                'placeholder' => 'Enter User description'
            ));
        
        // User Marital Status Element
        $maritalStatus = new Zend_Form_Element_Select('maritalStatus');
        $maritalStatus                    -> 
            setLabel('MaritalStatus: ')   -> 
            setOptions(array(
                'Single'      => 'Single',
                'Married'     => 'Married',
                'Complicated' => 'Complicated'
                ))                        -> 
            setAttrib('class','form-control');
        
        
        // User Department  Element
        $department = new Zend_Form_Element_Select('department');
        $department                        -> 
            setLabel('Department: ')       ->
            setOptions(array(
                " "           => " " 
            ))                             ->
        setAttrib('class', 'form-control');
        
        
        // User Branch  Element
        $branch = new Zend_Form_Element_Select('branch');
        $branch                            -> 
            setLabel('Branch: ')           ->
            setOptions(array(
                " "           => " " 
            ))                             ->
        setAttrib('class', 'form-control');
        
        
        // User Position  Element
        $position = new Zend_Form_Element_Select('position');
        $position                           -> 
            setLabel('Position: ')          ->
            setOptions(array(
                " "           => " " 
            ))                              ->
        setAttrib('class', 'form-control');
        
        
        // User Photo Element
        $photo = new Zend_Form_Element_File('photo');
	$photo ->
                setLabel('Upload your photo: ')                                            -> 
                setAttrib("class","form-control")                                          ->
                setDestination('/application/public/forum')->
                addValidator('Count', false, 1);
        $thedate = date_create();
        $photo->addFilter('Rename', array('target' => $thedate->format('U = Y-m-d H:i:s')))->
                addValidator('Size', false, 2097152)                                       -> 
                setMaxFileSize(2097152)                                                    ->
                addValidator('Extension', false, 'jpg,png,gif,jpeg')                       ->
                receive()                                                                  ->
                setValueDisabled(true);
        
           
        
        // Submit Button Element
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->
            setAttribs(array(
                'class' => 'btn btn-success',
                'value' => 'Submit!'
                ));
        
        
        // Reset Button Element
        $reset = new Zend_Form_Element_Reset("reset");
        $reset -> 
            setAttribs(array(
                'class' => 'btn btn-danger',
                'value' => 'Reset!'
                ));
        
        
        // Add Elements to the Form
        $this->addElements(array(
            $userID,
            $username,
            $passwrod,
            $confirmPassword,
            $name,
            $mobile,
            $photo,
            $maritalStatus,
            $description,
            $branch,
            $department,
            $position,
            $submit,
            $reset
            ));
     
        
        
        
    }
    
}
