<?php 
namespace Cipika\Common;

class PointReward
{
    protected $dbLibrary;
    protected $idPoint;
    protected $idUser;
    protected $keteranganPoint;

    public function __construct($db, $id_user)
    {
        $this->dbLibrary = $db;
        $this->idUser = $id_user;
    }

    private function _insertPoint($params)
    {
        $debet = trim($params['debet']);
        if (!isset($debet) || empty($debet)) {
            $params['debet'] = 0;
        }
        if (!is_numeric($debet)) {
            return false;
        }

        $kredit = trim($params['kredit']);
        if (!isset($kredit) || empty($kredit)) {
            $params['kredit'] = 0;
        }
        if (!is_numeric($kredit)) {
            return false;
        }

        $insertParam = array(
            'id'         => null,
            'id_user'    => $this->idUser,
            'debet'      => (int) $params['debet'],
            'kredit'     => (int) $params['kredit'],
            'keterangan' => $this->keteranganPoint,
            'tanggal'    => date('Y-m-d H:i:s'),
        );
        $queryInsertPoint = $this->dbLibrary->insert('tbl_point_reward', $insertParam);
        return $this->dbLibrary->insert_id();
    }

    /*
    * @param Kodeinvoice, Kelipatan Transaksi
    * @return boolean
    */
    public function savePointFreeInvoice($kodeInvoice, $pointKelipatanTransaksi)
    {
        $this->keteranganPoint = "Free Point Transaction Paid";

        $totalTransaksiUser = 0;
        $totalProduk = 0;
        $totalOngkir = 0;
    
        /*Get Order Detail Invoice*/
        $orderDetail = $this->dbLibrary->get_where('tbl_order', array('kode_invoice' => $kodeInvoice));
        foreach ($orderDetail->result_object() as $k => $v) {
            $totalProduk += $v->total;
            $totalOngkir += $v->ongkir_sementara;
        }
        $totalTransaksiUser = $totalProduk + $totalOngkir;
        $invoicePoint = (int) floor($totalTransaksiUser / $pointKelipatanTransaksi);

        $param = array(
            'kredit' => $invoicePoint,
            'debet' => 0 ,
        );
        return $this->_insertPoint($param) ? true : false;
    }
   
    /*
    * @param totalPoint Integer
    * @return boolean
    */
    public function savePointCheckoutInvoice($totalPoint)
    {
        $this->keteranganPoint = "Debet Point Checkout Transaction";

        $param = array(
            'kredit' => 0,
            'debet' => $totalPoint,
        );
        return $this->_insertPoint($param) ? true : false;
    }
 
}
