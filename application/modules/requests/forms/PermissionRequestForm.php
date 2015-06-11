<?php

/**
 * Permission Request Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Requests_Form_PermissionRequestForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');
        
        
        // Permission Date 
        $date = new Zend_Form_Element_Text('date');
        $date->setAttribs(array(
                'class' => 'form-control date',
                'placeholder' => 'Example: 10/10/2010',
            ))->setRequired()
            ->addValidators(array(
                array('date', false, array('MM/dd/yyyy'))
            ))
            ->setLabel('Date: ');
        
        
        
        
        // From-Time Permission
        $from = new Zend_Form_Element_Text('from');
        
        
        
        
    }

}
