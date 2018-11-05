Feature: Application installed

    Scenario: Successfully Register Company
        Given I want to register
        Then I should see "I'm not yet a customer"
        When I fill in "Name" with "Test Customer"
        And I fill in "Email" with "test.company@email.com"
        And I fill in "Companyname" with "Test Company"
        And I fill in "Postalcode" with "123456"
        And I fill in "City" with "Some City"
        And I fill in "Street" with "Some street"
        And I fill in "house number" with "123"
        And I fill in "Phone" with "123456"
        And I press "Register"
        And I wait for the ajax response
        Then I should see "The registration has been successful"
        And I should see "An Email with an activation link has been sent"