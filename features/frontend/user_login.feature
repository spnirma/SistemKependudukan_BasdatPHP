@frontend
Feature: User login
  In order to buy items
  As a website user
  I need to be able to login

  Scenario: Navigating to login form
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"

  Scenario: Sending form with empty email
    Given there is a user with email "user@domain.tld" and password "userpassword"
      And I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Masuk"
      And I fill in "email" with ""
      And I fill in "password" with "userpassword"
      And I press "Masuk"
     Then I should see an error balloon "Email dan/atau password salah. Silakan coba lagi"

  Scenario: Sending form with empty password
    Given there is a user with email "user@domain.tld" and password "userpassword"
      And I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Masuk"
      And I fill in "email" with "user@domain.tld"
      And I fill in "password" with ""
      And I press "Masuk"
     Then I should see an error balloon "Email dan/atau password salah. Silakan coba lagi"

  Scenario: Sending form with wrong pair of email and password
    Given there is a user with email "user@domain.tld" and password "userpassword"
      And I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Masuk"
      And I fill in "email" with "user@domain.tld"
      And I fill in "password" with "userpassword"
      And I press "Masuk"
     Then I should be on homepage
