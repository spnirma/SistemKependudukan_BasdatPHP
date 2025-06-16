<?php

namespace Cipika\View\Helper;

class ListBank
{

    private $dataListBank;

    private function setData()
    {
        $this->dataListBank = array(
        array( 'bank_value' => 'BCA', 'bank_name' => 'BCA' ),
        array( 'bank_value' => 'BNI 46', 'bank_name' => 'BNI 46' ),
        array( 'bank_value' => 'CIMB Niaga', 'bank_name' => 'CIMB Niaga' ),
        array( 'bank_value' => 'DANAMON', 'bank_name' => 'DANAMON' ),
        array( 'bank_value' => 'Permata Bank', 'bank_name' => 'Permata Bank' ),
        array( 'bank_value' => 'Bank Mandiri', 'bank_name' => 'Bank Mandiri' ),
        array( 'bank_value' => 'Bank Syariah Mandiri', 'bank_name' => 'Bank Syariah Mandiri' ),
        array( 'bank_value' => 'BII Maybank', 'bank_name' => 'BII Maybank' ),
        array( 'bank_value' => 'Bank Panin', 'bank_name' => 'Bank Panin' ),
        array( 'bank_value' => 'BTN', 'bank_name' => 'BTN' ),
        array( 'bank_value' => 'Citibank', 'bank_name' => 'Citibank' ),
        array( 'bank_value' => 'Bank Muamalat', 'bank_name' => 'Bank Muamalat' ),
        array( 'bank_value' => 'Bank Mega', 'bank_name' => 'Bank Mega' ),
        array( 'bank_value' => 'Bank Bukopin', 'bank_name' => 'Bank Bukopin' ),
        array( 'bank_value' => 'HSBC', 'bank_name' => 'HSBC' ),
        array( 'bank_value' => 'ANZ-Panin Bank', 'bank_name' => 'ANZ-Panin Bank' ),
        array( 'bank_value' => 'Standard Chartered Bank', 'bank_name' => 'Standard Chartered Bank' ),
        array( 'bank_value' => 'UOB Buana', 'bank_name' => 'UOB Buana' ),
        array( 'bank_value' => 'DBS', 'bank_name' => 'DBS' ),
        array( 'bank_value' => 'Bank Sinarmas', 'bank_name' => 'Bank Sinarmas' ),
        array( 'bank_value' => 'Bank Jatim', 'bank_name' => 'Bank Jatim' ),
        array( 'bank_value' => 'Bank DKI', 'bank_name' => 'Bank DKI' ),
        array( 'bank_value' => 'Bank Commonwealth', 'bank_name' => 'Bank Commonwealth' ),
        array( 'bank_value' => 'Rabobank', 'bank_name' => 'Rabobank' ),
        array( 'bank_value' => 'Bank Antar Daerah', 'bank_name' => 'Bank Antar Daerah' ),
        array( 'bank_value' => 'Bank Artha Graha', 'bank_name' => 'Bank Artha Graha' ),
        array( 'bank_value' => 'Bank BCA Syariah', 'bank_name' => 'Bank BCA Syariah' ),
        array( 'bank_value' => 'The Bank of Tokyo-Mitsubishi UFJ',
         'bank_name' => 'The Bank of Tokyo-Mitsubishi UFJ' ),
        array( 'bank_value' => 'Bank Bumi Arta', 'bank_name' => 'Bank Bumi Arta' ),
        array( 'bank_value' => 'Bank Chinatrust Indonesia', 'bank_name' => 'Bank Chinatrust Indonesia' ),
        array( 'bank_value' => 'Bank Capital', 'bank_name' => 'Bank Capital' ),
        array( 'bank_value' => 'Mutiara Bank', 'bank_name' => 'Mutiara Bank' ),
        array( 'bank_value' => 'Bank Mayapada Internasional', 'bank_name' => 'Bank Mayapada Internasional' ),
        array( 'bank_value' => 'BPD DIY', 'bank_name' => 'BPD DIY' ),
        array( 'bank_value' => 'Bank Jambi', 'bank_name' => 'Bank Jambi' ),
        array( 'bank_value' => 'Bank BPD Aceh', 'bank_name' => 'Bank BPD Aceh' ),
        array( 'bank_value' => 'Bank Sumut', 'bank_name' => 'Bank Sumut' ),
        array( 'bank_value' => 'Bank Nagari', 'bank_name' => 'Bank Nagari' ),
        array( 'bank_value' => 'Bank Sumsel Babel', 'bank_name' => 'Bank Sumsel Babel' ),
        array( 'bank_value' => 'Bank Lampung', 'bank_name' => 'Bank Lampung' ),
        array( 'bank_value' => 'Bank BPD Kalsel', 'bank_name' => 'Bank BPD Kalsel' ),
        array( 'bank_value' => 'Bank Kalbar', 'bank_name' => 'Bank Kalbar' ),
        array( 'bank_value' => 'Bank BPD Kaltim', 'bank_name' => 'Bank BPD Kaltim' ),
        array( 'bank_value' => 'BPD Kalteng', 'bank_name' => 'BPD Kalteng' ),
        array( 'bank_value' => 'Bank Sulsel', 'bank_name' => 'Bank Sulsel' ),
        array( 'bank_value' => 'Bank Sulut', 'bank_name' => 'Bank Sulut' ),
        array( 'bank_value' => 'Bank NTB', 'bank_name' => 'Bank NTB' ),
        array( 'bank_value' => 'BPD Bali', 'bank_name' => 'BPD Bali' ),
        array( 'bank_value' => 'Bank NTT', 'bank_name' => 'Bank NTT' ),
        array( 'bank_value' => 'Bank Maluku', 'bank_name' => 'Bank Maluku' ),
        array( 'bank_value' => 'Bank Papua', 'bank_name' => 'Bank Papua' ),
        array( 'bank_value' => 'Bank Bengkulu', 'bank_name' => 'Bank Bengkulu' ),
        array( 'bank_value' => 'Bank Sulteng', 'bank_name' => 'Bank Sulteng' ),
        array( 'bank_value' => 'Bank Sultra', 'bank_name' => 'Bank Sultra' ),
        array( 'bank_value' => 'Bank BNP', 'bank_name' => 'Bank BNP' ),
        array( 'bank_value' => 'Bank Swadesi', 'bank_name' => 'Bank Swadesi' ),
        array( 'bank_value' => 'Bank Mestika', 'bank_name' => 'Bank Mestika' ),
        array( 'bank_value' => 'Bank Ganesha', 'bank_name' => 'Bank Ganesha' ),
        array( 'bank_value' => 'Bank Kesawan', 'bank_name' => 'Bank Kesawan' ),
        array( 'bank_value' => 'Bank Saudara', 'bank_name' => 'Bank Saudara' ),
        array( 'bank_value' => 'Bank Jabar Banten Syariah', 'bank_name' => 'Bank Jabar Banten Syariah' ),
        array( 'bank_value' => 'Bank ICB Bumiputera', 'bank_name' => 'Bank ICB Bumiputera' ),
        array( 'bank_value' => 'Bank Rakyat Indonesia (Persero)', 'bank_name' => 'Bank Rakyat Indonesia (Persero)'),
        array( 'bank_value' => 'Bank Rakyat Indonesia AGRONIAGA', 'bank_name' => 'Bank Rakyat Indonesia AGRONIAGA' ),
        array( 'bank_value' => 'Bank Ina Perdana', 'bank_name' => 'Bank Ina Perdana' ),
        array( 'bank_value' => 'Bank Kesejahteraan', 'bank_name' => 'Bank Kesejahteraan' ),
        array( 'bank_value' => 'Bank Artos Indonesia', 'bank_name' => 'Bank Artos Indonesia' ),
        array( 'bank_value' => 'Bank Mayora', 'bank_name' => 'Bank Mayora' ),
        array( 'bank_value' => 'Bank Index', 'bank_name' => 'Bank Index' ),
        array( 'bank_value' => 'Bank Kepulauan Riau', 'bank_name' => 'Bank Kepulauan Riau' ),
        array( 'bank_value' => 'Bank Nobu', 'bank_name' => 'Bank Nobu' ),
        array( 'bank_value' => 'Bank Ekonomi', 'bank_name' => 'Bank Ekonomi' ),
        array( 'bank_value' => 'Bank Hana', 'bank_name' => 'Bank Hana' ),
        array( 'bank_value' => 'Bank Jasa Jakarta', 'bank_name' => 'Bank Jasa Jakarta' ),
        array( 'bank_value' => 'Bank Maspion', 'bank_name' => 'Bank Maspion' ),
        array( 'bank_value' => 'Bank Royal', 'bank_name' => 'Bank Royal' ),
        array( 'bank_value' => 'Bank Victoria', 'bank_name' => 'Bank Victoria' ),
        array( 'bank_value' => 'Bank Windu', 'bank_name' => 'Bank Windu' ),
        array( 'bank_value' => 'Bank Pundi', 'bank_name' => 'Bank Pundi' ),
        array( 'bank_value' => 'Bank BJB', 'bank_name' => 'Bank BJB' ),
        array( 'bank_value' => 'BRI Syariah', 'bank_name' => 'BRI Syariah' ),
        array( 'bank_value' => 'Bank Syariah Mega Indonesia', 'bank_name' => 'Bank Syariah Mega Indonesia' ),
        array( 'bank_value' => 'BTPN', 'bank_name' => 'BTPN' ),
        array( 'bank_value' => 'Bank Jateng', 'bank_name' => 'Bank Jateng' ),
        array( 'bank_value' => 'SBI', 'bank_name' => 'SBI' )
            );
    }

    public function getDataList()
    {
        $this->setData();
        return $this->dataListBank;
    }
}
