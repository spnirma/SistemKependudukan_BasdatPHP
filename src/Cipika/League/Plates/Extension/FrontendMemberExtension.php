<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class FrontendMemberExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getLoggedInClient', [$this, 'getLoggedInClient']);
        $engine->registerFunction('getLoggedInEvent', [$this, 'getLoggedInEvent']);
        $engine->registerFunction('getLoggedInUser', [$this, 'getLoggedInUser']);
        $engine->registerFunction('isUserLoggedIn', [$this, 'isUserLoggedIn']);
        $engine->registerFunction('isPartnerLoggedIn', [$this, 'isPartnerLoggedIn']);
        $engine->registerFunction('isOutlet', [$this, 'isOutlet']);
        $engine->registerFunction('getLoggedInUserPersibGaleri', [$this, 'getLoggedInUserPersibGaleri']);
        $engine->registerFunction('getLoggedInMoboOutlet', [$this, 'getLoggedInMoboOutlet']);
        $engine->registerFunction('getLoggedInMoboOutletAreaProfile', [$this, 'getLoggedInMoboOutletAreaProfile']);
        
    }

    public function getLoggedInClient()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('client')) {
            return $session->get('client');
        }
    }
	
    public function getLoggedInEvent()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('lu_event')) {
            return $session->get('lu_event');
        }
    }

    public function getLoggedInUser()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('member')) {
            return $session->get('member');
        } elseif ($session->get('partner')) {
            return $session->get('partner');
        }
    }

    public function isUserLoggedIn()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        return !empty($session->get('member'));
    }
    
    public function isPartnerLoggedIn()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        return !empty($session->get('partner'));
    }

    public function isOutlet($id_user)
    {
        $CI =& get_instance();
        return $CI->user_m->isOutlet($id_user);
    }

    public function getLoggedInUserPersibGaleri()
    {
        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('member')) {
            return $session->get('member');
        }
    }

    public function getLoggedInMoboOutlet()
    {

        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('mobo_outlet')) {
            return $session->get('mobo_outlet');
        }
    
    }    

    public function getLoggedInMoboOutletAreaProfile()
    {

        $session = \Cipika\Application::getInstance()->getContainer()->get('session');

        if ($session->get('mobo_outlet_area_profile')) {
            return $session->get('mobo_outlet_area_profile');
        }
    
    }      
   
        
    
}
