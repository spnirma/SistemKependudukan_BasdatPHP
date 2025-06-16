<?php

namespace Cipika\Common;

class UserMobileLibrary
{
    private $dbLib = null;

    public function __construct($db)
    {
        $this->dbLib = $db;
    }

    public function checkAvailableEmail($email)
    {
        $getUserByEmail = $this->dbLib->where('email', $email)
                                      ->get('tbl_user')
                                      ->num_rows();
        if ($getUserByEmail == 1) {
            return true;
        }
        return false;
    }
    
    public function checkAvailableKey($key)
    {
        return $this->dbLib->where(config_item('rest_key_column'), $key)
                        ->count_all_results(config_item('rest_keys_table')) > 0;
    }

    public function saveUserKey($key, $data)
    {
        $data[config_item('rest_key_column')] = $key;
        $data['date_created'] = function_exists('now') ? now() : time();

        $this->dbLib->set($data)->insert(config_item('rest_keys_table'));

        return $this->dbLib->insert_id();
    }
    
    public function checkUserKey($key)
    {
        $this->dbLib->select('tbl_user.*');
        $this->dbLib->join('keys', 'keys.id = tbl_user.id_key');
        $this->dbLib->where('keys.' . config_item('rest_key_column'), $key);
        
        $user = $this->dbLib->get('tbl_user')->row();
        return $user;
    }

    public function checkUserEmail($email)
    {
        $this->dbLib->select('tbl_user.*');
        $this->dbLib->where('email', $email);
        
        $user = $this->dbLib->get('tbl_user')->row();
        return $user;
    }

    public function getKeyByEmail($email)
    {
        $this->dbLib->select('key');
        $this->dbLib->join('keys', 'keys.id = tbl_user.id_key');
        $this->dbLib->where('email' , $email);
        
        $user = $this->dbLib->get('tbl_user')->row();

        if (is_array($user) && count($user) === 0) {
            return null;
        } elseif (is_object($user)) {
            return $user->key;
        }
        return false;
    }


}
