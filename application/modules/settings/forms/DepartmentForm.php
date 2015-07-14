<?php

/**
 * Description of DepartmentForm
 *
 * @author ahmed
 */
class Settings_Form_DepartmentForm extends Zend_Form
{

    protected $em;

    public function __construct($options = null)
    {
        $this->em = $options['em'];
        unset($options['em']);
        parent::__construct($options);
    }

    public function init()
    {
        Zend_Dojo::enableForm($this);

        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        $this->addElement('text', 'name', array(
            'label' => 'Department title',
            'required' => true,
            'class' => 'time form-control',
        ));

        $this->addElement('text', 'address', array(
            'label' => 'Address',
            'required' => true,
            'class' => ' form-control',
        ));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'required' => true,
            'class' => 'time form-control',
        ));
        
        $this->addElement('select', 'manager', array(
            'label' => 'Manager',
            'required' => true,
            'class' => 'time form-control',
        ));
        $query = $this->em->createQuery('Select v FROM Attendance\Entity\User  v WHERE v.position = 2');
        $managers = $query->execute();
        foreach ($managers as $p) {
            $this->getElement('manager')->addMultiOption($p->id, $p->name);
        }

        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'departmentCreate', array(
            'ignore' => true,
            'label' => 'Create',
            'class' => 'btn btn-success'
        ));
    }

}
