<?php

namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class CategoryExtension implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('getDeepestCategory', [$this, 'getDeepestCategory']);
        $engine->registerFunction('getDeepestCategoryChannel', [$this, 'getDeepestCategoryChannel']);
        $engine->registerFunction('getSelectCategoryHierarchy', [$this, 'getSelectCategoryHierarchy']);
    }

    public function getDeepestCategory($id_produk)
    {
        $CI =& get_instance();
        $myproduct_m = $CI->myproduct_m;
        return $myproduct_m->getDeepestCategory($id_produk);
    }

    public function getDeepestCategoryChannel($id_kategori = '')
    {
        $CI =& get_instance();
        $CI->load->model('kategori_m');
        $category = $CI->kategori_m;
        return $category->get_tree_parent_kategori_channel($id_kategori);
    }
    
    public function getSelectCategoryHierarchy($parentId, $level, $activeCategoryId, $channel, $show_hide)
    {
        $CI =& get_instance();
        $CI->load->model('kategori_m');
        $category = $CI->kategori_m;
        $category->get_select_category_hierarchy($parentId, $level, $activeCategoryId, $channel, $show_hide);
    }
}
