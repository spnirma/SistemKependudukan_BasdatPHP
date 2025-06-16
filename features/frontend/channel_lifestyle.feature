@frontend
Feature: Lifestyle Channel
  In order to view Lifestyle Products
  As a website user
  I need to be able to see Lifestyle Channel

  Scenario: Viewing basic information
    Given I am on "/lifestyle"
    Then I should see "Produk Lifestyle dari berbagai daerah di Indonesia"
    And the ".breadcrumb" element should contain "Lifestyle" 
    And the "sort" field should contain "2"
    And I should see "KATEGORI"
    And I should see "HARGA"
    And I should see "KOTA"

  Scenario: Viewing basic information with no filter
    Given I am on "/lifestyle?filter=0"
    Then I should not see a ".side-filter" element
