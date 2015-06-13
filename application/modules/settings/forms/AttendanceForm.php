<?php

/**
 * Description of AttendanceForm
 *
 * @author ahmed
 */
class Settings_Form_AttendanceForm extends Zend_Form
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
        $this->setMethod("POST");

        $this->addElement('text', 'startTime', array(
            'label' => 'Start Time',
            'required' => true,
            'class' => 'time',
            'id' => 'timeformat',
            'validators' => array(
                array('regex', false, array(
                        'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                        'messages' => 'please pick time from the menu .... '))
            )
        ));

        $this->addElement('text', 'endTime', array(
            'label' => 'End Time',
            'required' => true,
            'class' => 'time',
            'id' => 'timeformat',
            'validators' => array(
                array('regex', false, array(
                        'pattern' => '/^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/',
                        'messages' => 'please pick time from the menu .... ')
                ),
                array('Time',
                    false,
                    array(
                        'token' => 'startTime'
                    ),
                ),
            ),
        ));

        // User Branch  Element
        $branch = new Zend_Form_Element_Select('branch');
        $branch->setLabel('Branch: ')
                ->setOptions(array(
                    " " => " "
                ))
                ->setAttrib('class', 'form-control');

        $branchRepository = $this->em->getRepository('Attendance\Entity\Branch');
        $allBranches = $branchRepository->findAll();
        foreach ($allBranches as $b) {
            $branch->addMultiOption($b->id, $b->name);
        }
        $this->addElement($branch);


        $this->addElement('hidden', 'id', array(
        ));

        $this->addElement('submit', 'vacationCreate', array(
            'ignore' => true,
            'label' => 'Create',
        ));
    }

}
