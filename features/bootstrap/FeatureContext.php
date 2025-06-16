<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

    private $db;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->db = self::getDbConnection();
    }

    private static function getDbConnection()
    {
        $configFile = array_filter(
            [
                __DIR__ . '/../../application/config/development/database.php',
                __DIR__ . '/../../application/config/testing/database.php',
                __DIR__ . '/../../application/config/database.php',
            ],
            'is_file'
        );

        $configFile = current($configFile);

        if (!defined('BASEPATH')) {
            define('BASEPATH', '');
        }
        $dbConfig   = include $configFile;

        $connectionManager = new \Cipika\Component\Database\ConnectionManager();
        $dbal = $connectionManager->createFromCiConfig($db['default']);

        return $dbal;
    }

    /**
     * @BeforeSuite
     */
    public static function checkDB(BeforeSuiteScope $scope)
    {
        $dbal = self::getDbConnection();
        $dbChecker = new \Cipika\Component\Behat\Util\DatabaseChecker($dbal);
        $dbChecker->check();
    }

    /**
     * @BeforeScenario
     */
    public function resizeWindow(BeforeScenarioScope $scope)
    {
        $tags = $scope->getFeature()->getTags();
        if (in_array('small_screen', $tags)) {
            $this->getSession()->resizeWindow(480, 960);
        }

        $this->getSession()->resizeWindow(1280, 800);
    }

    /**
     * @AfterScenario
     */
    public function purgeDatabase(AfterScenarioScope $scope)
    {
        $dbal = self::getDbConnection();
        $purger = new \Cipika\Component\Behat\Util\DatabasePurger($dbal);
        $purger->purge();
    }

    /**
     * @Given There is a page :title with id :id and content :content
     */
    public function thereIsAPageWithIdAndContent($title, $id, $content)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->insert('tbl_page')
           ->values([
                'id_page' => ':id',
                'title'   => ':title',
                'content' => ':content',
                'publish' => 1,
                'show_on_footer' => 1,
           ])
           ->setParameter('title', $title)
           ->setParameter('id', $id)
           ->setParameter('content', $content);
        $qb->execute();
    }

    /**
     * @Then there should be a user with email :email and password :password
     */
    public function thereShouldBeAUserWithEmailPassword($email, $password)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('email, password')
           ->from('tbl_user')
           ->where('tbl_user.email = :email')
           ->andWhere('tbl_user.password = :password')
           ->setParameter('password', md5($password))
           ->setParameter('email', $email);

        $result = $qb->execute()->fetchAll();

        if (empty($result)) {
            throw new \Exception('The is no user with the given email and password.');
        }
    }

    /**
     * @Given there is a user with email :email and password :password
     */
    public function thereIsAUserWithEmailAndPassword($email, $password)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->insert('tbl_user')
           ->values([
                'id_user'    => ':idUser',
                'username'   => ':email',
                'password'   => ':password',
                'salt'       => ':password',
                'email'      => ':email',
                'hp'         => ':nomorTelepon',
                'active'     => ':active',
                'id_status'  => ':idStatus',
           ])
           ->setParameter('idUser', 1)
           ->setParameter('password', md5($password))
           ->setParameter('email', $email)
           ->setParameter('nomorTelepon', '081234567890')
           ->setParameter('active', 1)
           ->setParameter('idStatus', 1);

        $qb->execute();
    }

    /**
     * @Then I should see an error balloon :message
     */
    public function iShouldSeeAnErrorBalloon($message)
    {
        $this->getSession()->wait(5000, '(0 === jQuery.active)');

        $this->assertPageContainsText($message);
    }

    /**
     * @Given there is a user with given attributes:
     */
    public function thereIsAUserWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_user')
             ->values([
                 'id_user'                 => ':id',
                 'ip_address'              => ':ipAddress',
                 'username'                => ':username',
                 'password'                => ':password',
                 'salt'                    => ':salt',
                 'email'                   => ':email',
                 'activation_code'         => ':activationCode',
                 'forgotten_password_code' => ':forgottenPasswordCode',
                 'forgotten_password_time' => ':forgottenPasswordTime',
                 'remember_code'           => ':rememberCode',
                 'last_login'              => ':lastLogin',
                 'active'                  => ':isActive',
                 'firstname'               => ':firstName',
                 'lastname'                => ':lastName',
                 'image'                   => ':image',
                 'alamat'                  => ':address',
                 'telpon'                  => ':phoneNumber',
                 'hp'                      => ':mobileNumber',
                 'bio'                     => ':biography',
                 'newsletter'              => ':newsLetter',
                 'id_kota'                 => ':kotaId',
                 'id_propinsi'             => ':propinsiId',
                 'id_kabupaten'            => ':kabupatenId',
                 'id_kecamatan'            => ':kecamatanId',
                 'id_level'                => ':levelId',
                 'id_status'               => ':statusId',
                 'id_group'                => ':groupId',
                 'kode_agregator'          => ':aggregatorCode',
                 'date_added'              => ':dateAdded',
                 'date_modified'           => ':dateModified',
                 'date_verified'           => ':dateVerified',
                 'birthdate'               => ':birthDate',
                 'fb_token'                => ':facebookToken',
                 'fb_name'                 => ':facebookName',
                 'fb_email'                => ':facebookEmail',
                 'fb_token_expired'        => ':facebookTokenExpiration',
                 'tw_token'                => ':twitterToken',
                 'tw_secret'               => ':twitterSecret',
                 'gcm_id'                  => ':gcmId',
                 'receive_gcm'             => ':isReceiveGcm',
                 'gender'                  => ':gender',
                 'deleted'                 => ':isDeleted',
                 'id_key'                  => ':keyId',
                 'app_version'             => ':applicationVersion',
                 'bank_nama'               => ':bankAccountName',
                 'bank_norek'              => ':bankAccountNumber',
                 'bank_pemilik'            => ':bankAccountOwner',
                 'created_by'              => ':createdBy'
             ])
             ->setParameters([
                 'id'                      => isset($attributes['id']) ? $attributes['id'] : 0,
                 'ipAddress'               => isset($attributes['ipAddress']) ? $attributes['ipAddress'] : 0,
                 'username'                => isset($attributes['username']) ? $attributes['username'] : 0,
                 'password'                => isset($attributes['password']) ? md5($attributes['password']) : null,
                 'salt'                    => isset($attributes['salt']) ? md5($attributes['salt']) : null,
                 'email'                   => isset($attributes['email']) ? $attributes['email'] : null,
                 'activationCode'          => isset($attributes['activationCode']) ? $attributes['activationCode'] : null,
                 'forgottenPasswordCode'   => isset($attributes['forgottenPasswordCode']) ? $attributes['forgottenPasswordCode'] : null,
                 'forgottenPasswordTime'   => isset($attributes['forgottenPasswordTime']) ? $attributes['forgottenPasswordTime'] : null,
                 'rememberCode'            => isset($attributes['rememberCode']) ? $attributes['rememberCode'] : null,
                 'lastLogin'               => isset($attributes['lastLogin']) ? $attributes['lastLogin'] : null,
                 'isActive'                => isset($attributes['isActive']) ? $attributes['isActive'] : 0,
                 'firstName'               => isset($attributes['firstName']) ? $attributes['firstName'] : null,
                 'lastName'                => isset($attributes['lastName']) ? $attributes['lastName'] : null,
                 'image'                   => isset($attributes['image']) ? $attributes['image'] : null,
                 'address'                 => isset($attributes['address']) ? $attributes['address'] : null,
                 'phoneNumber'             => isset($attributes['phoneNumber']) ? $attributes['phoneNumber'] : null,
                 'mobileNumber'            => isset($attributes['mobileNumber']) ? $attributes['mobileNumber'] : null,
                 'biography'               => isset($attributes['biography']) ? $attributes['biography'] : null,
                 'newsLetter'              => isset($attributes['newsLetter']) ? $attributes['newsLetter'] : null,
                 'kotaId'                  => isset($attributes['kotaId']) ? $attributes['kotaId'] : null,
                 'propinsiId'              => isset($attributes['propinsiId']) ? $attributes['propinsiId'] : null,
                 'kabupatenId'             => isset($attributes['kabupatenId']) ? $attributes['kabupatenId'] : null,
                 'kecamatanId'             => isset($attributes['kecamatanId']) ? $attributes['kecamatanId'] : null,
                 'levelId'                 => isset($attributes['levelId']) ? $attributes['levelId'] : 3,
                 'statusId'                => isset($attributes['statusId']) ? $attributes['statusId'] : 4,
                 'groupId'                 => isset($attributes['groupId']) ? $attributes['groupId'] : 3,
                 'aggregatorCode'          => isset($attributes['aggregatorCode']) ? $attributes['aggregatorCode'] : null,
                 'dateAdded'               => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                 'dateModified'            => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                 'dateVerified'            => isset($attributes['dateVerified']) ? $attributes['dateVerified'] : null,
                 'birthDate'               => isset($attributes['birthDate']) ? $attributes['birthDate'] : null,
                 'facebookToken'           => isset($attributes['facebookToken']) ? $attributes['facebookToken'] : null,
                 'facebookName'            => isset($attributes['facebookName']) ? $attributes['facebookName'] : null,
                 'facebookEmail'           => isset($attributes['facebookEmail']) ? $attributes['facebookEmail'] : null,
                 'facebookTokenExpiration' => isset($attributes['facebookTokenExpiration']) ? $attributes['facebookTokenExpiration'] : null,
                 'twitterToken'            => isset($attributes['twitterToken']) ? $attributes['twitterToken'] : null,
                 'twitterSecret'           => isset($attributes['twitterSecret']) ? $attributes['twitterSecret'] : null,
                 'gcmId'                   => isset($attributes['gcmId']) ? $attributes['gcmId'] : null,
                 'isReceiveGcm'            => isset($attributes['isReceiveGcm']) ? $attributes['isReceiveGcm'] : 0,
                 'gender'                  => isset($attributes['gender']) ? $attributes['gender'] : null,
                 'isDeleted'               => isset($attributes['isDeleted']) ? $attributes['isDeleted'] : 0,
                 'keyId'                   => isset($attributes['keyId']) ? $attributes['keyId'] : null,
                 'applicationVersion'      => isset($attributes['applicationVersion']) ? $attributes['applicationVersion'] : null,
                 'bankAccountName'         => isset($attributes['bankAccountName']) ? $attributes['bankAccountName'] : null,
                 'bankAccountNumber'       => isset($attributes['bankAccountNumber']) ? $attributes['bankAccountNumber'] : null,
                 'bankAccountOwner'        => isset($attributes['bankAccountOwner']) ? $attributes['bankAccountOwner'] : null,
                 'createdBy'               => isset($attributes['createdBy']) ? $attributes['createdBy'] : 0
            ])
            ->execute();
    }

    /**
     * @Given there is a propinsi with given attributes:
     */
    public function thereIsAPropinsiWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_propinsi')
             ->values([
                 'id_propinsi'   => ':id',
                 'nama_propinsi' => ':name'
             ])
             ->setParameters([
                 'id'   => isset($attributes['id']) ? $attributes['id'] : null,
                 'name' => isset($attributes['name']) ? $attributes['name'] : null,
             ])
             ->execute();
    }

    /**
     * @Given there is a kota with given attributes:
     */
    public function thereIsAKotaWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_kota')
             ->values([
                 'id'          => ':id',
                 'kode_kota'   => ':code',
                 'nama_kota'   => ':name',
                 'id_propinsi' => ':propinsiId'
             ])
             ->setParameters([
                 'id'         => isset($attributes['id']) ? $attributes['id'] : null,
                 'code'       => isset($attributes['code']) ? $attributes['code'] : null,
                 'name'       => isset($attributes['name']) ? $attributes['name'] : null,
                 'propinsiId' => isset($attributes['propinsiId']) ? $attributes['propinsiId'] : null
             ])
             ->execute();
    }

    /**
     * @Given there is a kabupaten with given attributes:
     */
    public function thereIsAKabupatenWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_kabupaten')
             ->values([
                 'id_kabupaten'   => ':id',
                 'nama_kabupaten' => ':name',
                 'id_propinsi'    => ':propinsiId'
             ])
             ->setParameters([
                 'id'         => isset($attributes['id']) ? $attributes['id'] : null,
                 'name'       => isset($attributes['name']) ? $attributes['name'] : null,
                 'propinsiId' => isset($attributes['propinsiId']) ? $attributes['propinsiId'] : null
             ])
             ->execute();
    }

    /**
     * @Given there is a kecamatan with given attributes:
     */
    public function thereIsAKecamatanWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_kecamatan')
             ->values([
                 'id_kecamatan'   => ':id',
                 'nama_kecamatan' => ':name',
                 'id_kabupaten'   => ':kabupatenId'
             ])
             ->setParameters([
                 'id'          => isset($attributes['id']) ? $attributes['id'] : null,
                 'name'        => isset($attributes['name']) ? $attributes['name'] : null,
                 'kabupatenId' => isset($attributes['kabupatenId']) ? $attributes['kabupatenId'] : null
             ])
             ->execute();
    }

    /**
     * @Given there is a product category with given attributes:
     */
    public function thereIsAProductCategoryWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_kategori')
             ->values([
                 'id_kategori'   => ':id',
                 'channel'       => ':channelName',
                 'nama_kategori' => ':name',
                 'keterangan'    => ':description',
                 'id_parent'     => ':parentId',
                 '`show`'          => ':isShown'
             ])
             ->setParameters([
                 'id'          => isset($attributes['id']) ? $attributes['id'] : null,
                 'channelName' => isset($attributes['channelName']) ? $attributes['channelName'] : null,
                 'name'        => isset($attributes['name']) ? $attributes['name'] : null,
                 'description' => isset($attributes['description']) ? $attributes['description'] : null,
                 'parentId'    => isset($attributes['parentId']) ? $attributes['parentId'] : 0,
                 'isShown'     => isset($attributes['isShown']) ? $attributes['isShown'] : 1
             ])
             ->execute();
    }

    /**
     * @Given there is a product with given attributes:
     */
    public function thereIsAProductWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_produk')
             ->values([
                 'id_produk'                       => ':id',
                 'id_parent'                       => ':parentId',
                 'nama_produk'                     => ':name',
                 'deskripsi'                       => ':description',
                 'detail_paket'                    => ':packetDetail',
                 'stok_produk'                     => ':productStock',
                 'harga_produk'                    => ':productPrice',
                 'diskon_merchant'                 => ':merchantDiscount',
                 'diskon'                          => ':discount',
                 'berat'                           => ':weight',
                 'panjang'                         => ':height',
                 'lebar'                           => ':width',
                 'tinggi'                          => ':tall',
                 'jne_berat'                       => ':jneWeight',
                 'produk_cairan'                   => ':isLiquidProduct',
                 'publish'                         => ':isPublished',
                 'nego'                            => ':isNegotiable',
                 'viewed'                          => ':viewed',
                 'loved'                           => ':loved',
                 'view_notif'                      => ':isViewNotification',
                 'harga_asli_merchant'             => ':merchantOriginalPrice',
                 'channel'                         => ':channelName',
                 'date_added'                      => ':dateAdded',
                 'date_modified'                   => ':dateModified',
                 'date_request'                    => ':dateRequested',
                 'date_verified'                   => ':dateVerified',
                 'date_unverified'                 => ':dateUnverified',
                 'pick'                            => ':isPicked',
                 'unggulan'                        => ':isFeatured',
                 'terjual'                         => ':sold',
                 'blended_transaction_fee'         => ':blendedTransactionFee',
                 'blended_insentif_cipika'         => ':blendedIncentiveCipika',
                 'blended_shipping_fee_to_jakarta' => ':blendedShippingFeeToJakarta',
                 'selisih_pembulatan'              => ':rounded_difference',
                 'free_shipping'                   => ':isFreeShipping',
                 'harga_jual'                      => ':sellPrice',
                 'nominal_voucher_reload'          => ':reloadVoucherAmount',
                 'provider_voucher_reload'         => ':reloadVoucherProvider',
                 'deleted'                         => ':isDeleted',
                 'shipping_area'                   => ':shippingArea',
                 'area_produk'                     => ':productArea',
                 'verified_by'                     => ':verifiedBy',
                 'unverified_by'                   => ':unverifiedBy',
                 'alasan_ditolak'                  => ':rejectReason',
                 'show_on_listing'                 => ':isShownOnListing',
                 'list_index'                      => ':listIndex',
                 'id_kategori'                     => ':categoryId',
                 'id_user'                         => ':userId',
                 'id_kota'                         => ':kotaId',
                 'id_tag'                          => ':tagId'
             ])
             ->setParameters([
                 'id'                          => isset($attributes['id']) ? $attributes['id'] : null,
                 'parentId'                    => isset($attributes['parentId']) ? $attributes['parentId'] : null,
                 'name'                        => isset($attributes['name']) ? $attributes['name'] : 'the product',
                 'description'                 => isset($attributes['description']) ? $attributes['description'] : null,
                 'packetDetail'                => isset($attributes['packetDetail']) ? $attributes['packetDetail'] : null,
                 'productStock'                => isset($attributes['productStock']) ? $attributes['productStock'] : 0,
                 'productPrice'                => isset($attributes['productPrice']) ? $attributes['productPrice'] : 0,
                 'merchantDiscount'            => isset($attributes['merchantDiscount']) ? $attributes['merchantDiscount'] : null,
                 'discount'                    => isset($attributes['discount']) ? $attributes['discount'] : 0,
                 'weight'                      => isset($attributes['weight']) ? $attributes['weight'] : 0,
                 'height'                      => isset($attributes['height']) ? $attributes['height'] : 0,
                 'width'                       => isset($attributes['width']) ? $attributes['width'] : 0,
                 'tall'                        => isset($attributes['tall']) ? $attributes['tall'] : 0,
                 'jneWeight'                   => isset($attributes['jneWeight']) ? $attributes['jneWeight'] : null,
                 'isLiquidProduct'             => isset($attributes['isLiquidProduct']) ? $attributes['isLiquidProduct'] : 0,
                 'isPublished'                 => isset($attributes['isPublished']) ? $attributes['isPublished'] : 0,
                 'isNegotiable'                => isset($attributes['isNegotiable']) ? $attributes['isNegotiable'] : 0,
                 'viewed'                      => isset($attributes['viewed']) ? $attributes['viewed'] : 0,
                 'loved'                       => isset($attributes['loved']) ? $attributes['loved'] : 0,
                 'isViewNotification'          => isset($attributes['isViewNotification']) ? $attributes['isViewNotification'] : 'N',
                 'merchantOriginalPrice'       => isset($attributes['merchantOriginalPrice']) ? $attributes['merchantOriginalPrice'] : 0,
                 'channelName'                 => isset($attributes['channelName']) ? $attributes['channelName'] : 'STORE',
                 'dateAdded'                   => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                 'dateModified'                => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                 'dateRequested'               => isset($attributes['dateVerified']) ? $attributes['dateVerified'] : null,
                 'dateVerified'                => isset($attributes['dateVerified']) ? $attributes['dateVerified'] : null,
                 'dateUnverified'              => isset($attributes['dateUnverified']) ? $attributes['dateUnverified'] : null,
                 'isPicked'                    => isset($attributes['isPicked']) ? $attributes['isPicked'] : 0,
                 'isFeatured'                  => isset($attributes['isFeatured']) ? $attributes['isFeatured'] : 0,
                 'sold'                        => isset($attributes['sold']) ? $attributes['sold'] : 0,
                 'blendedTransactionFee'       => isset($attributes['blendedTransactionFee']) ? $attributes['blendedTransactionFee'] : 0,
                 'blendedIncentiveCipika'      => isset($attributes['blendedIncentiveCipika']) ? $attributes['blendedIncentiveCipika'] : 0,
                 'blendedShippingFeeToJakarta' => isset($attributes['blendedShippingFeeToJakarta']) ? $attributes['blendedShippingFeeToJakarta'] : 0,
                 'rounded_difference'          => isset($attributes['rounded_difference']) ? $attributes['rounded_difference'] : 0,
                 'isFreeShipping'              => isset($attributes['isFreeShipping']) ? $attributes['isFreeShipping'] : 0,
                 'sellPrice'                   => isset($attributes['sellPrice']) ? $attributes['sellPrice'] : 0,
                 'reloadVoucherAmount'         => isset($attributes['reloadVoucherAmount']) ? $attributes['reloadVoucherAmount'] : null,
                 'reloadVoucherProvider'       => isset($attributes['reloadVoucherProvider']) ? $attributes['reloadVoucherProvider'] : null,
                 'isDeleted'                   => isset($attributes['isDeleted']) ? $attributes['isDeleted'] : 0,
                 'shippingArea'                => isset($attributes['shippingArea']) ? $attributes['shippingArea'] : 0,
                 'productArea'                 => isset($attributes['productArea']) ? $attributes['productArea'] : 0,
                 'verifiedBy'                  => isset($attributes['verifiedBy']) ? $attributes['verifiedBy'] : null,
                 'unverifiedBy'                => isset($attributes['unverifiedBy']) ? $attributes['unverifiedBy'] : null,
                 'rejectReason'                => isset($attributes['rejectReason']) ? $attributes['rejectReason'] : null,
                 'isShownOnListing'            => isset($attributes['isShownOnListing']) ? $attributes['isShownOnListing'] : 1,
                 'listIndex'                   => isset($attributes['listIndex']) ? $attributes['listIndex'] : 0,
                 'categoryId'                  => isset($attributes['categoryId']) ? $attributes['categoryId'] : null,
                 'userId'                      => isset($attributes['userId']) ? $attributes['userId'] : null,
                 'kotaId'                      => isset($attributes['kotaId']) ? $attributes['kotaId'] : null,
                 'tagId'                       => isset($attributes['tagId']) ? $attributes['tagId'] : null,

             ])
             ->execute();

        if (isset($attributes['kategoriId'])) {
            $this->db->createQueryBuilder()
                 ->insert('tbl_produk_kategori')
                 ->values([
                     'date_added'    => ':dateAdded',
                     'date_modified' => ':dateModified',
                     'id_produk'     => ':id',
                     'id_kategori'   =>  ':kategoriId'
                 ])
                 ->setParameters([
                    'dateAdded'    => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                    'dateModified' => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                    'id'           => isset($attributes['id']) ? $attributes['id'] : null,
                    'kategoriId'   => isset($attributes['kategoriId']) ? $attributes['kategoriId'] : null,
                 ])
                 ->execute();
        }
    }

    /**
     * @Given there is a product photo with given attributes:
     */
    public function thereIsAProductPhotoWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_produkfoto')
             ->values([
                 'id_produkFoto' => ':id',
                 'image'         => ':image',
                 'keterangan'    => ':description',
                 'date_added'    => ':dateAdded',
                 'date_modified' => ':dateModified',
                 'id_produk'     => ':productId'
             ])
             ->setParameters([
                 'id'           => isset($attributes['id']) ? $attributes['id'] : null,
                 'image'        => isset($attributes['image']) ? $attributes['image'] : null,
                 'description'  => isset($attributes['description']) ? $attributes['description'] : null,
                 'dateAdded'    => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                 'dateModified' => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                 'productId'    => isset($attributes['productId']) ? $attributes['productId'] : null,
             ])
             ->execute();
    }

    /**
     * @Given there is a product comment with given attributes:
     */
    public function thereIsAProductCommentWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_comment')
             ->values([
                 'id_comment'    => ':id',
                 'comment'       => ':comment',
                 'publish'       => ':isPublished',
                 'date_added'    => ':dateAdded',
                 'date_modified' => ':dateModified',
                 'parent_id'     => ':parentId',
                 'id_user'       => ':userId',
                 'id_produk'     => ':productId'
             ])
             ->setParameters([
                 'id'           => isset($attributes['id']) ? $attributes['id'] : null,
                 'comment'      => isset($attributes['comment']) ? $attributes['comment'] : null,
                 'isPublished'  => isset($attributes['isPublished']) ? $attributes['isPublished'] : null,
                 'dateAdded'    => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                 'dateModified' => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                 'parentId'     => isset($attributes['parentId']) ? $attributes['parentId'] : null,
                 'userId'       => isset($attributes['userId']) ? $attributes['userId'] : null,
                 'productId'    => isset($attributes['productId']) ? $attributes['productId'] : null
             ])
             ->execute();
    }

    /**
     * @Given there is a product statistic with given attributes:
     */
    public function thereIsAProductStatisticWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_product_stats')
             ->values([
                 'qty_order'    => ':orderQuantity',
                 'date_updated' => ':dateUpdated',
                 'id_produk'    => ':productId'
             ])
             ->setParameters([
                 'orderQuantity' => isset($attributes['orderQuantity']) ? $attributes['orderQuantity'] : null,
                 'dateUpdated'   => isset($attributes['dateUpdated']) ? $attributes['dateUpdated'] : null,
                 'productId'     => isset($attributes['productId']) ? $attributes['productId'] : null
             ])
             ->execute();
    }

    /**
     * @Given there is a store with given attributes:
     */
    public function thereIsAStoreWithGivenAttributes(PyStringNode $attributes)
    {
        $attributes = json_decode($attributes->getRaw(), true);

        $this->db->createQueryBuilder()
             ->insert('tbl_store')
             ->values([
                 'id_store'                => ':id',
                 'negara'                  => ':country',
                 'nama_store'              => ':name',
                 'nama_pemilik'            => ':ownerName',
                 'tgl_lahir_pemilik'       => ':ownerBirthDate',
                 'deskripsi'               => ':description',
                 'alamat'                  => ':address',
                 'telpon'                  => ':phoneNumber',
                 'view_notif'              => ':isViewingNotification',
                 'agregator'               => ':aggregator',
                 'merchant_indoloka'       => ':isMerchantIndoloka',
                 'indoloka_type'           => ':indolokaType',
                 'merchant_voucher_reload' => ':isMerchantVoucherReload',
                 'shipper'                 => ':isShipper',
                 'lokasi_pickup'           => ':pickupLocation',
                 'pic'                     => ':pic',
                 'telpon_pic'              => ':picPhoneNumber',
                 'ym'                      => ':yahooMessengerId',
                 'fb'                      => ':facebookId',
                 'tw'                      => ':twitterId',
                 'bb'                      => ':blackBerryId',
                 'wa'                      => ':whatsAppId',
                 'email'                   => ':email',
                 'bank_nama'               => ':bankAccountName',
                 'bank_branch'             => ':bankAccountBranch',
                 'bank_bi_code'            => ':bankBIAccountCode',
                 'bank_norek'              => ':bankAccountNumber',
                 'bank_pemilik'            => ':bankAccountOwner',
                 'store_status'            => ':storeStatus',
                 'date_added'              => ':dateAdded',
                 'date_modified'           => ':dateModified',
                 'date_request'            => ':dateRequested',
                 'date_verified'           => ':dateVerified',
                 'date_unverified'         => ':dateUnverified',
                 'merchant_hp'             => ':merchantPhoneNumber',
                 'merchant_gender'         => ':merchantGender',
                 'area_merchant'           => ':merchantArea',
                 'alasan_ditolak'          => ':rejectReason',
                 'created_by'              => ':createdBy',
                 'deleted'                 => ':isDeleted',
                 'id_kota'                 => ':kotaId',
                 'id_propinsi'             => ':propinsiId',
                 'id_kabupaten'            => ':kabupatenId',
                 'id_kecamatan'            => ':kecamatanId',
                 'id_user'                 => ':userId',
                 'id_sales'                => ':salesId',
                 'id_jne_origin'           => ':jneOriginId'
             ])
             ->setParameters([
                 'id'                      => isset($attributes['id']) ? $attributes['id'] : null,
                 'country'                 => isset($attributes['country']) ? $attributes['country'] : null,
                 'name'                    => isset($attributes['name']) ? $attributes['name'] : null,
                 'ownerName'               => isset($attributes['ownerName']) ? $attributes['ownerName'] : null,
                 'ownerBirthDate'          => isset($attributes['ownerBirthDate']) ? $attributes['ownerBirthDate'] : null,
                 'description'             => isset($attributes['description']) ? $attributes['description'] : null,
                 'address'                 => isset($attributes['address']) ? $attributes['address'] : null,
                 'phoneNumber'             => isset($attributes['phoneNumber']) ? $attributes['phoneNumber'] : null,
                 'isViewingNotification'   => isset($attributes['isViewingNotification']) ? $attributes['isViewingNotification'] : null,
                 'aggregator'              => isset($attributes['aggregator']) ? $attributes['aggregator'] : null,
                 'isMerchantIndoloka'      => isset($attributes['isMerchantIndoloka']) ? $attributes['isMerchantIndoloka'] : null,
                 'indolokaType'            => isset($attributes['indolokaType']) ? $attributes['indolokaType'] : 0,
                 'isMerchantVoucherReload' => isset($attributes['isMerchantVoucherReload']) ? $attributes['isMerchantVoucherReload'] : null,
                 'isShipper'               => isset($attributes['isShipper']) ? $attributes['isShipper'] : 0,
                 'pickupLocation'          => isset($attributes['pickupLocation']) ? $attributes['pickupLocation'] : null,
                 'pic'                     => isset($attributes['pic']) ? $attributes['pic'] : null,
                 'picPhoneNumber'          => isset($attributes['picPhoneNumber']) ? $attributes['picPhoneNumber'] : null,
                 'yahooMessengerId'        => isset($attributes['yahooMessengerId']) ? $attributes['yahooMessengerId'] : null,
                 'facebookId'              => isset($attributes['facebookId']) ? $attributes['facebookId'] : null,
                 'twitterId'               => isset($attributes['twitterId']) ? $attributes['twitterId'] : null,
                 'blackBerryId'            => isset($attributes['blackBerryId']) ? $attributes['blackBerryId'] : null,
                 'whatsAppId'              => isset($attributes['whatsAppId']) ? $attributes['whatsAppId'] : null,
                 'email'                   => isset($attributes['email']) ? $attributes['email'] : null,
                 'bankAccountName'         => isset($attributes['bankAccountName']) ? $attributes['bankAccountName'] : null,
                 'bankAccountBranch'       => isset($attributes['bankAccountBranch']) ? $attributes['bankAccountBranch'] : null,
                 'bankBIAccountCode'       => isset($attributes['bankBIAccountCode']) ? $attributes['bankBIAccountCode'] : null,
                 'bankAccountNumber'       => isset($attributes['bankAccountNumber']) ? $attributes['bankAccountNumber'] : null,
                 'bankAccountOwner'        => isset($attributes['bankAccountOwner']) ? $attributes['bankAccountOwner'] : null,
                 'storeStatus'             => isset($attributes['storeStatus']) ? $attributes['storeStatus']: null,
                 'dateAdded'               => isset($attributes['dateAdded']) ? $attributes['dateAdded'] : null,
                 'dateModified'            => isset($attributes['dateModified']) ? $attributes['dateModified'] : null,
                 'dateRequested'           => isset($attributes['dateRequested']) ? $attributes['dateRequested'] : null,
                 'dateVerified'            => isset($attributes['dateVerified']) ? $attributes['dateVerified'] : null,
                 'dateUnverified'          => isset($attributes['dateUnverified']) ? $attributes['dateUnverified'] : null,
                 'merchantPhoneNumber'     => isset($attributes['merchantPhoneNumber']) ? $attributes['merchantPhoneNumber'] : null,
                 'merchantGender'          => isset($attributes['merchantGender']) ? $attributes['merchantGender'] : null,
                 'merchantArea'            => isset($attributes['merchantArea']) ? $attributes['merchantArea'] : 0,
                 'rejectReason'            => isset($attributes['rejectReason']) ? $attributes['rejectReason'] : null,
                 'createdBy'               => isset($attributes['createdBy']) ? $attributes['createdBy'] : null,
                 'isDeleted'               => isset($attributes['isDeleted']) ? $attributes['isDeleted'] : 0,
                 'kotaId'                  => isset($attributes['kotaId']) ? $attributes['kotaId'] : null,
                 'propinsiId'              => isset($attributes['propinsiId']) ? $attributes['propinsiId'] : null,
                 'kabupatenId'             => isset($attributes['kabupatenId']) ? $attributes['kabupatenId'] : null,
                 'kecamatanId'             => isset($attributes['kecamatanId']) ? $attributes['kecamatanId'] : null,
                 'userId'                  => isset($attributes['userId']) ? $attributes['userId'] : null,
                 'salesId'                 => isset($attributes['salesId']) ? $attributes['salesId'] : null,
                 'jneOriginId'             => isset($attributes['jneOriginId']) ? $attributes['jneOriginId'] : null
             ])
             ->execute();
    }
}
