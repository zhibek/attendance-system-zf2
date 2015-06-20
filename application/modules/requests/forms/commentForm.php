<?php

/**
 * add comment Form Class using Zend_Form
 * @author Mohamed Ramdan
 * 
 *  */
class Requests_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('class', 'form form-horizontal');

        $comment = new Zend_Form_Element_Textarea('comment');
        $comment->setLabel('Add Comment:');
        
        $comment->setAttribs(array(
            'class' => 'form-control',
            'rows'=>'1'));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class','btn btn-success');
        $submit->setValue('Submit !');
        
        $this->addElements(array($comment,$submit));
    }

}
