@frontend
Feature: User registration
  In order to buy items
  As a website user
  I need to be able to register

  Scenario: Navigating to registration form
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"

  Scenario: Sending form with empty email
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with ""
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with "userpassword"
      And I press "Daftar"
     Then I should see "Email tidak boleh kosong"

  Scenario: Sending form with invalid email
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "notvalidemail"
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with "userpassword"
      And I press "Daftar"
     Then I should see "Alamat email tidak valid"

  Scenario: Sending form with empty password
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with ""
      And I fill in "passconf_register" with "userpassword"
      And I press "Daftar"
     Then I should see "Password tidak boleh kosong"

  Scenario: Sending form with empty password confirmation
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with ""
      And I press "Daftar"
     Then I should see "Password Confirmation tidak boleh kosong"

  Scenario: Sending form with password length less than 6 character
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with "userp"
      And I fill in "passconf_register" with "userp"
      And I press "Daftar"
     Then I should see "Password tidak boleh kurang dari 6 karakter"

  Scenario: Sending form with password does not match password confirmation
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with "userpassword2"
      And I press "Daftar"
     Then I should see "Password tidak sama"

  Scenario: Sending form with already registered email
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
    Given there is a user with email "user@domain.tld" and password "userpassword"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with "userpassword"
      And I press "Daftar"
     Then I should see "Alamat email sudah terdaftar"

  Scenario: Sending form with valid data
    Given I am on homepage
     When I follow "login-btn"
     Then I should see "Masuk"
      And I should see "Daftar"
     When I follow "Daftar"
      And I fill in "email_register" with "user@domain.tld"
      And I fill in "password_register" with "userpassword"
      And I fill in "passconf_register" with "userpassword"
      And I press "Daftar"
     Then there should be a user with email "user@domain.tld" and password "userpassword"
