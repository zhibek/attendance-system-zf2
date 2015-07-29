Feature: Homepage
  In order to know ZF works with Behat
  I need to see that the page loads.

Scenario: Check the homepage
  Given I load the URL "/index"
  Then the module should be "default"
  And the controller should be "index"
  And the action should be "index"
  And the action should redirect to "/sign/in"