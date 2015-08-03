Feature: Homepage
  In order to moke the login session
  I need to see the home page 

    Scenario: Check the homepage
      Given I moke the login session
      And I am on "/index"
      Then I should be on "/index"