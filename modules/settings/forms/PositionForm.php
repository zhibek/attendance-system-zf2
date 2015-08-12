<?php

/**
 * Description of Position
 *
 * @author ahmed
 */
class Settings_Form_PositionForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        $this->addElement('text', 'name', array(
            'label' => 'Position title',
            'required' => true,
            'class' => 'time form-control',
        ));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'required' => true,
            'class' => 'time form-control',
        ));

        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'positionCreate', array(
            'ignore' => true,
            'label' => 'Create',
            'class' => 'btn btn-success'
        ));
    }

}
