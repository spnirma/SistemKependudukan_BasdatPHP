@frontend
Feature: Search
  In order to find a product
  As a website user
  I need to be able to search by keyword

  Scenario: Product not found
    Given I am on homepage
    When I fill in "cariproduk" with "abcdefghijklmnop-imaginary-product"
    And I press "Cari"
    Then I should see "Produk belum tersedia"

