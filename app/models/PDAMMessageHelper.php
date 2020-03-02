<?php

class PDAMMessageHelper extends FinancialMessageHelper
{
    protected $billerId;
    protected $payeeId;
    protected $productId;
    protected $idPelanggan;
    protected $customerName;
    protected $billPeriode;
    protected $billAmount;
    protected $billPenalty;
    protected $kubikasi;
    protected $referenceNumber;
    protected $adminFee;
    
    public function setBillerId($billerId)
    {
        $this->billerId = $billerId;
    }

    public function setPayeeId($payeeId)
    {
        $this->payeeId = $payeeId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function setIdPelanggan($idPelanggan)
    {
        for($i=strlen($idPelanggan) + 1; $i<=15; $i++)
        {
            $idPelanggan .= ' ';
        }
        
        $this->idPelanggan = $idPelanggan;
    }

    public function setCustomerName($customerName)
    {
        for($i=strlen($customerName) + 1; $i<=30; $i++)
        {
            $customerName .= ' ';
        }
        
        $this->customerName = $customerName;
    }

    public function setBillPeriode($billPeriode)
    {
        $this->billPeriode = $billPeriode;
    }

    public function setBillAmount($billAmount)
    {
        for($i=strlen($billAmount) + 1; $i<=12; $i++)
        {
            $billAmount = '0' . $billAmount;
        }
        
        $this->billAmount = $billAmount;
    }

    public function setBillPenalty($billPenalty)
    {
        for($i=strlen($billPenalty) + 1; $i<=8; $i++)
        {
            $billPenalty = '0' . $billPenalty;
        }
        
        $this->billPenalty = $billPenalty;
    }

    public function setKubikasi($kubikasi)
    {
        for($i=strlen($kubikasi) + 1; $i<=17; $i++)
        {
            $kubikasi = '0' . $kubikasi;
        }
        
        $this->kubikasi = $kubikasi;
    }

    public function setReferenceNumber($referenceNumber)
    {
        for($i=strlen($referenceNumber) + 1; $i<=15; $i++)
        {
            $referenceNumber = '0' . $referenceNumber;
        }
        
        $this->referenceNumber = $referenceNumber;
    }

    public function setAdminFee($adminFee)
    {
        for($i=strlen($adminFee) + 1; $i<=12; $i++)
        {
            $adminFee = '0' . $adminFee;
        }
        
        $this->adminFee = $adminFee;
    }
    
    public function getInquiryMessage()
    {
        $inquiryString = $this->billerId
                . $this->payeeId
                . $this->productId
                . $this->idPelanggan;
        
        return $inquiryString;
    }
    
    public function getPaymentMessage()
    {
        $paymentString = $this->billerId
                . $this->payeeId
                . $this->productId
                . $this->idPelanggan
                . $this->customerName
                . $this->billPeriode
                . $this->billAmount
                . $this->billPenalty
                . $this->kubikasi
                . $this->referenceNumber
                . $this->adminFee;
        
        return $paymentString;
    }
    
    public function getFinancialInquiryMessage()
    {
        $terminalId = $this->getTerminalId();
        $inquiryMessage = $this->getInquiryMessage();
        
        $this->iso->addMTI(self::MTI_REQUEST_CODE);
        $this->iso->addData(self::DE_PRIMARY_ACCOUNT_NUMBER, '00');
        $this->iso->addData(self::DE_PROCESSING_CODE, '300000');
        $this->iso->addData(self::DE_AMOUNT_TRANSACTION, '000000000000');
        $this->iso->addData(self::DE_AMOUNT_SETTLEMENT, '000000000000');
        $this->iso->addData(self::DE_TRANSMISSION_DATE_TIME, date('mdHis'));
        $this->iso->addData(self::DE_SYSTEM_TRACE_AUDIT_NUMBER, date('His'));
        $this->iso->addData(self::DE_TIME_LOCAL_TRANSACTION, date('His'));
        $this->iso->addData(self::DE_DATE_LOCAL_TRANSACTION, date('md'));
        $this->iso->addData(self::DE_DATE_SETTLEMENT, date('md', strtotime(date('Y-m-d' . " +1 days"))));
        $this->iso->addData(self::DE_MERCHANT_TYPE, '6012');
        $this->iso->addData(self::DE_ACQ_INSTITUTION_IDENTIFICATION_CODE, '810');
        $this->iso->addData(self::DE_RETRIEVAL_REFERENCE_NUMBER, date('ymdHis'));
        $this->iso->addData(self::DE_CARD_ACCEPTOR_TERMINAL_IDENTIFICATION, $terminalId);
        
        $cardAcceptorName = $this->getCardAcceptorName();
        $this->iso->addData(self::DE_CARD_ACCEPTOR_NAME, $cardAcceptorName);
        $this->iso->addData(self::DE_ADDITIONAL_DATA, $inquiryMessage);
        $this->iso->addData(self::DE_CURRENCY_CODE_TRANSACTION, '360');
        
        return $this->iso->getISO();
        
    }
    
    public function getFinancialPostingPaymentMessage()
    {
        $terminalId = $this->getTerminalId();
        $paymentMessage = $this->getPaymentMessage();
        
        $this->iso->addMTI(self::MTI_REQUEST_CODE);
        $this->iso->addData(self::DE_PRIMARY_ACCOUNT_NUMBER, '00');
        $this->iso->addData(self::DE_PROCESSING_CODE, '820000');
        $this->iso->addData(self::DE_AMOUNT_TRANSACTION, $this->billAmount);
        $this->iso->addData(self::DE_AMOUNT_SETTLEMENT, $this->billAmount);
        $this->iso->addData(self::DE_TRANSMISSION_DATE_TIME, date('mdHis'));
        $this->iso->addData(self::DE_SYSTEM_TRACE_AUDIT_NUMBER, date('His'));
        $this->iso->addData(self::DE_TIME_LOCAL_TRANSACTION, date('His'));
        $this->iso->addData(self::DE_DATE_LOCAL_TRANSACTION, date('md'));
        $this->iso->addData(self::DE_DATE_SETTLEMENT, date('md', strtotime(date('Y-m-d' . " +1 days"))));
        $this->iso->addData(self::DE_MERCHANT_TYPE, '6012');
        $this->iso->addData(self::DE_ACQ_INSTITUTION_IDENTIFICATION_CODE, '810');
        $this->iso->addData(self::DE_RETRIEVAL_REFERENCE_NUMBER, date('ymdHis'));
        $this->iso->addData(self::DE_CARD_ACCEPTOR_TERMINAL_IDENTIFICATION, $terminalId);
        
        $cardAcceptorName = $this->getCardAcceptorName();
        $this->iso->addData(self::DE_CARD_ACCEPTOR_NAME, $cardAcceptorName);
        $this->iso->addData(self::DE_ADDITIONAL_DATA, $paymentMessage);
        $this->iso->addData(self::DE_CURRENCY_CODE_TRANSACTION, '360');
        
        return $this->iso->getISO();
    }
    
    public function parseResponseMessage($isoString)
    {
        $result = array();
        $this->iso->addISO($isoString);
        $mti = $this->iso->getMTI();
        $isoData = $this->iso->getData();
        
        if($mti === self::MTI_RESPONSE_CODE)
        {
            $de39value = $isoData[self::DE_RESPONSE_CODE];
            
            if($de39value === self::RESPONSE_CODE_SUCCESS)
            {
                $de48value = $isoData[self::DE_ADDITIONAL_DATA];
                $telcoMessage = $this->parseDE48Response($de48value);
                
                $result['status'] = 'success';
                $result['message'] = $telcoMessage;
            }
            else
            {
                $result['status'] = 'failed';
                $result['message'] = 'Error ('.$de39value.'): Silahkan hubungi administrator sistem';
            }
        }
        
        return $result;
    }
    
    public function parseDE48Response($de48String)
    {
        $pdamMessage = new PDAMMessageHelper();
        $pdamMessage->setBillerId(substr($de48String, 0, 5));
        $pdamMessage->setPayeeId(substr($de48String, 5, 4));
        $pdamMessage->setProductId(substr($de48String, 9, 4));
        $pdamMessage->setIdPelanggan(substr($de48String, 13, 15));
        $pdamMessage->setCustomerName(substr($de48String, 28, 30));
        $pdamMessage->setBillPeriode(substr($de48String, 58, 6));
        $pdamMessage->setBillAmount(substr($de48String, 64, 12));
        $pdamMessage->setBillPenalty(substr($de48String, 76, 8));
        $pdamMessage->setKubikasi(substr($de48String, 84, 17));
        $pdamMessage->setReferenceNumber(substr($de48String, 101, 15));
        $pdamMessage->setAdminFee(substr($de48String, 116, 12));
        
        return $pdamMessage->toArray();
    }
    
    public function toArray()
    {
        $productName = Product::where('product_code', $this->billerId)
                ->first()
                ->subProducts()
                ->where('product_code', $this->productId)
                ->first()
                ->product_name;
        
        $billRef = $this->billPeriode;
        $billAmount = intval($this->billAmount);
        $billPenalty = intval($this->billPenalty);
        
        $billData = array();
        $billData[0] = array(
            "billRef" => $billRef,
            "billAmount" => $billAmount,
            "billPenalty" => $billPenalty
        );
        
        $data = array(
            "billerId" => $this->billerId,
            "payeeId" => $this->payeeId,
            "productId" => $this->productId,
            "idPelanggan" => trim($this->idPelanggan),
            "otherCustomerId" => trim($this->idPelanggan),
            "customerName" => trim($this->customerName),
            "billPeriode" => $this->billPeriode,
            "billAmount" => $billAmount,
            "billPenalty" => $billPenalty,
            "kubikasi" => $this->kubikasi,
            "referenceNumber" => intval($this->referenceNumber),
            "adminFee" => intval($this->adminFee),
            "billData" => $billData,
            "productName" => $productName
        );
        
        return $data;
    }
}
