<?php

/**
 * Description of Branches
 *
 * @author AbdEl-Moneim
 */
class Settings_Form_BranchesForm extends Zend_Form
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
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        $this->addElement('text', 'name', array(
            'label' => 'Branch title',
            'required' => true,
            'class' => 'time form-control',
        ));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'required' => true,
            'class' => 'time form-control',
        ));

         $this->addElement('text', 'address', array(
            'label' => 'Address',
            'required' => true,
            'class' => 'time form-control',
        ));
         // User Manager  Element
        $this->addElement('select', 'manager', array(
            'label' => 'Manager',
            'required' => true,
            'class' => 'time form-control',
        ));
        $query = $this->em->createQuery('Select v FROM Attendance\Entity\User  v WHERE v.role = 3');
        $managers = $query->execute();
        foreach ($managers as $p) {
            $this->getElement('manager')->addMultiOption($p->id, $p->name);
        }
        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'positionCreate', array(
            'ignore' => true,
            'label' => 'Create',
            'class' => 'btn btn-success'
        ));
    }

}
