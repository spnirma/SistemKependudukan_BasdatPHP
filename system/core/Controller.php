<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");

		//visitor counter
		$this->visitorcounter();
		
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

    protected function getSession()
    {   
        return \Cipika\Application::getInstance()->getContainer()->get('session');
    }

    protected function get($serviceId)
    {
        return \Cipika\Application::getInstance()->getContainer()->get($serviceId);
    }

    protected function getAuthenticatedMember()
    {
        return $this->getSession()->get('member');
    }

    protected function getReadDb()
    {
        return \Cipika\Database\ConnectionManager::getReadDb();
    }

	public function visitorcounter()
    {
		$ok = false;
		if (empty($_SERVER['HTTP_REFERER'])) {
			$ok = true;
		// } else if (!empty($_SERVER['HTTP_REFERER'] && strpos(base_url(), $_SERVER['HTTP_REFERER']) === false)) {
		} else if (!empty($_SERVER['HTTP_REFERER'])) {
			$host = explode("/", base_url())[2];
			$reff_host = explode("/", $_SERVER['HTTP_REFERER'])[2];
			// var_dump($host);
			// var_dump($reff_host);
			if ($host != $reff_host) {
				$ok = true;
			} else {
				$ok = false;
			}
		}		

        // if (strpos($vReferrer, 'kemenperin.go.id') == false && strpos($vReferrer, 'tous.') == false) { // if false
		if ($ok && (strpos($_SERVER['REQUEST_URI'], 'welcome') == true || strpos($_SERVER['REQUEST_URI'], 'main') == true || strpos($_SERVER['REQUEST_URI'], 'schedule') == true )) {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			$ip = "";
			if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}	
			$created_at = date("Y-m-d H:i:s");
	
// echo $_SERVER['QUERY_STRING'];die;
// $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
// if ($_SERVER['HTTP_HOST']=='lokalkerenjatim.id' || $_SERVER['HTTP_HOST']=='www.lokalkerenjatim.id') {

			$insert = [
				'ip' => $ip,
				'user_agen' => $userAgent,
				'referer' => !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
				'created_at' => $created_at,
				'url' => $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'/'.$_SERVER['QUERY_STRING'],
			];
			// echo substr($created_at,6,2);die;
	        if (DOMAINNAME=='fesyarjawa.com' || DOMAINNAME=='www.fesyarjawa.com') {
				$this->db->insert("tbl_visitor_log", $insert);
	        }			
		}
    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */
