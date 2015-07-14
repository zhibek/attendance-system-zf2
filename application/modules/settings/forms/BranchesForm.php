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
        $manager = new Zend_Form_Element_Select('manager');
        $manager->
                setLabel('Manager: ')->
                setOptions(array(
                    " " => " "
                ))->
                setAttrib('class', 'form-control');

        $managerRepository = $this->em->getRepository('Attendance\Entity\User');
        $allManagers = $managerRepository->findAll();
        foreach ($allManagers as $m) {
            $manager->addMultiOption($m->id, $m->name);
        }
        $this->addElement($manager);
        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'positionCreate', array(
            'ignore' => true,
            'label' => 'Create',
            'class' => 'btn btn-success'
        ));
    }

}
