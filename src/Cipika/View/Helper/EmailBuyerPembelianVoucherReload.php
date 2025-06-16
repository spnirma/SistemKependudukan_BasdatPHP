<?php

namespace Cipika\View\Helper;

class EmailBuyerPembelianVoucherReload
{
    protected $dbLibrary;
    protected $from;
    protected $bcc = array();

    public function __construct($dbLibrary, $from, $bcc = array())
    {
        $this->dbLibrary = $dbLibrary;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function sendNotifFailedAirtime($detUser, $detInvoice, $detOrder, $detItemVoucherReload, $detPayment)
    {
        $formatDate = new \DateTime($detInvoice->date_added);
        $email = '';
        $email .= '<h3>Failed transaction Cipika Airtime</h3>';
        $email .= "
            <table width='500px'>
                <tr>
                    <td width='20px'><strong>Date</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($formatDate->format('d-m-Y H:i:s'))."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>No Order</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detOrder->kode_order)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>No Invoice</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detInvoice->kode_invoice)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Payment Method</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detPayment->nama_payment)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>MSISDN</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->nomer_hp)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Amount</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->nominal)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Transid Airtime</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->trans_id)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Result Aittime</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->respond_message).'</td>
                </tr>
            </table>';
        $email .= '<p><strong>Cipika Store &trade;</strong><br><a href='.base_url().'>cipika.co.id</a></p>';

        $list = $this->bcc;
        $list = implode(',', $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Failed Information Send Voucher Reload',
            'mailer_from' => $this->from,
            'mailer_to' => $detUser->email,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Failed Transaction Cipika Airtime '.$detOrder->kode_order,
            'mailer_message' => $email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s'),
        );
        $this->dbLibrary->insert('mailer', $insert);

        return $this->dbLibrary->insert_id();
    }

    public function sendOrderTokenVoucherListrik($detItemVoucherReload, $tokenPln, $emailMember)
    {
        $formatDate = new \DateTime($detItemVoucherReload->date_added);
        $email = '';
        $email .= '<h3>Order Voucher Listrik Cipika</h3>';
        $email .= "
            <table width='500px'>
                <tr>
                    <td width='20px'><strong>Date</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($formatDate->format('d-m-Y H:i:s'))."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>No Order</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->kode_order)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Nomor Meteran</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->nomer_hp)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Amount</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'>".htmlentities($detItemVoucherReload->nominal)."</td>
                </tr>
                <tr>
                    <td width='20px'><strong>Token Listrik</strong></td>
                    <td width='1px'>:</td>
                    <td width='150px'><strong>".htmlentities($tokenPln).'</strong></td>
                </tr>
            </table>';
        $email .= '<p><strong>Cipika Store &trade;</strong><br><a href='.base_url().'>cipika.co.id</a></p>';

        $list = $this->bcc;
        $list = implode(',', $list);

        $insert = array('idmailer' => null,
            'mailer_module' => 'Send Voucher Listrik',
            'mailer_from' => $this->from,
            'mailer_to' => $emailMember,
            'mailer_bcc' => $list,
            'mailer_subject' => 'Token Voucher PLN '.$detItemVoucherReload->kode_order,
            'mailer_message' => $email,
            'mailer_status' => 'new',
            'mailer_created' => date('Y-m-d H:i:s'),
        );
        $this->dbLibrary->insert('mailer', $insert);

        return $this->dbLibrary->insert_id();
    }
}
