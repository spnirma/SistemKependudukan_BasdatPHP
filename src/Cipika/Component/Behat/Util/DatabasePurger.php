<?php

namespace Cipika\Component\Behat\Util;

class DatabasePurger
{
    private $db;

    public function __construct(\Doctrine\DBAL\Driver\Connection $db)
    {
        $this->db = $db;
    }

    public function purge()
    {
        $tables = [
            'banner',
            'contact_form',
            'feedback',
            'groups',
            'keys',
            'mailer',
            'mailer_blast',
            'tbl_agregator',
            'tbl_area_merchant',
            'tbl_area_produk',
            'tbl_article',
            'tbl_banner',
            'tbl_comment',
            'tbl_doorprize',
            'tbl_doorprize_hadiah',
            'tbl_doorprize_pemenang',
            'tbl_email_blast_batch',
            'tbl_follow',
            'tbl_group',
            'tbl_inbox',
            'tbl_hadiah_promo_giveaway',
            'tbl_indoloka_po',
            'tbl_invoices',
            'tbl_invoice_reminder',
            'tbl_kabupaten',
            'tbl_kategori',
            'tbl_kecamatan',
            'tbl_konfirm_pembayaran',
            'tbl_level',
            'tbl_love',
            'tbl_order',
            'tbl_page',
            'tbl_payment',
            'tbl_point_reward',
            'tbl_product_stats',
            'tbl_produk',
            'tbl_produk_kategori',
            'tbl_produkfoto',
            'tbl_program_promo',
            'tbl_propinsi',
            'tbl_rating',
            'tbl_sequence',
            'tbl_settlement',
            'tbl_status',
            'tbl_store',
            'tbl_user',
            'tbl_voucher',
        ];

        $this->db->executeUpdate("SET foreign_key_checks = 0;");

        $sql = "DELETE FROM %s";
        foreach ($tables as $table) {
            $q = sprintf($sql, $this->db->quoteIdentifier($table));
            $this->db->executeUpdate($q);
        }

        $this->db->executeUpdate("SET foreign_key_checks = 1;");
    }
}
