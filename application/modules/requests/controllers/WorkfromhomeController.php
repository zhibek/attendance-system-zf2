<?php

/**
 * Description of WorkFromHomeController
 *
 * @author Ahmed
 */
class Requests_WorkfromhomeController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $model = new Requests_Model_Workfromhome($em);
        $requests = $model->workFromHomeListing();
//        var_dump($requests);
    }

    public function newAction()
    {
        $form = new Requests_Form_WorkfromhomeForm();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $requestInfo = $this->_request->getParams();
        $workFromHomeModel = new Requests_Model_Workfromhome($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $workFromHomeModel->newRequest($requestInfo);
                $this->redirect('/requests/workfromhome/index');
            }
        }

        $this->view->newform = $form;
    }

}
