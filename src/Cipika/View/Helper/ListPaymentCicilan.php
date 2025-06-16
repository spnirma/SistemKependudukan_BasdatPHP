<?php

namespace Cipika\View\Helper;

class ListPaymentCicilan
{

    private $dataListPayment;

    private function setData()
    {
        $this->dataListPayment = array(
            array( 'payment_value' => '12', 'payment_name' => 'Kartu Kredit BCA', 'payment_label' => 'BCA' ),
            array( 'payment_value' => '17', 'payment_name' => 'Kartu Kredit Mandiri', 'payment_label' => 'Mandiri' ),
        );
    }

    public function getDataList()
    {
        $this->setData();
        return $this->dataListPayment;
    }

    public function getName($id_value)
    {
        $this->setData();
        $name = '';
        foreach ($this->dataListPayment as $value) {
            if ($id_value == $value['payment_value']) {
                $name = $value['payment_name'];
            }
        }
        return $name;
    }
    
    public function getLabel($id_value)
    {
        $this->setData();
        $name = '';
        foreach ($this->dataListPayment as $value) {
            if ($id_value == $value['payment_value']) {
                $name = $value['payment_label'];
            }
        }
        return $name;
    }

}
