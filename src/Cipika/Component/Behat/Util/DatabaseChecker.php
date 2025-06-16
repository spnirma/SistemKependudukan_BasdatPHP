<?php

namespace Cipika\Component\Behat\Util;

class DatabaseChecker
{
    private $db;

    public function __construct(\Doctrine\DBAL\Driver\Connection $db)
    {
        $this->db = $db;
    }

    public function check()
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

        $sql = "SELECT * FROM %s LIMIT 1";
        foreach ($tables as $table) {
            $q = sprintf($sql, $this->db->quoteIdentifier($table));
            $stmt = $this->db->query($q);
            $result = $stmt->fetchAll();

            if (!empty($result)) {
                throw new \Exception(sprintf('Table %s is not empty, the test will only run on empty database.', $table));
            }
        }
    }
}
