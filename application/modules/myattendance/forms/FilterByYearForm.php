<?php

class Myattendance_Form_FilterByYearForm extends Zend_Form
{
    protected $entityManager;

    public function __construct($options = null,$em)
    {
        $this->entityManager = $em;
        unset($options['em']);
        parent::__construct($options);
    }

    //put your code here
    public function init()
    {
        Zend_Dojo::enableForm($this);
        // Form Method
        $this->setMethod('post');
        $this->setAttrib('calss', 'form form-horizontal');

        // User Branch  Element
        $year = new Zend_Form_Element_Select('year');
        $year->
            setLabel('Year: ')->
            setOptions(array(
                " " => " "
            ))->
            setAttrib('class', 'form-control');
        
        
        $fromDate = new Zend_Form_Element_Text('dateFrom');
        $fromDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('From Date: ');
        
        // To Date
        $toDate = new Zend_Form_Element_Text('dateTo');
        $toDate->setAttribs(array(
            'class' => 'form-control date',
            'placeholder' => 'MM/DD/YYYY Example: 10/10/2010',
        ))->setRequired()
                ->setLabel('To Date: ');
        
        $toDate->addValidator(new Attendance_Validate_CustomDateValidator(array('token' =>  'dateFrom'))) ;
        
        
        
        
        $submit = new Zend_Form_Element_Submit('Filter');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Filter!'
        ));
        
        $this->addElements(array(
            $fromDate,            
            $toDate,
            $submit
        ));
        
        
    }

}
