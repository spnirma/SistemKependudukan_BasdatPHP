<?php 
namespace Cipika\Promo;

class VoucherRules
{
	private $session;
    private $voucher;
    private $params = null;

    public function setVoucher($voucher)
    {
        $this->voucher = $voucher;
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setParams($params)
    {
        $this->params = (object) $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function validation()
    {
        if ($this->voucher->used_for_user !== null) {
            $countMatchUsedForUser = 0;
            $countMatchUsedForUser = array_intersect(
                $this->params->used_for_user,
                unserialize($this->voucher->used_for_user)
            );
            if (count($countMatchUsedForUser) == 0) {
                return array(
                    'status'    => 0,
                    'error'     => 'Maaf, Voucher hanya dapat dipergunakan pada Platform Tertentu'
                );
            }
        }

        if ($this->voucher->used_for_product !== null) {
            $listUsedForProductParams = $this->params->used_for_product;
            $listUsedForProductVoucher = unserialize($this->voucher->used_for_product);

            $countErrorUsedForProduct = 0;
            foreach ($listUsedForProductParams as $v) {
                if (!in_array($v, $listUsedForProductVoucher)) {
                    $countErrorUsedForProduct++;
                }
            }

            if ($countErrorUsedForProduct > 0) {
                return array(
                    'status'    => 0,
                    'error'     => 'Maaf, Voucher hanya dapat dipergunakan pada Produk Tertentu'
                );
            }
        }
 
        if ($this->voucher->used_for_merchant !== null) {
            $is_contain_sets_merchant = in_array($this->voucher->used_for_merchant, $this->params->used_for_merchant);
            $is_contain_unset_merchant = array_diff($this->params->used_for_merchant, array($this->voucher->used_for_merchant));
            if (!$is_contain_sets_merchant || !empty($is_contain_unset_merchant)) {
                return array(
                    'status'    => 0,
                    'error'     => 'Maaf, Voucher hanya dapat dipergunakan pada Merchant Tertentu'
                );
            }
        }

        if ($this->voucher->used_for_category !== null) {
            $listUsedForCategoryParams = $this->params->used_for_category;
            $listUsedForCategoryVoucher = unserialize($this->voucher->used_for_category);

            $countErrorUsedForCategory = 0;
            foreach ($listUsedForCategoryParams as $v) {
                if (!in_array($v, $listUsedForCategoryVoucher)) {
                    $countErrorUsedForCategory++;
                }
            }

            if ($countErrorUsedForCategory > 0) {
                return array(
                    'status'    => 0,
                    'error'     => 'Maaf, Voucher hanya dapat dipergunakan pada Kategori Tertentu'
                );
            }
        }

        if ($this->voucher->used_for_channel !== null &&
            $this->voucher->used_for_channel !== ""
        ) {
            if (property_exists($this->params, 'used_for_channel')) {
                $listUsedForChannelParams = $this->params->used_for_channel;
            } else {
                $listUsedForChannelParams = array();
            }
            $listUsedForChannelVoucher = unserialize($this->voucher->used_for_channel);

            $countErrorUsedForChannel = 0;
            foreach ($listUsedForChannelParams as $v) {
                if (!in_array(strtolower($v), $listUsedForChannelVoucher)) {
                    $countErrorUsedForChannel++;
                }
            }

            if ($countErrorUsedForChannel > 0) {
                return array(
                    'status'    => 0,
                    'error'     =>
                        'Voucher ini hanya tersedia untuk produk ' .
                        ucwords(implode(',', $listUsedForChannelVoucher)),
                );
            }
        }

        return array(
            'status'    => 1,
            'error'     => 'Berhasil Check Voucher'
        );
    }
}
