<?php

/**
 * WorkFromHome Request Form Class using Zend_Form
 * @author Ahmed
 * 
 *  */
class Requests_Form_WorkfromhomeForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form form-horizontal');

        $this->addElement('text', 'startDate', array(
            'label' => 'Start Date',
            'required' => true,

        ));
        $this->getElement('startDate')->setAttribs(array(
            'class' => 'date'
            ));
        

        $this->addElement('textarea', 'reason', array(
            'label' => 'Reason',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(1, 4000))),
        ));


        $this->addElement('submit', 'vacationCreate', array(
            'ignore' => true,
            'label' => 'Create',
        ));
    }

}
