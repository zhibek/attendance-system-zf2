<?php

/**
 * WorkFromHome Request Form Class using Zend_Form
 * @author Ahmed
 * 
 *  */
class Requests_Form_WorkFromHome extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form form-horizontal');
        
        $this->addElement('text','startDate',array(
           'lable'=>'Start Date',
           'required' => true,
            'validators' => array(
                array('regex', false, array(
                        'pattern' => '~(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d~',
                        'messages' => 'please pick a Date '))
            )
        ));
        
        $this->addElement('text','endDate',array(
           'lable'=>'End Date',
           'required' => true,
            'validators' => array(
                array('regex', false, array(
                        'pattern' => '~(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d~',
                        'messages' => 'please pick a Date '))
            )
        ));
        $this->getElement('endDate')->
                addValidators(new Attendance_Validate_CustomDateValidator(array('token' =>  'startDate')));
       
        $this->addElement('textarea','reason',array(
           'label'=>'Reason',
           'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(1, 512))),
        ));
    }

}
