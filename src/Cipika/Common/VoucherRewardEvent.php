<?php

namespace Cipika\Common;

class VoucherRewardEvent {

    protected $dbLib;
    protected $eventName = null;

    public function __construct($db) {
        $this->dbLib = $db;
    }

    public function setEvent($eventName) {
        $this->eventName = $eventName;
    }

    public function getEvent() {
        $this->dbLib->where('event', $this->eventName);
        $getEvent = $this->dbLib->get('tbl_email_blast_event');
        if (!empty($getEvent->row_object())) {
            return $getEvent->row_object();
        }
        return false;
    }

}
