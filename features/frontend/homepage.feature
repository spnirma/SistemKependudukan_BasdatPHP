@frontend
Feature: Homepage
  In order to interact with Cipika Store
  As a website user
  I need to be able to view cipika's homepage

  Scenario: Viewing basic website identity
    Given I am on homepage
    #Then I should see "cipika" in the "title" element
    Then the response should contain "cipika.co.id"
    And I should see "Selamat datang di Cipika Store"

  Scenario: Viewing basic website navigation
    Given I am on homepage
    Then the ".navbar-nav" element should contain "Gadget"
    And the ".navbar-nav" element should contain "Food"
    And the ".navbar-nav" element should contain "Lifestyle"
    And the ".navbar-nav" element should contain "Travel"
    And I should see an "input[placeholder='Cari produk yang Anda inginkan']" element
    And I should see "Troli"
    And I should see "Masuk | Daftar"
    And I should see a ".banner" element
    And the "#foot" element should contain "FAQ"
    And the "#foot" element should contain "Tips Pembayaran Aman"
    And the "#foot" element should contain "Cara Bergabung"
    And the "#foot" element should contain "Tentang Kami"
    And the "#foot" element should contain "Syarat &amp; Ketentuan"
    And I should see an "a[href='https://www.facebook.com/pages/Cipika-Store/466418886820641']" element
    And I should see an "a[href='https://twitter.com/Cipika_ID']" element
    And the "#foot" element should contain "Hubungi Kami"
    And I should see "Daftar menjadi Merchant"

  Scenario: Following logo should go to homepage
    Given I am on homepage
    When I follow "lg-navbar-gadget"
    And I follow "Cipika"
    Then I should be on the homepage

  Scenario: Navigating main menu
    Given I am on homepage
    When I follow "lg-navbar-gadget"
    Then I should be on "/gadget"
    And I should see "Produk Gadget dari berbagai daerah di Indonesia"
    When I follow "lg-navbar-food"
    Then I should be on "/food"
    And I should see "Produk Makanan dari berbagai daerah di Indonesia"
    When I follow "lg-navbar-lifestyle"
    Then I should be on "/lifestyle"
    And I should see "Produk Lifestyle dari berbagai daerah di Indonesia"

  # TODO : refine search testing
  Scenario: Navigating search
    Given I am on homepage
    When I fill in "cariproduk" with ""
    And I press "header-search"
    Then I should be on "/gadget/"
    And I should see "Produk Gadget dari berbagai daerah di Indonesia"

  Scenario: Navigating Shopping Cart
    Given I am on homepage
    When I follow "Troli"
    Then I should be on "/cart"

  Scenario: Navigating Shopping Cart
    Given I am on homepage
    When I follow "Troli"
    Then I should be on "/cart"

  Scenario: Seeing best products
    Given I am on homepage
    Then I should see "Gadget Terbaik"
    And I should see "Cemilan Terlaris"
    And I should see "Fashion Terlaris"
    And I should see "Produk Terbaru"

  # TODO : gambar banner ambil dari db

  Scenario: Best Gadget
    Given there is a user with given attributes:
      """
      {
        "id"           : 1,
        "username"     : "user@domain.tld",
        "password"     : "userpass",
        "salt"         : "usersalt",
        "email"        : "user@domain.tld",
        "mobileNumber" : "081234567890",
        "isActive"     : 1,
        "statusId"     : 1
      }
      """
      And there is a propinsi with given attributes:
      """
      {
        "id"   : 1,
        "name" : "Jawa Barat"
      }
      """
      And there is a kabupaten with given attributes:
      """
      {
        "id"         : 1,
        "name"       : "Kab. Bogor",
        "propinsiId" : 1
      }
      """
      And there is a kecamatan with given attributes:
      """
      {
        "id"          : 1,
        "name"        : "Gunung Putri",
        "kabupatenId" : 1
      }
      """
      And there is a product category with given attributes:
      """
      {
        "id"          : 1,
        "channelName" : "GADGET",
        "name"        : "Initial Product Category Name",
        "description" : "Initial Product Category Description",
        "isShown"     : 1
      }
      """
      And there is a product with given attributes:
      """
      {
        "id"                          : 1,
        "name"                        : "Initial Gadget Name",
        "description"                 : "Initial Gadget Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 10,
        "isViewNotification"          : "Y",
        "merchantOriginalPrice"       : 100000,
        "channelName"                 : "GADGET",
        "dateAdded"                   : "2015-04-10",
        "dateModified"                : "2015-04-10",
        "dateRequested"               : "2015-04-10",
        "dateVerified"                : "2015-04-10",
        "isFeatured"                  : 1,
        "sold"                        : 100,
        "sellPrice"                   : 100000,
        "isShownOnListing"            : 1,
        "listIndex"                   : 1,
        "categoryId"                  : 1,
        "userId"                      : 1,
        "kotaId"                      : 1,
        "kategoriId"                  : 1
      }
      """
      And there is a product photo with given attributes:
      """
      {
        "id"           : 1,
        "description"  : "Initial Product Photo Description",
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "productId"    : 1
      }
      """
      And there is a product comment with given attributes:
      """
      {
        "id"           : 1,
        "comment"      : "Initial Comment",
        "isPublished"  : true,
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "userId"       : 1,
        "productId"    : 1
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 1,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 1
      }
      """
      And there is a store with given attributes:
      """
      {
        "id"                      : 1,
        "country"                 : "Indonesia",
        "name"                    : "Initial Store Name",
        "ownerName"               : "Initial Owner Name",
        "ownerBirthDate"          : "2015-04-10",
        "description"             : "Initial Store Description",
        "address"                 : "Initial Store Addres",
        "phoneNumber"             : "081234567890",
        "isViewingNotification"   : 1,
        "yahooMessengerId"        : "yahoomessengerid",
        "facebookId"              : "facebookid",
        "twitterId"               : "twitterid",
        "blackBerryId"            : "blackberryid",
        "whatsAppId"              : "whatsappid",
        "email"                   : "user@domain.tld",
        "bankAccountName"         : "Initial Bank Account Name",
        "bankAccountBranch"       : "Bogor",
        "bankAccountNumber"       : "12345678901234",
        "bankAccountOwner"        : "Initial Bank Account Owner",
        "storeStatus"             : "approve",
        "dateAdded"               : "2015-04-10",
        "dateModified"            : "2015-04-10",
        "dateRequested"           : "2015-04-10",
        "dateVerified"            : "2015-04-10",
        "merchantPhoneNumber"     : "081234567890",
        "merchantGender"          : "M",
        "rejectReason"            : "",
        "createdBy"               : 1,
        "kotaId"                  : 1,
        "propinsiId"              : 1,
        "kabupatenId"             : 1,
        "kecamatenId"             : 1,
        "userId"                  : 1,
        "salesId"                 : 1,
        "jneOriginId"             : 1
      }
      """
      And I am on homepage
     Then the ".featured-list.container" element should contain "Initial Gadget Name"

Scenario: Best Cemilan
    Given there is a user with given attributes:
      """
      {
        "id"           : 1,
        "username"     : "user@domain.tld",
        "password"     : "userpass",
        "salt"         : "usersalt",
        "email"        : "user@domain.tld",
        "mobileNumber" : "081234567890",
        "isActive"     : 1,
        "statusId"     : 1
      }
      """
      And there is a propinsi with given attributes:
      """
      {
        "id"   : 1,
        "name" : "Jawa Barat"
      }
      """
      And there is a kabupaten with given attributes:
      """
      {
        "id"         : 1,
        "name"       : "Kab. Bogor",
        "propinsiId" : 1
      }
      """
      And there is a kecamatan with given attributes:
      """
      {
        "id"          : 1,
        "name"        : "Gunung Putri",
        "kabupatenId" : 1
      }
      """
      And there is a product category with given attributes:
      """
      {
        "id"          : 1,
        "channelName" : "STORE",
        "name"        : "Initial Product Category Name",
        "description" : "Initial Product Category Description",
        "isShown"     : 1
      }
      """
      And there is a product with given attributes:
      """
      {
        "id"                          : 1,
        "name"                        : "Initial Food Name",
        "description"                 : "Initial Food Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 10,
        "isViewNotification"          : "Y",
        "merchantOriginalPrice"       : 100000,
        "channelName"                 : "STORE",
        "dateAdded"                   : "2015-04-10",
        "dateModified"                : "2015-04-10",
        "dateRequested"               : "2015-04-10",
        "dateVerified"                : "2015-04-10",
        "isFeatured"                  : 1,
        "sold"                        : 100,
        "sellPrice"                   : 100000,
        "isShownOnListing"            : 1,
        "listIndex"                   : 1,
        "categoryId"                  : 1,
        "userId"                      : 1,
        "kotaId"                      : 1,
        "kategoriId"                  : 1
      }
      """
      And there is a product photo with given attributes:
      """
      {
        "id"           : 1,
        "description"  : "Initial Product Photo Description",
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "productId"    : 1
      }
      """
      And there is a product comment with given attributes:
      """
      {
        "id"           : 1,
        "comment"      : "Initial Comment",
        "isPublished"  : true,
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "userId"       : 1,
        "productId"    : 1
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 1,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 1
      }
      """
      And there is a store with given attributes:
      """
      {
        "id"                      : 1,
        "country"                 : "Indonesia",
        "name"                    : "Initial Store Name",
        "ownerName"               : "Initial Owner Name",
        "ownerBirthDate"          : "2015-04-10",
        "description"             : "Initial Store Description",
        "address"                 : "Initial Store Addres",
        "phoneNumber"             : "081234567890",
        "isViewingNotification"   : 1,
        "yahooMessengerId"        : "yahoomessengerid",
        "facebookId"              : "facebookid",
        "twitterId"               : "twitterid",
        "blackBerryId"            : "blackberryid",
        "whatsAppId"              : "whatsappid",
        "email"                   : "user@domain.tld",
        "bankAccountName"         : "Initial Bank Account Name",
        "bankAccountBranch"       : "Bogor",
        "bankAccountNumber"       : "12345678901234",
        "bankAccountOwner"        : "Initial Bank Account Owner",
        "storeStatus"             : "approve",
        "dateAdded"               : "2015-04-10",
        "dateModified"            : "2015-04-10",
        "dateRequested"           : "2015-04-10",
        "dateVerified"            : "2015-04-10",
        "merchantPhoneNumber"     : "081234567890",
        "merchantGender"          : "M",
        "rejectReason"            : "",
        "createdBy"               : 1,
        "kotaId"                  : 1,
        "propinsiId"              : 1,
        "kabupatenId"             : 1,
        "kecamatenId"             : 1,
        "userId"                  : 1,
        "salesId"                 : 1,
        "jneOriginId"             : 1
      }
      """
      And I am on homepage
     Then the ".featured-list.container" element should contain "Initial Food Name"

Scenario: Best Gadget
    Given there is a user with given attributes:
      """
      {
        "id"           : 1,
        "username"     : "user@domain.tld",
        "password"     : "userpass",
        "salt"         : "usersalt",
        "email"        : "user@domain.tld",
        "mobileNumber" : "081234567890",
        "isActive"     : 1,
        "statusId"     : 1
      }
      """
      And there is a propinsi with given attributes:
      """
      {
        "id"   : 1,
        "name" : "Jawa Barat"
      }
      """
      And there is a kabupaten with given attributes:
      """
      {
        "id"         : 1,
        "name"       : "Kab. Bogor",
        "propinsiId" : 1
      }
      """
      And there is a kecamatan with given attributes:
      """
      {
        "id"          : 1,
        "name"        : "Gunung Putri",
        "kabupatenId" : 1
      }
      """
      And there is a product category with given attributes:
      """
      {
        "id"          : 1,
        "channelName" : "LIFESTYLE",
        "name"        : "Initial Product Category Name",
        "description" : "Initial Product Category Description",
        "isShown"     : 1
      }
      """
      And there is a product with given attributes:
      """
      {
        "id"                          : 1,
        "name"                        : "Initial Fashion Name",
        "description"                 : "Initial Fashion Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 10,
        "isViewNotification"          : "Y",
        "merchantOriginalPrice"       : 100000,
        "channelName"                 : "LIFESTYLE",
        "dateAdded"                   : "2015-04-10",
        "dateModified"                : "2015-04-10",
        "dateRequested"               : "2015-04-10",
        "dateVerified"                : "2015-04-10",
        "isFeatured"                  : 1,
        "sold"                        : 100,
        "sellPrice"                   : 100000,
        "isShownOnListing"            : 1,
        "listIndex"                   : 1,
        "categoryId"                  : 1,
        "userId"                      : 1,
        "kotaId"                      : 1,
        "kategoriId"                  : 1
      }
      """
      And there is a product photo with given attributes:
      """
      {
        "id"           : 1,
        "description"  : "Initial Product Photo Description",
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "productId"    : 1
      }
      """
      And there is a product comment with given attributes:
      """
      {
        "id"           : 1,
        "comment"      : "Initial Comment",
        "isPublished"  : true,
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "userId"       : 1,
        "productId"    : 1
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 1,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 1
      }
      """
      And there is a store with given attributes:
      """
      {
        "id"                      : 1,
        "country"                 : "Indonesia",
        "name"                    : "Initial Store Name",
        "ownerName"               : "Initial Owner Name",
        "ownerBirthDate"          : "2015-04-10",
        "description"             : "Initial Store Description",
        "address"                 : "Initial Store Addres",
        "phoneNumber"             : "081234567890",
        "isViewingNotification"   : 1,
        "yahooMessengerId"        : "yahoomessengerid",
        "facebookId"              : "facebookid",
        "twitterId"               : "twitterid",
        "blackBerryId"            : "blackberryid",
        "whatsAppId"              : "whatsappid",
        "email"                   : "user@domain.tld",
        "bankAccountName"         : "Initial Bank Account Name",
        "bankAccountBranch"       : "Bogor",
        "bankAccountNumber"       : "12345678901234",
        "bankAccountOwner"        : "Initial Bank Account Owner",
        "storeStatus"             : "approve",
        "dateAdded"               : "2015-04-10",
        "dateModified"            : "2015-04-10",
        "dateRequested"           : "2015-04-10",
        "dateVerified"            : "2015-04-10",
        "merchantPhoneNumber"     : "081234567890",
        "merchantGender"          : "M",
        "rejectReason"            : "",
        "createdBy"               : 1,
        "kotaId"                  : 1,
        "propinsiId"              : 1,
        "kabupatenId"             : 1,
        "kecamatenId"             : 1,
        "userId"                  : 1,
        "salesId"                 : 1,
        "jneOriginId"             : 1
      }
      """
      And I am on homepage
     Then the ".featured-list.container" element should contain "Initial Fashion Name"

Scenario: Best Gadget
    Given there is a user with given attributes:
      """
      {
        "id"           : 1,
        "username"     : "user@domain.tld",
        "password"     : "userpass",
        "salt"         : "usersalt",
        "email"        : "user@domain.tld",
        "mobileNumber" : "081234567890",
        "isActive"     : 1,
        "statusId"     : 1
      }
      """
      And there is a propinsi with given attributes:
      """
      {
        "id"   : 1,
        "name" : "Jawa Barat"
      }
      """
      And there is a kabupaten with given attributes:
      """
      {
        "id"         : 1,
        "name"       : "Kab. Bogor",
        "propinsiId" : 1
      }
      """
      And there is a kecamatan with given attributes:
      """
      {
        "id"          : 1,
        "name"        : "Gunung Putri",
        "kabupatenId" : 1
      }
      """
      And there is a product category with given attributes:
      """
      {
        "id"          : 1,
        "channelName" : "GADGET",
        "name"        : "Initial Product Category Name",
        "description" : "Initial Product Category Description",
        "isShown"     : 1
      }
      """
      And there is a product with given attributes:
      """
      {
        "id"                          : 1,
        "name"                        : "Initial Gadget Name",
        "description"                 : "Initial Gadget Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 10,
        "isViewNotification"          : "Y",
        "merchantOriginalPrice"       : 100000,
        "channelName"                 : "GADGET",
        "dateAdded"                   : "2015-04-10",
        "dateModified"                : "2015-04-10",
        "dateRequested"               : "2015-04-10",
        "dateVerified"                : "2015-04-10",
        "isFeatured"                  : 1,
        "sold"                        : 100,
        "sellPrice"                   : 100000,
        "isShownOnListing"            : 1,
        "listIndex"                   : 1,
        "categoryId"                  : 1,
        "userId"                      : 1,
        "kotaId"                      : 1,
        "kategoriId"                  : 1
      }
      """
      And there is a product photo with given attributes:
      """
      {
        "id"           : 1,
        "description"  : "Initial Product Photo Description",
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "productId"    : 1
      }
      """
      And there is a product comment with given attributes:
      """
      {
        "id"           : 1,
        "comment"      : "Initial Comment",
        "isPublished"  : true,
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "userId"       : 1,
        "productId"    : 1
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 1,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 1
      }
      """
      And there is a store with given attributes:
      """
      {
        "id"                      : 1,
        "country"                 : "Indonesia",
        "name"                    : "Initial Store Name",
        "ownerName"               : "Initial Owner Name",
        "ownerBirthDate"          : "2015-04-10",
        "description"             : "Initial Store Description",
        "address"                 : "Initial Store Addres",
        "phoneNumber"             : "081234567890",
        "isViewingNotification"   : 1,
        "yahooMessengerId"        : "yahoomessengerid",
        "facebookId"              : "facebookid",
        "twitterId"               : "twitterid",
        "blackBerryId"            : "blackberryid",
        "whatsAppId"              : "whatsappid",
        "email"                   : "user@domain.tld",
        "bankAccountName"         : "Initial Bank Account Name",
        "bankAccountBranch"       : "Bogor",
        "bankAccountNumber"       : "12345678901234",
        "bankAccountOwner"        : "Initial Bank Account Owner",
        "storeStatus"             : "approve",
        "dateAdded"               : "2015-04-10",
        "dateModified"            : "2015-04-10",
        "dateRequested"           : "2015-04-10",
        "dateVerified"            : "2015-04-10",
        "merchantPhoneNumber"     : "081234567890",
        "merchantGender"          : "M",
        "rejectReason"            : "",
        "createdBy"               : 1,
        "kotaId"                  : 1,
        "propinsiId"              : 1,
        "kabupatenId"             : 1,
        "kecamatenId"             : 1,
        "userId"                  : 1,
        "salesId"                 : 1,
        "jneOriginId"             : 1
      }
      """
      And I am on homepage
     Then the ".new.container" element should contain "Initial Gadget Name"
