@frontend
Feature: Food Channel
  In order to view Food Products
  As a website user
  I need to be able to see Food Channel

  Scenario: Viewing basic information
    Given I am on "/food"
    Then I should see "Produk Makanan dari berbagai daerah di Indonesia"
    And the ".breadcrumb" element should contain "Food" 
    And the "sort" field should contain "2"
    And I should see "KATEGORI"
    And I should see "HARGA"
    And I should see "KOTA"

  Scenario: Viewing basic information with no filter
    Given I am on "/food?filter=0"
    Then I should not see a ".side-filter" element
