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
        
        
        
        
        // From Date
        $fromDate = new Zend_Form_Element_Text('fromDate');
        $fromDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('From Date: ');
        
        // To Date
        $toDate = new Zend_Form_Element_Text('toDate');
        $toDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('To Date: ');
        
        // Type of Vacation
        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('VacationType: ')->
            setAttrib('class', 'form-control')->
            addMultiOption('casual', 'casual')->
            addMultiOption('annual','annual')->
            addMultiOption('sick','sick');
        
        
        
        $this->addElements(array(
            $fromDate,$toDate,$type
        ));
    }

}
