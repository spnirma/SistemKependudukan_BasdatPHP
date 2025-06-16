<?php

namespace Cipika\Component\Http;

class CiSessionSegment implements SessionSegmentInterface
{
    private $ciSession;

    public function __construct()
    {
        $Ci =& get_instance();
        $this->ciSession = $Ci->session;
    }

    public function get($key, $alt = null)
    {
        if ($this->ciSession->userdata($key)) {
            return $this->ciSession->userdata($key);
        }

        return $alt;
    }

    public function set($key, $val)
    {
        $this->ciSession->set_userdata($key, $val);
    }

    public function clear()
    {
        $data = $this->ciSession->all_userdata();
        
        foreach ($data as $k => $v) {
            $data[$k] = '';
        }

        $this->ciSession->unset_userdata($data);
    }

    public function getFlash($key, $alt = null)
    {
        $flashData = $this->ciSession->flashdata($key);

        if (!empty($flashData)) {
            return $flashData;
        }
        
        return $alt;
    }

    public function setFlash($key, $val)
    {
        $this->ciSession->set_flashdata($key, $val);
    }
}
