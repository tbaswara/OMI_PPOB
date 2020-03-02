<?php


class TelcoMessageHelper extends FinancialMessageHelper
{
    protected $billerId;
    protected $payeeId;
    protected $productId;
    protected $countryCode;
    protected $operatorCode;
    protected $phoneNumber;
    protected $voucherNominal;
    protected $serialNumber;
    protected $windowPeriod;
    protected $adminNominal;
    protected $regionCode;
    protected $datelCode;
    protected $customerName;
    protected $cheque;
    protected $otherCustomerId;
    protected $totalBill;
    protected $billStatus;
    protected $dueDate;
    protected $adminFee;
    protected $billData = array();

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

    public function setCountryCode($countryCode) 
    {
        $this->countryCode = $countryCode;
    }

    public function setOperatorCode($operatorCode) 
    {
        for($i=strlen($operatorCode) + 1; $i<=4; $i++)
        {
            $operatorCode = '0' . $operatorCode;
        }
        
        $this->operatorCode = $operatorCode;
    }

    public function setPhoneNumber($phoneNumber) 
    {
        for($i=strlen($phoneNumber) + 1; $i<=10; $i++)
        {
            $phoneNumber .= ' ';
        }
        
        $this->phoneNumber = $phoneNumber;
    }
    
    public function setVoucherNominal($voucherNominal)
    {
        for($i=strlen($voucherNominal) + 1; $i<=12; $i++)
        {
            $voucherNominal = '0' . $voucherNominal;
        }
        
        $this->voucherNominal = $voucherNominal;
    }
    
    public function setSerialNumber($serialNumber) 
    {
        $this->serialNumber = $serialNumber;
    }
    
    public function setWindowPeriod($windowPeriod) 
    {
        $this->windowPeriod = $windowPeriod;
    }
    
    public function setAdminNominal($adminNominal)
    {
        for($i=strlen($adminNominal) + 1; $i<=10; $i++)
        {
            $adminNominal = '0' . $adminNominal;
        }
        
        $this->adminNominal = $adminNominal;
    }
    
    public function setRegionCode($regionCode) 
    {
        $this->regionCode = $regionCode;
    }

    public function setDatelCode($datelCode) 
    {
        $this->datelCode = $datelCode;
    }

    public function setCustomerName($customerName) 
    {
        
        for($i=strlen($customerName) + 1; $i<=30; $i++)
        {
            $customerName .= ' ';
        }
        
        $this->customerName = $customerName;
    }
    
    public function setCheque($cheque) 
    {
        $this->cheque = $cheque;
    }
    
    public function setOtherCustomerId($otherCustomerId) 
    {
        for($i=strlen($otherCustomerId) + 1; $i<=16; $i++)
        {
            $otherCustomerId .= ' ';
        }
        
        $this->otherCustomerId = $otherCustomerId;
    }

    public function setTotalBill($totalBill) 
    {
        $this->totalBill = $totalBill;
    }

    public function setBillStatus($billStatus) 
    {
        $this->billStatus = $billStatus;
    }

    public function setDueDate($dueDate) 
    {
        $this->dueDate = $dueDate;
    }

    public function setAdminFee($adminFee) 
    {
        
        for($i=strlen($adminFee) + 1; $i<=10; $i++)
        {
            $adminFee = '0' . $adminFee;
        }
        
        $this->adminFee = $adminFee;
    }
    
    public function setBillData($billData) 
    {
        $this->billData = $billData;
    }
    
    public function getInquiryMessage()
    {
        $inquiryString = $this->billerId
                . $this->payeeId
                . $this->productId
                . $this->countryCode
                . $this->operatorCode
                . $this->phoneNumber;
        
        return $inquiryString;
    }
    
    public function getPurchaseMessage()
    {
        $purchaseString = $this->billerId
                . $this->payeeId
                . $this->productId
                . $this->countryCode
                . $this->operatorCode
                . $this->phoneNumber
                . $this->voucherNominal
                . $this->adminNominal;
        
        return $purchaseString;
    }
    
    public function getPostingPaymentMessage()
    {
        $postingPaymentString = $this->billerId
                . $this->payeeId
                . $this->productId
                . $this->countryCode
                . $this->operatorCode
                . $this->phoneNumber
                . $this->regionCode
                . $this->datelCode
                . $this->customerName
                . $this->otherCustomerId
                . $this->cheque
                . $this->totalBill;
        
        foreach ($this->billData as $data)
        {
            $postingPaymentString .= $this->formatBillData($data);
        }
        
        $postingPaymentString .= $this->adminFee;
        
        return $postingPaymentString;
    }
    
    public function getFinancialPostingPaymentMessage()
    {
        $terminalId = $this->getTerminalId();
        $postingMessage = $this->getPostingPaymentMessage();
        
        $transactionAmount = 0;
        foreach($this->billData as $data)
        {
            $transactionAmount += $data['billAmount'];
        }
        
        $DETransactionAmount = $transactionAmount;
        for($i=strlen($DETransactionAmount) + 1; $i<=12; $i++)
        {
            $DETransactionAmount = '0' . $DETransactionAmount;
        }
        
        $this->iso->addMTI(FinancialMessageHelper::MTI_REQUEST_CODE);
        $this->iso->addData(self::DE_PRIMARY_ACCOUNT_NUMBER, '00');
        $this->iso->addData(self::DE_PROCESSING_CODE, '820000');
        $this->iso->addData(self::DE_AMOUNT_TRANSACTION, $DETransactionAmount);
        $this->iso->addData(self::DE_AMOUNT_SETTLEMENT, $DETransactionAmount);
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
        $this->iso->addData(self::DE_ADDITIONAL_DATA, $postingMessage);
        $this->iso->addData(self::DE_CURRENCY_CODE_TRANSACTION, '360');
        
        return $this->iso->getISO();
    }
    
    public function getFinancialInquiryMessage()
    {
        $terminalId = $this->getTerminalId();
        $inquiryMessage = $this->getInquiryMessage();
        
        $this->iso->addMTI(FinancialMessageHelper::MTI_REQUEST_CODE);
        $this->iso->addData(self::DE_PRIMARY_ACCOUNT_NUMBER, '00');
        $this->iso->addData(self::DE_PROCESSING_CODE, '320000');
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
    
    public function getFinancialPurchaseMessage()
    {
        $terminalId = $this->getTerminalId();
        $inquiryMessage = $this->getPurchaseMessage();
        
        $this->iso->addMTI(FinancialMessageHelper::MTI_REQUEST_CODE);
        $this->iso->addData(self::DE_PRIMARY_ACCOUNT_NUMBER, '0000000000000000');
        $this->iso->addData(self::DE_PROCESSING_CODE, '920000');
        $this->iso->addData(self::DE_AMOUNT_TRANSACTION, $this->voucherNominal);
        $this->iso->addData(self::DE_AMOUNT_SETTLEMENT, $this->voucherNominal);
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
    
    public function parseResponseMessage($isoString, $messageType)
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
                
                if($messageType === self::TYPE_INQUIRY_RESPONSE)
                {
                    $telcoMessage = $this->parseDE48InquiryResponse($de48value);
                }
                else if($messageType === self::TYPE_PAYMENT_RESPONSE)
                {
                    $telcoMessage = $this->parseDE48PostingResponse($de48value);
                }
                else if($messageType === self::TYPE_PURCHASE_RESPONSE)
                {
                    $telcoMessage = $this->parseDE48PurchaseResponse($de48value);
                }
                
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
    
    public function parseDE48InquiryResponse($de48String)
    {   
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId(substr($de48String, 0, 5));
        $telcoMessage->setPayeeId(substr($de48String, 5, 4));
        $telcoMessage->setProductId(substr($de48String, 9, 4));
        $telcoMessage->setCountryCode(substr($de48String, 13, 2));
        $telcoMessage->setOperatorCode(substr($de48String, 15, 4));
        $telcoMessage->setPhoneNumber(substr($de48String, 19, 10));
        $telcoMessage->setRegionCode(substr($de48String, 29, 2));
        $telcoMessage->setDatelCode(substr($de48String, 31, 4));
        $telcoMessage->setCustomerName(substr($de48String, 35, 30));
        $telcoMessage->setOtherCustomerId(substr($de48String, 65, 16));
        $telcoMessage->setTotalBill(substr($de48String, 81, 1));
        $telcoMessage->setBillStatus(substr($de48String, 82, 1));
        $telcoMessage->setDueDate(substr($de48String, 83, 8));
        
        $billData = array();
        $startBillIndex = 91;
        $totalBill = (int) substr($de48String, 81, 1);
        for($i=0; $i<$totalBill; $i++)
        {
            $data = array(
                'billRef' => substr($de48String, $startBillIndex, 11),
                'billAmount' => intval(substr($de48String, $startBillIndex + 11, 12))
            );
            
            
            $billData[$i] = $data;
            $startBillIndex += 23;
        }
        
        $telcoMessage->setBillData($billData);
        
        $adminFee = intval(substr($de48String, $startBillIndex, 10));
        $telcoMessage->setAdminFee($adminFee);
        
        return $telcoMessage->toArray();
    }
    
    public function parseDE48PostingResponse($de48String)
    {   
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId(substr($de48String, 0, 5));
        $telcoMessage->setPayeeId(substr($de48String, 5, 4));
        $telcoMessage->setProductId(substr($de48String, 9, 4));
        $telcoMessage->setCountryCode(substr($de48String, 13, 2));
        $telcoMessage->setOperatorCode(substr($de48String, 15, 4));
        $telcoMessage->setPhoneNumber(substr($de48String, 19, 10));
        $telcoMessage->setRegionCode(substr($de48String, 29, 2));
        $telcoMessage->setDatelCode(substr($de48String, 31, 4));
        $telcoMessage->setCustomerName(substr($de48String, 35, 30));
        $telcoMessage->setOtherCustomerId(substr($de48String, 65, 16));
        $telcoMessage->setCheque(substr($de48String, 81, 20));
        $telcoMessage->setTotalBill(substr($de48String, 101, 1));
        
        $billData = array();
        $startBillIndex = 102;
        $totalBill = intval(substr($de48String, 101, 1));
        for($i=0; $i<$totalBill; $i++)
        {
            $data = array(
                'billRef' => substr($de48String, $startBillIndex, 11),
                'billAmount' => intval(substr($de48String, $startBillIndex + 11, 12))
            );
            
            
            $billData[$i] = $data;
            $startBillIndex += 23;
        }
        
        $telcoMessage->setBillData($billData);
        
        $adminFee = intval(substr($de48String, $startBillIndex, 10));
        $telcoMessage->setAdminFee($adminFee);
        
        return $telcoMessage->toArray();
    }
    
    public function parseDE48PurchaseResponse($de48String)
    {
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId(substr($de48String, 0, 5));
        $telcoMessage->setPayeeId(substr($de48String, 5, 4));
        $telcoMessage->setProductId(substr($de48String, 9, 4));
        $telcoMessage->setCountryCode(substr($de48String, 13, 2));
        $telcoMessage->setOperatorCode(substr($de48String, 15, 4));
        $telcoMessage->setPhoneNumber(substr($de48String, 19, 10));
        $telcoMessage->setVoucherNominal(substr($de48String, 29, 12));
        $telcoMessage->setWindowPeriod(substr($de48String, 41, 8));
        $telcoMessage->setSerialNumber(substr($de48String, 49, 16));
        $telcoMessage->setAdminFee(substr($de48String, 65, 10));
        
        return $telcoMessage->toPurchaseArray();
    }
    
    public function formatBillData($billData)
    {
        $billRef = $billData['billRef'];
        $billAmount = $billData['billAmount'];
        
        for($i=strlen($billRef) + 1; $i<=11; $i++)
        {
            $billRef = '0' . $billRef;
        }
        
        for($i=strlen($billAmount) + 1; $i<=12; $i++)
        {
            $billAmount = '0' . $billAmount;
        }
        
        return $billRef . $billAmount;
    }
    
    public function toArray()
    {
        $productName = Product::where('product_code', $this->billerId)
                ->first()
                ->subProducts()
                ->where('product_code', $this->productId)
                ->first()
                ->product_name;
                
        $data = array(
            "billerId" => trim($this->billerId),
            "payeeId" => trim($this->payeeId),
            "productId" => trim($this->productId),
            "countryCode" => trim($this->countryCode),
            "operatorCode" => trim($this->operatorCode),
            "phoneNumber" => trim($this->phoneNumber),
            "regionCode" => trim($this->regionCode),
            "datelCode" => trim($this->datelCode),
            "customerName" => trim($this->customerName),
            "otherCustomerId" => trim($this->otherCustomerId),
            "totalBill" => intval($this->totalBill),
            "billStatus" => trim($this->billStatus),
            "dueDate" => trim($this->dueDate),
            "billData" => $this->billData,
            "adminFee" => intval($this->adminFee),
            "productName" => $productName
        );
        
        return $data;
    }
    
    public function toPurchaseArray()
    {
        $productName = Product::where('product_code', $this->billerId)
                ->first()
                ->subProducts()
                ->where('product_code', $this->productId)
                ->first()
                ->product_name;
                
        $data = array(
            "billerId" => trim($this->billerId),
            "payeeId" => trim($this->payeeId),
            "productId" => trim($this->productId),
            "countryCode" => trim($this->countryCode),
            "operatorCode" => trim($this->operatorCode),
            "phoneNumber" => trim($this->phoneNumber),
            "voucherNominal" => intval($this->voucherNominal),
            "windowPeriod" => trim($this->windowPeriod),
            "serialNumber" => trim($this->serialNumber),
            "adminFee" => intval($this->adminFee),
            "productName" => $productName
        );
        
        return $data;
    }
}
