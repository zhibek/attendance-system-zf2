<?php

class Settings_Form_FilterByYearForm extends Zend_Form
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
        $holidayRepository = $this->entityManager->getRepository('Attendance\Entity\Holiday');
        $allHolidays = $holidayRepository->findBy(array(), array('dateFrom' => 'DESC'));
        foreach ($allHolidays as $holiday) {
            $year->addMultiOption(date_format($holiday->dateFrom, 'Y'),date_format($holiday->dateFrom, 'Y'));
        }

        
        
        $submit = new Zend_Form_Element_Submit('Filter');
        $submit->
                setAttribs(array(
                    'class' => 'btn btn-success',
                    'value' => 'Filter!'
        ));
        
        $this->addElements(array(
            $year,
            $submit
        ));
        
        
    }

}
