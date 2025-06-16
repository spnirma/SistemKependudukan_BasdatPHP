<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class MatrixExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getMatrixPlanNameByIdProduk', [$this, 'getMatrixPlanNameByIdProduk']);
        $engine->registerFunction('getKatgoriMatrixOption', [$this, 'getKatgoriMatrixOption']);
    }
    
    public function getMatrixPlanNameByIdProduk($id)
    {
		$CI =& get_instance();
        $CI->load->model('matrix_m');
        $data['kateogri_produk_matrix'] = $CI->produk_m->getAllKategoriProductByProductId($id);
        $matrix_plan = $CI->matrix_m->getMatrixPlanByIdKategori($data['kateogri_produk_matrix']);
        return $matrix_plan;
	}
    
    public function getKatgoriMatrixOption($active_cat = null)
    {
        $CI =& get_instance();
        $CI->load->model('kategori_m');
        $kategori_matrix = $CI->kategori_m->get_select_category_hierarchy(0, 0 , $active_cat, 'matrix', false);
    }
}
