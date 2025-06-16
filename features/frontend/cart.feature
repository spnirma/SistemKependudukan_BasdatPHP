@frontend
Feature: Cart
  In order to shop
  As a website user
  I need to be able to view my cart

  Scenario: Empty shopping cart
    Given I am on homepage
    When I follow "Troli"
    Then I should see "Anda belum memiliki produk di Keranjang Belanja"
    And I should see "Kembali Belanja"
    When I follow "Kembali Belanja"
    Then I should be on homepage

