<?php

class Default_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.yaml');
        parent::setUp();
    }

    public function testHomepageReturnsSuccess()
    {
        $this->dispatch('/');
    }

}