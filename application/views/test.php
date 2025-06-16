<?php
use Cipika\Entity\Settlement\SettlementStatus;

$this->load->library('Excel');

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()
            ->setCellValue('A4', 'No')
            ->setCellValue('B4', 'Tgl Transaksi')
            ->setCellValue('E4', 'Invoice Number')
            ->setCellValue('F4', 'Order Number')
            ->setCellValue('G4', 'Kota Destination')
            ->setCellValue('H4', 'Area')
            ->setCellValue('J4', 'Kategori')
            ->setCellValue('K4', 'Nama Merchant')
            ->setCellValue('L4', 'Nama Produk')
            ->setCellValue('M4', 'Qty')
            ->setCellValue('N4', 'Berat (Kg)')
            ->setCellValue('O4', 'Total Berat (Kg)')
            ->setCellValue('P4', 'Data Shipping by System')
            ->setCellValue('R4', 'Diskon')
            ->setCellValue('S4', 'Harga Produk Pada Web Cipika')
            ->setCellValue('T4', 'Harga Produk Dari Merchant')
            ->setCellValue('U4', 'Transaction Fee (blended di harga produk web)')
            ->setCellValue('V4', 'Insentif 10% Cipika (blended di harga produk web)')
            ->setCellValue('W4', 'Blended Shipping (blended di harga produk web)')
            ->setCellValue('X4', 'Selisih Pembulatan')
            ->setCellValue('Y4', 'Promo Free Shipping')
            ->setCellValue('Z4', 'Promo Diskon')
            ->setCellValue('AA4', 'Total Reveneu Cipika')
            ->setCellValue('AB4', 'Promo Voucher')
            ->setCellValue('AC4', 'No Resi Pengiriman')
            ->setCellValue('AD4', 'Biaya Kirim di Web')
            ->setCellValue('AE4', 'Biaya Kirim by Merchants (kalo gak diisi merchant, menyesuaikan real shipping dari JNE)')
            ->setCellValue('AF4', 'Payment Method')
            ->setCellValue('AG4', 'Total Pembayaran Customer')
            ->setCellValue('AH4', 'Biaya Administrasi Bank untuk Payment')
            ->setCellValue('AI4', 'Biaya Administrasi untuk merchant beda bank (kalo selain BCA ada biaya Rp5000)')
            ->setCellValue('AJ4', 'Jumlah yang dibayarkan kepada Merchant')
            ->setCellValue('AK4', 'No Rekening Merchant')
            ->setCellValue('AL4', 'Profit Cipika per Transaksi')
            ->setCellValue('AM4', 'Status')
            ->setCellValue('B5', 'Tgl')
            ->setCellValue('C5', 'Bln')
            ->setCellValue('D5', 'Thn')
            ->setCellValue('H5', 'Kota Origin (from Merchant)')
            ->setCellValue('I5', 'Sales')
            ->setCellValue('P5', 'Name')
            ->setCellValue('Q5', 'Address');

$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A4:A5')
            ->mergeCells('B4:D4')
            ->mergeCells('E4:E5')
            ->mergeCells('F4:F5')
            ->mergeCells('G4:G5')
            ->mergeCells('H4:I4')
            ->mergeCells('J4:J5')
            ->mergeCells('K4:K5')
            ->mergeCells('L4:L5')
            ->mergeCells('M4:M5')
            ->mergeCells('N4:N5')
            ->mergeCells('O4:O5')
            ->mergeCells('P4:Q4')
            ->mergeCells('R4:R5')
            ->mergeCells('S4:S5')
            ->mergeCells('T4:T5')
            ->mergeCells('U4:U5')
            ->mergeCells('V4:V5')
            ->mergeCells('W4:W5')
            ->mergeCells('X4:X5')
            ->mergeCells('Y4:Y5')
            ->mergeCells('Z4:Z5')
            ->mergeCells('AA4:AA5')
            ->mergeCells('AB4:AB5')
            ->mergeCells('AC4:AC5')
            ->mergeCells('AD4:AD5')
            ->mergeCells('AE4:AE5')
            ->mergeCells('AF4:AF5')
            ->mergeCells('AG4:AG5')
            ->mergeCells('AH4:AH5')
            ->mergeCells('AI4:AI5')
            ->mergeCells('AJ4:AJ5')
            ->mergeCells('AK4:AK5')
            ->mergeCells('AL4:AL5')
            ->mergeCells('AM4:AM5');

$styleArray = array(
      'borders' => array(
            'inside'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'outline'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
      ),
      'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'font'  => array(
            'bold'  => true
      )
);

$objPHPExcel->getActiveSheet()
            ->getStyle('A4:AM5')
            ->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()
            ->getStyle('A4:AM5')
            ->getAlignment()
            ->setWrapText(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(7);
            

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);


$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);

$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(70);

$row = 5;
$no = 0;

foreach ($data as $key => $value) {
      $row++;
      $no++;
      $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(70);

      /*
      * RUMUS
      *
      */
      $qty = $value->qty;
      $berat = $value->berat;
      $harga_produk = $value->harga_merchant;
      $ongkir_blended_web = $value->blended_shipping_fee_to_jakarta;
      $selisih_pembulatan = $value->selisih_pembulatan;
      $ongkir_web = $value->ongkir_web;
      $ongkir_merchant = $value->ongkir_merchant;

      $M = $qty;
      $N = $berat;
      $O = $N * $M;
      $T = $harga_produk * $M;
      $U = 5000 * $M;
      $V = 10/100 * $T;
      $W = $ongkir_blended_web;
      $X = $selisih_pembulatan;
      $AB = $value->voucher;
      $AD = $ongkir_web;

      $AE = $ongkir_merchant;
      $AH = $biaya_administrasi_bank_payment;

      // $AI = $T;
      /*
      * ? AJ, AG, AL
      */

      //harga produk di publik
      $S = $T + $U + $V + $W + $X;

      //total revenue
      $AA[$key] = $V + ($U - $AH ) + ($W + $AD - $AE);

      if($row > 6 && $data[$key-1]->invoice == $data[$key]->invoice){
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('E'. ($row-1) .':E'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('B'. ($row-1) .':B'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('C'. ($row-1) .':C'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('D'. ($row-1) .':D'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AF'. ($row-1) .':AF'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AL'. ($row-1) .':AL'. $row);
      }

      if($row > 6 && $data[$key-1]->kode_order == $data[$key]->kode_order){            

            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('F'. ($row-1) .':F'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('G'. ($row-1) .':G'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('H'. ($row-1) .':H'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('I'. ($row-1) .':I'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('P'. ($row-1) .':P'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('Q'. ($row-1) .':Q'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AB'. ($row-1) .':AB'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AC'. ($row-1) .':AC'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AD'. ($row-1) .':AD'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AE'. ($row-1) .':AE'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AG'. ($row-1) .':AG'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AI'. ($row-1) .':AI'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AJ'. ($row-1) .':AJ'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AK'. ($row-1) .':AK'. $row);
            $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('AM'. ($row-1) .':AM'. $row);
      }

      $objPHPExcel->getActiveSheet()->setCellValue('A'. $row, $no);
      $objPHPExcel->getActiveSheet()->setCellValue('B'. $row, $value->tgl);
      $objPHPExcel->getActiveSheet()->setCellValue('C'. $row, $value->bln);
      $objPHPExcel->getActiveSheet()->setCellValue('D'. $row, $value->thn);
      $objPHPExcel->getActiveSheet()->setCellValue('E'. $row, $value->invoice);
      $objPHPExcel->getActiveSheet()->setCellValue('F'. $row, $value->kode_order);
      $objPHPExcel->getActiveSheet()->setCellValue('G'. $row, $value->destinasi);
      $objPHPExcel->getActiveSheet()->setCellValue('H'. $row, $value->origin);
      $objPHPExcel->getActiveSheet()->setCellValue('I'. $row, $value->sales);
      $objPHPExcel->getActiveSheet()->setCellValue('J'. $row, $value->kategori);
      $objPHPExcel->getActiveSheet()->setCellValue('K'. $row, $value->merchant);
      $objPHPExcel->getActiveSheet()->setCellValue('L'. $row, $value->produk);
      $objPHPExcel->getActiveSheet()->setCellValue('M'. $row, $M);
      $objPHPExcel->getActiveSheet()->setCellValue('N'. $row, $N);
      $objPHPExcel->getActiveSheet()->setCellValue('O'. $row, $O);
      $objPHPExcel->getActiveSheet()->setCellValue('P'. $row, $value->nama_pengiriman);
      $objPHPExcel->getActiveSheet()->setCellValue('Q'. $row, $value->alamat_pengiriman);
      $objPHPExcel->getActiveSheet()->setCellValue('R'. $row, $value->diskon);
      $objPHPExcel->getActiveSheet()->setCellValue('S'. $row, '=SUM(T'.$row.':X'.$row.')');
      $objPHPExcel->getActiveSheet()->setCellValue('T'. $row, $T);
      $objPHPExcel->getActiveSheet()->setCellValue('U'. $row, $U);
      $objPHPExcel->getActiveSheet()->setCellValue('V'. $row, $V);
      $objPHPExcel->getActiveSheet()->setCellValue('W'. $row, $W);
      $objPHPExcel->getActiveSheet()->setCellValue('X'. $row, $X);
      $objPHPExcel->getActiveSheet()->setCellValue('Y'. $row, $value->free_shipping);
      $objPHPExcel->getActiveSheet()->setCellValue('Z'. $row, $value->diskon_promo);
      $objPHPExcel->getActiveSheet()->setCellValue('AA'. $row, '=V'.$row.'+(U'.$row.'-AH'.$row.')+(W'.$row.'+AD'.$row.'-AE'.$row.')');
      $objPHPExcel->getActiveSheet()->setCellValue('AB'. $row, $AB);
      $objPHPExcel->getActiveSheet()->setCellValue('AC'. $row, $value->no_resi_pengiriman);
      $objPHPExcel->getActiveSheet()->setCellValue('AD'. $row, $AD);
      $objPHPExcel->getActiveSheet()->setCellValue('AE'. $row, $AE);
      $objPHPExcel->getActiveSheet()->setCellValue('AF'. $row, $value->payment);
      // $objPHPExcel->getActiveSheet()->setCellValue('AG'. $row, '='. $AA[$key] .'+AD'. $row .'-AB'. $row);
      $objPHPExcel->getActiveSheet()->setCellValue('AH'. $row, $AH);
      $objPHPExcel->getActiveSheet()->setCellValue('AI'. $row, '0');
      // $objPHPExcel->getActiveSheet()->setCellValue('AJ'. $row, '0');
      $objPHPExcel->getActiveSheet()->setCellValue('AK'. $row, $value->bank . ' a.n ' . $value->pemilik_rek . ' ' . $value->norek);
      $objPHPExcel->getActiveSheet()->setCellValue('AL'. $row, '0');
      $objPHPExcel->getActiveSheet()->setCellValue('AM'. $row, SettlementStatus::getStatus($value->status_settlement));

}

$styleArray2 = array(
      'borders' => array(
            'inside'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            ),
            'outline'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
            )
      ),
      'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
);

$objPHPExcel->getActiveSheet()
            ->getStyle('A6:AM'. $row)
            ->applyFromArray($styleArray2);

$objPHPExcel->getActiveSheet()
            ->getStyle('A6:AM'. $row)
            ->getAlignment()
            ->setWrapText(true);

$row = 5;
$no = 0;

$orders = array();

foreach ($data as $key => $value) {
      $row++;
      $no++;
      $orders[$value->kode_order][] = $row;
}
//var_dump($orders);

foreach ($orders as $orderRows) {
      $row = $orderRows[0];
      $aa = array();
      $tm = array();
      foreach ($orderRows as $r) {
            $aa[] = 'AA' . $r;
            $tm[] = '(T' . $r . '*M' . $r . ')';
      }

      $aa = implode('+', $aa);
      $tm = implode('+', $tm);

      $objPHPExcel->getActiveSheet()
                  ->setCellValue(
                        'AG'. $row, 
                        '=' . $aa .'+AD'. $row .'-AB'. $row);

      $objPHPExcel->getActiveSheet()
                  ->setCellValue(
                        'AJ'. $row, 
                        '=AE' . $row .'+'. $tm .'-AI'. $row);
}

$row = 5;
$no = 0;
foreach ($data as $key => $value) {
      $row++;
      $no++;
      $invoices[$value->invoice][] = $row;
}

foreach ($invoices as $invoiceRows) {
      $row = $invoiceRows[0];
      $ag = array();
      $aj = array();
      foreach ($invoiceRows as $r) {
            $ag[] = 'AG' . $r;
            $aj[] = 'AJ' . $r;            
      }

      $ag = implode('+', $ag);
      $aj = implode('+', $aj);
      // $ah = implode('', $ag);

      $objPHPExcel->getActiveSheet()
                  ->setCellValue(
                        'AL'. $row, 
                        '=' . $ag .'-('. $aj .')-'. 'AH'. $row);

      // =AG7+AG9-(AJ7+AJ9)-AH7
      // KURANG AH
}
 
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Sending headers to force the user to download the file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Settlement'.date('dMy').'.xls"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');


?>