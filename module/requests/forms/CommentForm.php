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
        $comment->setRequired();

        $comment->setAttribs(array(
            'class' => 'form-control',
            'rows' => '1',
            'id' => 'comment'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-success');
        $submit->setValue('Submit !');
        $submit->setAttrib('id', 'submit');

        $this->addElements(array($comment, $submit));
    }

}
