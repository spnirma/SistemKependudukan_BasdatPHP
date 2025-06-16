@frontend
Feature: Product Detail
  In order to interact with product which sold at Cipika Store
  As a website user
  I need to be able to view product detail

  Scenario: Accessing product detail of unavailable product
    Given I am on "/product/detail/1"
     Then I should see "Maaf produk sedang tidak tersedia"

  Scenario: Accessing product detail page from homepage featured list
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
        "name"                        : "Initial Product Name",
        "description"                 : "Initial Product Description",
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
     Then the ".featured-list.container" element should contain "Initial Product Name"
     When I follow "Initial Product Name"
     Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".detail-title" element should contain "Initial Product Name"
      And the ".description" element should contain "Initial Product Description"
      And the ".price" element should contain "100.000"
      And the ".merchant-verify" element should contain "Initial Store Name"
      
    Scenario: Accessing product detail unverify page from url
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
        "id"                          : 2,
        "name"                        : "Initial Product Name2",
        "description"                 : "Initial Product Description2",
        "packetDetail"                : "Initial Packet Detail2",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 0,
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
        "id"           : 2,
        "description"  : "Initial Product Photo Description",
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "productId"    : 2
      }
      """
      And there is a product comment with given attributes:
      """
      {
        "id"           : 2,
        "comment"      : "Initial Comment",
        "isPublished"  : true,
        "dateAdded"    : "2015-04-10",
        "dateModified" : "2015-04-10",
        "userId"       : 1,
        "productId"    : 2
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 1,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 2
      }
      """
      And there is a store with given attributes:
      """
      {
        "id"                      : 2,
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
        "storeStatus"             : "pending",
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
        Given I am on "/product/detail/2"
        Then I should see "Maaf produk sedang tidak tersedia"
        
    Scenario: Accessing product detail out of stock page homepage
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
        "id"                          : 3,
        "name"                        : "Initial Product Name3",
        "description"                 : "Initial Product Description3",
        "packetDetail"                : "Initial Packet Detail3",
        "productStock"                : 0,
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
        "productId"    : 3
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
        "productId"    : 3
      }
      """
      And there is a product statistic with given attributes:
      """
      {
        "orderQuantity" : 10,
        "dateUpdated"   : "2015-04-10",
        "productId"     : 3
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
      Then the ".featured-list.container" element should contain "Initial Product Name3"
      When I follow "Initial Product Name3"
      Then I should be on "/product/detail/3/Initial-Product-Name3"
      And the ".detail-title" element should contain "Initial Product Name3"
      And the ".description" element should contain "Initial Product Description3"
      And the ".price" element should contain "100.000"
      And the ".merchant-verify" element should contain "Initial Store Name"
      And the ".btn-buy" element should contain "Sold Out"
      
    Scenario: Add product to cart
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
        "name"                        : "Initial Product Name",
        "description"                 : "Initial Product Description",
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
      Then the ".featured-list.container" element should contain "Initial Product Name"
      When I follow "Initial Product Name"
      Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".detail-title" element should contain "Initial Product Name"
      And the ".description" element should contain "Initial Product Description"
      And the ".price" element should contain "100.000"
      And the ".merchant-verify" element should contain "Initial Store Name"
      When I press "add-cart-btn"
      Then the ".shopping-item" element should contain "1"
      When I press "add-cart-btn"
      Then the ".shopping-item" element should contain "2"
    
    Scenario: checking for breadcrumb, isi paket, lokasi merchant, berat gram, love count, deskripsi
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
        "name"                        : "Initial Product Name",
        "description"                 : "Initial Product Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 0,
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
      Then the ".featured-list.container" element should contain "Initial Product Name"
      When I follow "Initial Product Name"
      Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".detail-title" element should contain "Initial Product Name"
      And the ".description" element should contain "Initial Product Description"
      And the ".price" element should contain "100.000"
      And the ".merchant-verify" element should contain "Initial Store Name"
      And the ".breadcrumb" element should contain "Gadget"
      And the ".breadcrumb" element should contain "Initial Product Category Name"
      And the ".breadcrumb" element should contain "Initial Product Name"
      And the "#isi_paket" element should contain "Initial Packet Detail"
      And the "#lokasi_merchant" element should contain "Kab. Bogor"
      And the "#berat" element should contain "10000 gram"
      
      When I follow "product-love-detail"
      Then I should see "Masuk"
      And I should see "Daftar"
      When I follow "Masuk"
      And I fill in "email" with "user@domain.tld"
      And I fill in "password" with "userpass"
      And I press "Masuk"
      Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".love-value-1" element should contain "0"
      When I follow "product-love-detail"
      Then the ".love-value-1" element should contain "1"
      When I follow "product-love-detail"
      Then the ".love-value-1" element should contain "0"
      
      Scenario: Checking right sidebar for merchant page link, followers, rating, suka, dilihat, and terbeli element
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
        "name"                        : "Initial Product Name",
        "description"                 : "Initial Product Description",
        "packetDetail"                : "Initial Packet Detail",
        "productStock"                : 10,
        "productPrice"                : 100000,
        "weight"                      : 10,
        "jneWeight"                   : 10,
        "isPublished"                 : 1,
        "viewed"                      : 10,
        "loved"                       : 0,
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
      Then the ".featured-list.container" element should contain "Initial Product Name"
      When I follow "Initial Product Name"
      Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".detail-title" element should contain "Initial Product Name"
      When I follow "merchant_store"
      Then I should be on "/store/id/1"
      And I should see "Initial Store Name"
      When I follow "Initial Product Name"
      Then I should be on "/product/detail/1/Initial-Product-Name"
      And the ".detail-title" element should contain "Initial Product Name"
      And the ".jumlah_follower" element should contain "0"
      And the ".love-value-1" element should contain "0"
      And the ".dilihat" element should contain "2"
      And the ".terbeli" element should contain "0"
      
      
