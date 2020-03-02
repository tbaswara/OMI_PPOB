<?php

define('STRUK_DIR', public_path('struk'));

class TelcoStrukHelper
{
    protected $tanggalBayar;
    protected $namaPelanggan;
    protected $nomorTelepon;
    protected $adminFee;
    protected $dataTagihan = array();
    
    public function setTanggalBayar($tanggalBayar) 
    {
        $this->tanggalBayar = $tanggalBayar;
    }

    public function setNamaPelanggan($namaPelanggan) 
    {
        $this->namaPelanggan = $namaPelanggan;
    }

    public function setNomorTelepon($nomorTelepon) 
    {
        $this->nomorTelepon = $nomorTelepon;
    }
    
    public function setAdminFee($adminFee)
    {
        $this->adminFee = $adminFee;
    }
    
    public function setDataTagihan($dataTagihan) 
    {
        $this->dataTagihan = $dataTagihan;
    }
    
    public function generate($isTestStruk)
    {
        $totalTagihan = $this->adminFee;
        $index = 0;
        $currentDate = date('Y-m-d');
        foreach($this->dataTagihan as $tagihan)
        {
            $month = date('F', strtotime($currentDate));
            $this->dataTagihan[$index]['billMonth'] = $month;
            $totalTagihan += $tagihan['billAmount'];
            
            $currentDate = strtotime(date('Y-m-d', strtotime($currentDate)) . " -1 month");
        }
        
        if (!is_dir(STRUK_DIR))
        {
            mkdir(STRUK_DIR, 0755, true);
        }

        $fileNumber = $this->dataTagihan[0]['billRef'];
        $filename = Auth::user()->pp_id . '_telco' . $fileNumber . '.html';
        $filepath = STRUK_DIR . '/' . $filename;
        
        $strukData = array(
            'tanggalBayar' => $this->tanggalBayar,
            'namaPelanggan' => $this->namaPelanggan,
            'nomorTelepon' => $this->nomorTelepon,
            'dataTagihan' => $this->dataTagihan,
            'adminFee' => $this->adminFee,
            'totalTagihan' => $totalTagihan
        );
        
        $view = View::make('struk/telco', $strukData);
        if($isTestStruk)
        {
            $view = View::make('struk/telcoTestPrint', $strukData);
        }
        File::put($filepath, $view);
        
        return $filename;
    }
}
