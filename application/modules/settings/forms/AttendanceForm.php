<?php

/**
 * Description of AttendanceForm
 *
 * @author ahmed
 */
class Settings_Form_AttendanceForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod("POST");

        $this->addElement('text', 'branch', array(
            'label' => 'Branch',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'startdate', array(
            'label' => 'Start Date',
            'required' => true,
            'class' => 'time',
        ));

        $this->addElement('text', 'enddate', array(
            'label' => 'End Date',
            'class' => 'time',
            'required' => true,
        ));
        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'vacationCreate', array(
            'ignore' => true,
            'label' => 'Create',
        ));
    }

}
