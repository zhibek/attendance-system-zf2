<?php

/**
 * Vacation Request Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Requests_Form_VacationRequestForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class','form form-horizontal');
        $this->setAttrib('id', 'VacationRequestForm');
        
        
        
        
        // From Date
        $fromDate = new Zend_Form_Element_Text('fromDate');
        $fromDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
            'id' => 'fromDate'
        ))->setRequired()
                ->setLabel('From Date: ');
        
        // To Date
        $toDate = new Zend_Form_Element_Text('toDate');
        $toDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
            'id' => 'toDate'
        ))->setRequired()
                ->setLabel('To Date: ');
        
        // Type of Vacation
        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('VacationType: ')->
            setAttrib('class', 'form-control')->
            setAttrib('id', 'type')->
            addMultiOption('','');
        $type->setRegisterInArrayValidator(false);
            
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array(
            'class'=>'btn btn-success',
            'value'=>'Submit'
        ));
        $this->addElements(array(
            $fromDate,$toDate,$type,$submit
        ));
    }

}
