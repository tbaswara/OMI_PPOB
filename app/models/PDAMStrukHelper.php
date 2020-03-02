<?php

class PDAMStrukHelper
{
    protected $tanggalBayar;
    protected $namaPelanggan;
    protected $idPelanggan;
    protected $bulanTagihan;
    protected $nominalTagian;
    protected $biayaAdmin;
    
    public function setTanggalBayar($tanggalBayar) 
    {
        $this->tanggalBayar = $tanggalBayar;
    }

    public function setNamaPelanggan($namaPelanggan)
    {
        $this->namaPelanggan = $namaPelanggan;
    }

    public function setIdPelanggan($idPelanggan) 
    {
        $this->idPelanggan = $idPelanggan;
    }

    public function setBulanTagihan($bulanTagihan)
    {
        $this->bulanTagihan = $bulanTagihan;
    }

    public function setNominalTagian($nominalTagian)
    {
        $this->nominalTagian = $nominalTagian;
    }

    public function setBiayaAdmin($biayaAdmin)
    {
        $this->biayaAdmin = $biayaAdmin;
    }

    public function generate()
    {   
        if (!is_dir(STRUK_DIR))
        {
            mkdir(STRUK_DIR, 0755, true);
        }
        
        $fileNumber = $this->dataTagihan[0]['billRef'];
        $filename = Auth::user()->pp_id . '_pdam' . $fileNumber . '.html';
        $filepath = STRUK_DIR . '/' . $filename;
        
        $totalTagihan = $this->nominalTagian + $this->biayaAdmin;
        $strukData = array(
            'tanggalBayar' => $this->tanggalBayar,
            'namaPelanggan' => $this->namaPelanggan,
            'idPelanggan' => $this->idPelanggan,
            'bulanTagihan' => $this->bulanTagihan,
            'nominalTagihan' => $this->nominalTagian,
            'biayaAdmin' => $this->biayaAdmin,
            'totalTagihan' => $totalTagihan,
        );
        
        $view = View::make('struk/pdam', $strukData);
        File::put($filepath, $view);
        
        return $filename;
    }
}
