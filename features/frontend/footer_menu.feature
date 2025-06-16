@frontend
Feature: Footer Menu
  In order to look for help
  As a website user
  I need to be able to navigate footer menu

  Scenario: Following footer menu : FAQ
    Given I am on homepage
    And There is a page "FAQ" with id "7" and content "Apa itu Cipika Store"
    When I follow "FAQ"
    Then I should be on "/page/index/7/FAQ"
    And I should see "Apa itu Cipika Store"
  
  Scenario: Following footer menu : Tips Pembayaran Aman
    Given I am on homepage
    And There is a page "Tips Pembayaran" with id "2" and content "SSL"
    When I follow "Tips Pembayaran Aman"
    Then I should be on "/page/index/2/Tips-Pembayaran-Aman"
    And I should see "SSL"

  Scenario: Following footer menu : Cara Bergabung
    Given I am on homepage
    And There is a page "Cara Bergabung" with id "5" and content "Panduan Cara Bergabung"
    When I follow "Cara Bergabung"
    Then I should be on "/page/index/5/Cara-Bergabung"
    And I should see "Panduan Cara Bergabung"

  Scenario: Following footer menu : Tentang Kami
    Given I am on homepage
    And There is a page "Tentang Kami" with id "1" and content "E-Marketplace yang menghadirkan kemudahan berbelanja online"
    When I follow "Tentang Kami"
    Then I should be on "/page/index/1/Tentang-Kami"
    And I should see "E-Marketplace yang menghadirkan kemudahan berbelanja online"

  Scenario: Following footer menu : Syarat & Ketentuan
    Given I am on homepage
    And There is a page "Syarat & Ketentuan" with id "8" and content "SYARAT & KETENTUAN MEMBER CIPIKA STORE MARKETPLACE"
    When I follow "Syarat & Ketentuan"
    Then I should be on "/page/index/8/Syarat-dan-Ketentuan-"
    And I should see "SYARAT & KETENTUAN MEMBER CIPIKA STORE MARKETPLACE"

  Scenario: Following footer menu : Hubungi Kami
    Given I am on homepage
    When I follow "Hubungi Kami"
    Then I should be on "contact-us"
    And I should see "Untuk menghubungi kami"

  Scenario: Following footer menu : Daftar menjadi merchant
    Given I am on homepage
    And There is a page "Cipika Merchant Zone" with id "11" and content "Cipika Merchant Zone"
    When I follow "Daftar menjadi Merchant"
    Then I should be on "/page/index/11/Register-Merchant"
    And I should see "Cipika Merchant Zone"

