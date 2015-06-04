<?php

class Settings_Form_VacationForm extends Zend_Form
{

    //put your code here
    public function init()
    {
        $this->setMethod("POST");

        $this->addElement('text', 'type', array(
            'label' => 'Type',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(1, 512))),
        ));

        $this->addElement('text', 'balance', array(
            'label' => 'Balance',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('hidden', 'id', array(
        
            
        ));

        $this->addElement('submit', 'vacationCreate', array(
            'ignore' => true,
            'label' => 'Create',
        ));
    }

}
