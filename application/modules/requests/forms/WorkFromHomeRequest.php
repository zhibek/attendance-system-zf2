<?php

/**
 * WorkFromHome Request Form Class using Zend_Form
 * @author Mohamed Ramadan
 * 
 *  */
class Requests_Form_WorkFromHome extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form form-horizontal');
        
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
        
        
        // Reason
        $reason = new Zend_Form_Element_Textarea('reason');
        $reason->setAttribs(array('class'=>'from-control','row'=>'5'))
            ->setRequired()
            ->setLabel('Reason: ');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Submit!'
        ));
        
        $this->addElements(array(
            $dateFrom,
            $dateTo,
            $reason
        ));
        
    }

}
