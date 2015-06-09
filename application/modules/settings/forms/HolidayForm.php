<?php

class Settings_Form_HolidayForm extends Zend_Form
{

    //put your code here
    public function init()
    {
        Zend_Dojo::enableForm($this);
        // Form Method
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        // User ID Element
        $id = new Zend_Form_Element_Hidden('id');

        // User Name Element
        $name = new Zend_Form_Element_Text('name');
        $name->
                setRequired()->
                setLabel('Holiday Name: ')->
                addFilter('StringTrim')->
                setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter Holiday Name'
        ));
        
        // From Date
        $fromDate = new Zend_Form_Element_Text('dateFrom');
        $fromDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('From Date: ');
        
        // To Date
        $toDate = new Zend_Form_Element_Text('dateTo');
        $toDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('To Date: ');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Submit!'
        ));
        
        $this->addElements(array(
            $id,
            $name,
            $fromDate,
            $toDate,
            $submit
        ));
        
        
    }

}
