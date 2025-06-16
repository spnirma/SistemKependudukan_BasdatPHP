<?php

namespace Cipika\Application\Model\Ui2;

class Home extends \Cipika\Application\Model\AbstractDatabaseModel
{
    public function get_top_gadget($limit = 8)
    {

        // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/query-builder.html
        $qb = $this->db->createQueryBuilder();

        $qb->select('a.*', 'b.image', 'c.image as merchant_image', 'c.username');
        $qb->addSelect('s.nama_store', 's.store_status', 'd.count_comment', 'l.nama_kabupaten');
        $qb->from('tbl_produk', 'a');
        $qb->join('a', 'tbl_produkfoto', 'b', 'a.id_produk = b.id_produk');
        $qb->join('a', 'tbl_user', 'c', 'a.id_user = c.id_user');
        $qb->join('c', 'tbl_store', 's', 'c.id_user = s.id_user');
        $qb->leftJoin('s', 'tbl_kecamatan', 'k', 'k.id_kecamatan = s.id_kecamatan');
        $qb->leftJoin('s', 'tbl_kabupaten', 'l', 'l.id_kabupaten = s.id_kabupaten');
        $qb->leftJoin('a', 'view_comment', 'd', 'a.id_produk = d.id_produk');
        $qb->andWhere('a.publish = 1');
        $qb->andWhere('a.deleted = 0');
        $qb->andWhere('s.store_status = \'approve\'');
        $qb->andWhere('a.id_parent IS NULL');
        $qb->andWhere('a.channel = \'GADGET\'');
        $qb->andWhere('a.show_on_listing = 1');
        $qb->groupBy('a.id_produk');
        $qb->addOrderBy('a.list_index', 'desc');
        $qb->addOrderBy('a.date_added', 'desc');
        $qb->addOrderBy('a.id_produk', 'desc');
        $qb->setMaxResults($limit);

        $stmt = $qb->execute();

        var_dump($stmt->fetchAll());
        // hasilnya array
    }
}
