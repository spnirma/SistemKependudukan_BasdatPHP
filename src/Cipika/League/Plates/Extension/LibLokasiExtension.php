<?php
namespace Cipika\League\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class LibLokasiExtension implements ExtensionInterface
{
    
    public function register(Engine $engine)
    {
        $engine->registerFunction('getPropinsi', [$this, 'getPropinsi']);
        $engine->registerFunction('getLokasi', [$this, 'getLokasi']);
        $engine->registerFunction('getLokasiByKabupaten', [$this, 'getLokasiByKabupaten']);
        $engine->registerFunction('getKabupaten', [$this, 'getKabupaten']);
        $engine->registerFunction('getKecamatan', [$this, 'getKecamatan']);
        $engine->registerFunction('getProvinceOption', [$this, 'getProvinceOption']);
        $engine->registerFunction('getCityOption', [$this, 'getCityOption']);
    }

    public function getPropinsi()
    {
        $CI =& get_instance();
        $CI->load->library('lib_lokasi');
        $uri = $CI->lib_lokasi;
        return $uri->get_propinsi();
    }
    
    public function getLokasi($id_kecamatan)
    {
        $CI =& get_instance();
        $CI->load->library('lib_lokasi');
        $uri = $CI->lib_lokasi;
        return $uri->get_lokasi($id_kecamatan);
    }
    
    public function getLokasiByKabupaten($id_kabupaten)
    {
        $CI =& get_instance();
        $CI->load->library('lib_lokasi');
        $uri = $CI->lib_lokasi;
        return $uri->get_lokasi_by_kabupaten($id_kabupaten);
    }
    
    public function getKabupaten($id_propinsi)
    {
        $CI =& get_instance();
        $CI->load->library('lib_lokasi');
        $uri = $CI->lib_lokasi;
        return $uri->get_kabupaten($id_propinsi);
    }
    
    public function getKecamatan($id_kabupaten)
    {
        $CI =& get_instance();
        $CI->load->library('lib_lokasi');
        $uri = $CI->lib_lokasi;
        return $uri->get_kecamatan($id_kabupaten);
    }
    
    public function getProvinceOption($id_propinsi_selected = '')
    {
        $CI =& get_instance();
        $uri = $CI->lokasi_m;
        return $uri->getProvinceOption($id_propinsi_selected);
    }
    
    public function getCityOption($id_propinsi, $id_kabupaten_selected = '')
    {
        $CI =& get_instance();
        $uri = $CI->lokasi_m;
        return $uri->getCityOption($id_propinsi, $id_kabupaten_selected);
    }
}
