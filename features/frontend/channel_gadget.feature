@frontend
Feature: Gadget Channel
  In order to view Gadget Products
  As a website user
  I need to be able to see Gadget Channel

  Scenario: Viewing basic information
    Given I am on "/gadget"
    Then I should see "Produk Gadget dari berbagai daerah di Indonesia"
    And the ".breadcrumb" element should contain "Gadget" 
    And the "sort" field should contain "2"
    And I should see "KATEGORI"
    And I should see "HARGA"
    And I should see "KOTA"

  Scenario: Viewing basic information with no filter
    Given I am on "/gadget?filter=0"
    Then I should not see a ".side-filter" element
