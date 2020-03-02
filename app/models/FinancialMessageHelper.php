<?php

class FinancialMessageHelper 
{
    protected $iso;
    const TYPE_INQUIRY_RESPONSE = 1;
    const TYPE_PAYMENT_RESPONSE = 2;
    const TYPE_PURCHASE_RESPONSE = 3;
    const MTI_REQUEST_CODE = '0200';
    const MTI_RESPONSE_CODE = '0210';
    
    const DE_PRIMARY_ACCOUNT_NUMBER = 2;
    const DE_PROCESSING_CODE = 3;
    const DE_AMOUNT_TRANSACTION = 4;
    const DE_AMOUNT_SETTLEMENT = 5;
    const DE_TRANSMISSION_DATE_TIME = 7;
    const DE_SYSTEM_TRACE_AUDIT_NUMBER = 11;
    const DE_TIME_LOCAL_TRANSACTION = 12;
    const DE_DATE_LOCAL_TRANSACTION = 13;
    const DE_DATE_SETTLEMENT = 15;
    const DE_MERCHANT_TYPE = 18;
    const DE_ACQ_INSTITUTION_IDENTIFICATION_CODE = 32;
    const DE_RETRIEVAL_REFERENCE_NUMBER = 37;
    const DE_RESPONSE_CODE = 39;
    const DE_CARD_ACCEPTOR_TERMINAL_IDENTIFICATION = 41;
    const DE_CARD_ACCEPTOR_NAME = 43;
    const DE_ADDITIONAL_DATA = 48;
    const DE_CURRENCY_CODE_TRANSACTION = 49;
    
    const RESPONSE_CODE_SUCCESS = '00';
    
    public function __construct() {
        $this->iso = new JAK8583();
    }
    
    public function getCardAcceptorName()
    {
        $ppid = Auth::user()->pp_id;
        $paymentpoint  = PaymentPoint::where('pp_id', $ppid)->first();
        
        $namaPemilik = str_replace(' ', '', $paymentpoint->nama_pemilik);
        $namaKota = $paymentpoint->kota;
        $kodePos = is_null($paymentpoint->kode_pos) ? '00000' : $paymentpoint->kode_pos;
        $kodePropinsi = is_null($paymentpoint->kode_propinsi) ? '000' : $paymentpoint->kode_propinsi;
        $kodeNegara = is_null($paymentpoint->kode_negara) ? '00' : $paymentpoint->kode_negara;
        
        for($i=strlen($namaPemilik) + 1; $i<=22; $i++)
        {
            $namaPemilik = $namaPemilik . '0';
        }
        
        for($i=strlen($namaKota) + 1; $i<=8; $i++)
        {
            $namaKota = $namaKota . '0';
        }
		
        for($i=strlen($kodePos) + 1; $i<=5; $i++)
        {
            $kodePos = '0' . $kodePos;
        }
		
        for($i=strlen($kodePropinsi) + 1; $i<=3; $i++)
        {
            $kodePropinsi = '0' . $kodePropinsi;
        }
		
        for($i=strlen($kodeNegara) + 1; $i<=2; $i++)
        {
            $kodeNegara = '0' . $kodeNegara;
        }
		
        if(strlen($namaPemilik) > 22) 
        {
            $namaPemilik = substr($namaKota, 0, 22);
        }

        if(strlen($namaKota) > 8) 
        {
            $namaKota = substr($namaKota, 0, 8);
        }
        
        $cardAcceptorName = $namaPemilik
                . $namaKota
                . $kodePos
                . $kodePropinsi
                . $kodeNegara;
        
        return $cardAcceptorName;
    }
    
    public function getTerminalId()
    {
        $id = microtime(TRUE) * 10000;
        $hexId = dechex($id);
        
        for($i=strlen($hexId) + 1; $i <= 8; $i++)
        {
            $hexId = '0' . $hexId;
        }
        
        return $hexId;
    }
}
