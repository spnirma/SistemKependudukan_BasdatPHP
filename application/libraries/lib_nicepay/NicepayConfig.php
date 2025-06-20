<?php
/*
 * ____________________________________________________________
 *
 * Copyright (C) 2016 NICE IT&T
 *
 *
 * This config file may used as it is, there is no warranty.
 *
 * @ description : PHP SSL Client module.
 * @ name        : NicepayLite.php
 * @ author      : NICEPAY I&T (tech@nicepay.co.kr)
 * @ date        :
 * @ modify      : 09.03.2016
 *
 * 09.03.2016 Update Log
 *
 * ____________________________________________________________
 */

// Please set the following

define("NICEPAY_IMID", CONF_NICEPAY_IMID);                                                  // Merchant ID
define("NICEPAY_MERCHANT_KEY", CONF_NICEPAY_MERCHANT_KEY); // API Key


define("NICEPAY_CALLBACK_URL", base_url('api/nicepay/confirm/'));  // Merchant's result page URL
define("NICEPAY_DBPROCESS_URL", base_url('api/nicepay/push_uri/')); // Merchant's notification handler URL

/* TIMEOUT - Define as needed (in seconds) */
define( "NICEPAY_TIMEOUT_CONNECT", 15 );
define( "NICEPAY_TIMEOUT_READ", 25 );


// Please do not change

define("NICEPAY_PROGRAM",           "NicepayLite");
define("NICEPAY_VERSION",           "1.11");
define("NICEPAY_BUILDDATE",         "20160309");

define("NICEPAY_REQ_CC_URL",        CONF_NICEPAY_ENDPOINT . "nicepay/api/orderRegist.do");            // Credit Card API URL
define("NICEPAY_REQ_VA_URL",        CONF_NICEPAY_ENDPOINT . "nicepay/api/onePass.do");                // Request Virtual Account API URL
define("NICEPAY_CANCEL_VA_URL",     CONF_NICEPAY_ENDPOINT . "nicepay/api/onePassAllCancel.do");       // Cancel Virtual Account API URL
define("NICEPAY_ORDER_STATUS_URL",  CONF_NICEPAY_ENDPOINT . "nicepay/api/onePassStatus.do");          // Check payment status URL


define("NICEPAY_READ_TIMEOUT_ERR",  "10200");

/* LOG LEVEL */

define("NICEPAY_LOG_CRITICAL", 1);
define("NICEPAY_LOG_ERROR", 2);
define("NICEPAY_LOG_NOTICE", 3);
define("NICEPAY_LOG_INFO", 5);
define("NICEPAY_LOG_DEBUG", 7);