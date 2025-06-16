<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
//define('APPLICATION_ENVIRONMENT','testing');
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('DEV_PAYMENT', TRUE);
define('ADMIN_EMAIL', 'ali@firzil.co.id');

define('IP_SERVER', '54.254.229.60');

define('USER_ID_PAYMENT_TRANFER','36');
define('SECRET_ID_PAYMENT_TRANFER','d3v3l0pm3nt');
define('SHOW_PAYMENT_BANK_TRANSFER_PERMATA',TRUE);

define('USER_ID_DOMPETKU','thofa');
define('SECRET_KEY_DOMPETKU','DPtEIpWZmr4SlxTVD43Um5ES');
define('INITIATOR_DOMPETKU','outlet_1');
define('INITIATOR_PIN_DOMPETKU','123456');
define('SHOW_PAYMENT_DOMPETKU', true);
define('SHOW_PAYMENT_DOMPETKU2', true);

/** ID & API_KEY FACEBOOK APP**/
define('APPID_FB','549385521836660');
define('SECRETID_FB','319ef50712b73160a7121159a23b7856');

define('MERCHANT', TRUE);

/* IP & PORT SERVER MANDIRI CLICKPAY*/
//define('IP_SERVER_MANDIRI_CLICKPAY', '202.169.43.53');
//define('PORT_SERVER_MANDIRI_CLICKPAY', '18444');
define('IP_SERVER_MANDIRI_CLICKPAY', '127.0.0.1');
define('PORT_SERVER_MANDIRI_CLICKPAY', '22334');
define('USER_MANDIRI_CLICKPAY', 'user');
define('PASSWORD_MANDIRI_CLICKPAY', 'pwd');
define('SHOW_PAYMENT_MANDIRI_CLICKPAY',TRUE);

/* URL & KEY VERITRANS PAYMENT */
define('URL_VERITRANS_PAYMENT', 'https://api.sandbox.veritrans.co.id/');
define('CLIENT_KEY_VERITRANS', '56af463b-c22e-4bab-ad93-669bb3af79c7');
define('SERVER_KEY_VERITRANS', 'a8048818-10fa-42b6-acd5-cb2baf22989b');
define('SHOW_PAYMENT_KREDIT_CARD', TRUE);
define('SHOW_PAYMENT_MANDIRI_KREDIT_CARD', TRUE);
define('SHOW_PAYMENT_PERMATA_BANK_TRANSFER', TRUE);

/* ACCOUNT & BCA PAYMENT */
define('BCA_KLIK_PAY_CODE', '30CIPIKA06');
define('BCA_CLEAR_KEY', 'ClearKeyDev2Cip1');
define('SHOW_PAYMENT_BCA_KLIK_PAY', TRUE);
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';
$fo = str_replace("index.php","", $_SERVER['SCRIPT_NAME']);
$baseUrl   = "$http" . $_SERVER['SERVER_NAME'] . "" . $fo;
define('URL_CALLBACK_BCA_KLIK_PAY', $baseUrl.'cart/confirm_order?invoice=');

/* USERID & PASSWORD JATIS SMS GET WAY */
define('USERID_JATIS', ' JATIS ');
define('PASSWORD_JATIS', ' JATISabcd');
define('SENDER_JATIS', 'SENDERJATIS');
define('CHANNEL_JATIS', 2);
define('UPLOADBY_JATIS', 'rangga');
define('DIVISION_JATIS', 'default 20');
define('URL_JATIS', 'https://sms-api.jatismobile.com/index.ashx');

/* USERID & PASSWORD IMX SMS GET WAY */
define('USERID_IMX', 'Cipika1882');
define('PASSWORD_IMX', 'CipIKA789123Pass');
define('ORIGINAL_IMX', 'CIPIKA');
define('URL_IMX', 'https://175.103.48.29:28050/HttpImxCipika/receive.php');

define('USERID_IMX_ISAT', 'cipika');
define('PASSWORD_IMX_ISAT', 'u1Iqjh194nqI');
define('SID_IMX_ISAT', '16800001750001');
define('URL_IMX_ISAT', 'http://api.iklanstore.co.id:9900/');

/* BANK MANDIRI TRANSFER */
define('SHOW_PAYMENT_BANK_MANDIRI_TRANSFER', true);
define('NAME_OF_BANK_MANDIRI_TRANSFER', 'Bank Mandiri Cabang Jakarta Thamrin');
define('NO_REK_OF_BANK_MANDIRI_TRANSFER', '103.000.6272401');
define('ACCOUNT_OF_BANK_MANDIRI_TRANSFER', 'PT Indosat Tbk');

/* BANK BCA TRANSFER */
define('SHOW_PAYMENT_BANK_BCA_TRANSFER', true);
define('NAME_OF_BANK_BCA_TRANSFER', 'Bank BCA Cabang Wisma Asia Jakarta');
define('NO_REK_OF_BANK_BCA_TRANSFER', '084.535.3331');
define('ACCOUNT_OF_BANK_BCA_TRANSFER', 'PT Indosat Tbk');

define('URL_JNE_TRACING', 'http://jne.co.id/index.php?mib=tracking.detail&awb=');

/* BANK BCA KARTU KREDIT */
define('SHOW_PAYMENT_BANK_BCA_KARTU_KREDIT', true);
define('BCA_KARTU_KREDIT_SITE_ID', 'Cipika');
define('BCA_KARTU_KREDIT_SITE_ID_CICILAN', serialize(array(
    '3' => 'Cipika3',
    '6' => 'Cipika6',
    )
));
define('BCA_KARTU_KREDIT_URL', 'https://training.doappx.com/sprintAsia/api/webAuthorization.cfm');

/* IPAYMU*/
define('SHOW_PAYMENT_IPAYMU', true);
define('IPAYMU_API_KEY', '');
define('IPAYMU_CALLBACK_RETURN', $baseUrl.'api/ipaymu/callback_payment');
define('IPAYMU_CALLBACK_NOTIFY', $baseUrl.'api/ipaymu/callback_payment_notify');
define('IPAYMU_CALLBACK_CANCEL', $baseUrl.'api/ipaymu/callback_payment_cancel');

/* VOUCHER RELOAD*/
define('USER_ID_DOMPETKU_RELOAD','cipika');
define('SECRET_KEY_DOMPETKU_RELOAD','Th1s_0nLy_F0uR_t3sT1nG__');
define('INITIATOR_DOMPETKU_RELOAD','cipika');
define('INITIATOR_PIN_DOMPETKU_RELOAD','123456');

/* API Mobile V3 */
define('MOBILE_SECRET_KEY','cipikamobile123');

/* VOUCHER FOR PAYMENT */
define('VOUCHER_PAYMENT_LIST', serialize(
    array(
        '1' => 'Bank Transfer Permata',
        '5' => 'DompetKu',
        '6' => 'Mandiri ClickPay',
        '7' => 'Kartu Kredit',
        '9' => 'Bank Transfer Mandiri',
        '10' => 'Bank Transfer BCA',
    ))
);

/* VOUCHER USED FOR USER */
define('VOUCHER_USED_FOR_USER_LIST', serialize(
    array(
        'all'       => 'Semua',
        'web'       => 'Web',
        'android'   => 'Android',
        'ios'       => 'iOS',
    ))
);

/* LIST PAYMENT MOBILE*/
define('MOBILE_PAYMENT_LIST', serialize(
    array(
        '1', // Bank Transfer Permata
        '5', // DompetKu
        '6', // Mandiri ClickPay
        '7', // Kartu Kredit - Veritrans
        '9', // Bank Transfer Mandiri
        '10', // Bank Transfer BCA
        '11', // Voucher Compliment
        '12', // BCA Kartu Kredit
        '16', // Point Redeem
        '17', // Mandiri Installment - Veritrans
        '19', // Bank Transfer Permata - Veritrans
    ))
);

/* Credential Payment Dompetku Plus */
define('USER_ID_DOMPETKU_PLUS','cipika');
define('SECRET_KEY_DOMPETKU_PLUS','Th1s_0nLy_F0uR_t3sT1nG__');
define('SHOW_PAYMENT_DOMPETKU_PLUS', true);

/* INDOMARET */
define('PAYMENT_EXPIRATION_IN', 72); // 24 hours
define('PAYMENT_EXPIRATION_INDOMARET_TICKET', 3); // 24 hours

/* RPX-JOB ready  */
define('JOB_READY', 0); 
define('RPX_READY', 0); 

/* Cash On Delivery (COD) */
define('SHOW_PAYMENT_COD', true);

/* Voucher Reload - MobilePulsa */
define('MOBILE_PULSA_USERNAME', 'cipika');
define('MOBILE_PULSA_PASSWORD', '501629f5b0fc');
define('MOBILE_PULSA_URL', 'http://testapi.mobilepulsa.com/receiver/');
define('MOBILE_PULSA_INQUIRY_TAGIHAN', 'topup');
define('MOBILE_PULSA_CHECK_STATUS', 'checkstatus');

define('KREDIVO_URL_ENDPOINT', 'https://sandbox.kredivo.com/kredivo/');
define('KREDIVO_SERVER_KEY', 'j5Mpan5Xt5j6HQMR3k8hG2jLjzzNcu');
define('KREDIVO_CHIPPER_KEY', '9RvxSTQZGCG5gtN4E9cHb6fAqMFTFKXP');

/* Credential Nicepay */
define("CONF_NICEPAY_IMID", "IONPAYTEST");
define("CONF_NICEPAY_MERCHANT_KEY", "33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==");
define("CONF_NICEPAY_ENDPOINT", "https://www.nicepay.co.id/");

/* End of file constants.php */
/* Location: ./application/config/constants.php */
