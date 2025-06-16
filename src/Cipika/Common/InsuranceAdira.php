<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cipika\Common;

/**
 * Description of InsuranceAdira
 *
 * @author Kangthofa
 */
class InsuranceAdira {

    private $db;
    private $session;

    public function __construct($db, $adira_id_user, $id_produk) {
        $this->db = $db;
        $this->adira_id_user = $adira_id_user;
        $this->id_produk = $id_produk;
    }

    public function getProductInsurance() {
        $sql = "SELECT * from tbl_produk WHERE id_user = " . $this->adira_id_user . " AND publish = 1";
        $q = $this->db->query($sql);
        $data = $q->result();
        $q->free_result();
        
        return $data;
    }

}
