<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_grid_m extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
    
    public function generateMenuGrid($dataKota)
    {
        $i = 1;
        $jumlahData = count($dataKota);
        $gridTerpakai = 0;
        $x = 1;
        $grid = 1;
        foreach($dataKota as $key => $vKota)
        {
            $x++;
            if($i>=12)
            {
                $i = 1;
            }
            else
            {
                $i++;
            }
            $jumlahKarakter = strlen($vKota['label']);
            $bagi = (int)($jumlahKarakter / 11);
            $modulus = $jumlahKarakter % 11;
            
            if($modulus > 0){
                $grid = $bagi + 1;
            } else {
                $grid = $bagi;
            }
            
            if(($gridTerpakai+$grid) > 12)
            {
                $sisaGrid = 12 - $gridTerpakai;
                $menuGrid[$x-1]['grid'] = $menuGrid[$x-1]['grid'] + $sisaGrid;
            }
            
            if(($gridTerpakai+$grid) > 12){
                $gridTerpakai = 0 + $grid;
            } else {
                $gridTerpakai = $gridTerpakai + $grid;
            }
            
            $menuGrid[$x] = array(
                'label' => $vKota['label'],                        
                'grid' => $grid,                    
                'url' => $vKota['url'],
            );
            
        }
        return $menuGrid;
    }

}
