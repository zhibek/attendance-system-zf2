<?php

/**
 * Vacation Request Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Requests_Form_Vacation extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class','form form-horizontal');
        
        // From Date
        $dateFrom = new Zend_Form_Element_Text('dateFrom');
        $dateFrom->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('From Date: ');
        
        // To Date
        $dateTo = new Zend_Form_Element_Text('dateTo');
        $dateTo->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('To Date: ');
        
        // Type of Vacation
        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('VacationType: ')->
            addMultiOption('casual', 'casual')->
            addMultiOption('annual','annual')->
            addMultiOption('sick','sick');
        
        
    }

}
