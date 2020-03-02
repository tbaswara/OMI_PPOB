<?php

class TransaksiController extends BaseController 
{
    protected $paymentPointModel;
    protected $productModel;
    protected $subProductModel;
    protected $outletProductModel;
    protected $newsModel;
    
    public function __construct(
            PaymentPoint $paymentPointModel, Product $productModel,
            SubProduct $subProductModel, OutletProduct $outletProductModel,
            News $newsModel) 
    {
        $this->paymentPointModel = $paymentPointModel;
        $this->productModel = $productModel;
        $this->subProductModel = $subProductModel;
        $this->outletProductModel = $outletProductModel;
        $this->newsModel = $newsModel;
    }
    
    public function index()
    {
        $ppid = Auth::user()->pp_id;
        $timer = Auth::user()->timer;
        $news = $this->newsModel
                ->orderBy('update_date', 'desc')
                ->get();
        
        $paymentPoint = $this->paymentPointModel
                ->where('pp_id', $ppid)
                ->first();
        
        $outletProducts = $this->outletProductModel
                ->where('outlet_id', $ppid)
                ->get();
        
        $products = array();
        foreach ($outletProducts as $outletProduct)
        {
            $product = $outletProduct->product;
            array_push($products, $product);
        }
        
        return View::make('transaksi')
                ->with('timer', $timer)
                ->with('paymentPoint', $paymentPoint)
                ->with('products', $products)
                ->with('news', $news);
    }
    
    public function ajaxDoInquiry()
    {
        $billerId = Input::get('biller_id');
        $productId = Input::get('product_id');
        $pelangganId = Input::get('pelanggan_id');
        
        $result = array();
        if($this->isPDAMIndustry($billerId))
        {
            $result = $this->doPDAMInquiry($billerId, $productId, $pelangganId);
        }
        else if($this->isTelcoIndustry($billerId))
        {
            $result = $this->doTelcoInquiry($billerId, $productId, $pelangganId);
        }

        return Response::json($result);
    }
    
    public function ajaxDoCollectiveInquiry()
    {
        $billerId = Input::get('biller_id');
        $productId = Input::get('product_id');
        $pelangganIds = explode(',', Input::get('pelanggan_id'));
        
        $inquiryResults = array();
        foreach ($pelangganIds as $pelangganId)
        {
            $telcoMessage = new TelcoMessageHelper();
            $telcoMessage->setBillerId($billerId);
            $telcoMessage->setPayeeId('0000');
            $telcoMessage->setCountryCode('62');
            $telcoMessage->setProductId($productId);
            $telcoMessage->setOperatorCode($this->getOperatorCodeFromIdPelanggan($pelangganId));
            $telcoMessage->setPhoneNumber($this->getPhoneNumberFromIdPelanggan($pelangganId));

            $telcoInquiryMessage = $telcoMessage->getFinancialInquiryMessage();
            $responseMessage = SocketHelper::getInstance()->sendMessage($telcoInquiryMessage);

            if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
            {
                $isoMessage = $responseMessage['message'];
                $result = $telcoMessage->parseResponseMessage($isoMessage, TelcoMessageHelper::TYPE_INQUIRY_RESPONSE);

                if($result['status'] === 'success')
                {
                    array_push($inquiryResults, $result);
                }
                else
                {
                    return Response::json($result);
                }
            }
            else
            {
                return Response::json($responseMessage);
            }
        }
        
        $returnVal = array();
        $returnVal['status'] = 'success';
        $returnVal['message'] = $inquiryResults;
        
        return $returnVal;
    }
    
    public function ajaxDoPostingPayment()
    {
        $data = Input::get();
        $billerId = $data['billerId'];
        
        $result = array();
        if($this->isPDAMIndustry($billerId))
        {
            $result = $this->doPDAMPayment($data);
        }
        else if($this->isTelcoIndustry($billerId))
        {
            $result = $this->doTelcoPayment($data);
        }
        
        return Response::json($result);
    }
    
    public function ajaxDoPurchase()
    {
        $billerId = Input::get('biller_id');
        $productId = Input::get('product_id');
        $pelangganId = Input::get('pelanggan_id');
        
        $product = $this->productModel
                ->where('product_code', $billerId)
                ->first();
        
        $subProduct = $product->subProducts()
                ->where('product_code', $productId)
                ->first();
        
        $ppid = Auth::user()->pp_id;
        $outletProduct = $product->outletProducts()
                        ->where('outlet_id', $ppid)
                        ->first();
        
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId($billerId);
        $telcoMessage->setPayeeId('0000');
        $telcoMessage->setProductId($productId);
        $telcoMessage->setCountryCode('62');
        $telcoMessage->setOperatorCode($this->getOperatorCodeFromIdPelanggan($pelangganId));
        $telcoMessage->setPhoneNumber($this->getPhoneNumberFromIdPelanggan($pelangganId));
        $telcoMessage->setVoucherNominal($subProduct->nominal);
        $telcoMessage->setAdminNominal($outletProduct->admin_value);
        
        $telcoPurchaseMessage = $telcoMessage->getFinancialPurchaseMessage();
        $responseMessage = SocketHelper::getInstance()->sendMessage($telcoPurchaseMessage);

        if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
        {
            $isoMessage = $responseMessage['message'];
            $result = $telcoMessage->parseResponseMessage($isoMessage, FinancialMessageHelper::TYPE_PURCHASE_RESPONSE);

            return Response::json($result);
        }
        else
        {
            return Response::json($responseMessage);
        }
    }
    
    public function ajaxDoTestPrint()
    {
        $data = Input::get();
        $filename = $this->generateTelcoStruk($data, true);
        
        $result = array();
        $result['status'] = 'success';
        $result['message'] = $filename;
        
        return Response::json($result);
    }
    
    private function doTelcoInquiry($billerId, $productId, $pelangganId)
    {
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId($billerId);
        $telcoMessage->setPayeeId('0000');
        $telcoMessage->setCountryCode('62');
        $telcoMessage->setProductId($productId);
        $telcoMessage->setOperatorCode($this->getOperatorCodeFromIdPelanggan($pelangganId));
        $telcoMessage->setPhoneNumber($this->getPhoneNumberFromIdPelanggan($pelangganId));
        
        $telcoInquiryMessage = $telcoMessage->getFinancialInquiryMessage();
        $responseMessage = SocketHelper::getInstance()->sendMessage($telcoInquiryMessage);
        if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
        {
            $isoMessage = $responseMessage['message'];
            $result = $telcoMessage->parseResponseMessage($isoMessage, TelcoMessageHelper::TYPE_INQUIRY_RESPONSE);
            
            if($result['status'] === 'success')
            {
                $product = $this->productModel
                        ->where('product_code', $billerId)
                        ->first();

                $ppid = Auth::user()->pp_id;
                $outletProduct = $product->outletProducts()
                        ->where('outlet_id', $ppid)
                        ->first();

                $result['message']['adminFee'] = $outletProduct->admin_value;
            }
            
            return $result;
        }
        
        return $responseMessage;
    }
    
    private function doTelcoPayment($data)
    {
        $telcoMessage = new TelcoMessageHelper();
        $telcoMessage->setBillerId($data['billerId']);
        $telcoMessage->setPayeeId($data['payeeId']);
        $telcoMessage->setProductId($data['productId']);
        $telcoMessage->setCountryCode($data['countryCode']);
        $telcoMessage->setOperatorCode($data['operatorCode']);
        $telcoMessage->setPhoneNumber($data['phoneNumber']);
        $telcoMessage->setRegionCode($data['regionCode']);
        $telcoMessage->setDatelCode($data['datelCode']);
        $telcoMessage->setCustomerName($data['customerName']);
        $telcoMessage->setCheque('                    '); // space x 20
        $telcoMessage->setOtherCustomerId($data['otherCustomerId']);
        $telcoMessage->setTotalBill($data['totalBill']);
        $telcoMessage->setBillData($data['billData']);
        $telcoMessage->setAdminFee($data['adminFee']);
        
        $telcoPaymentMessage = $telcoMessage->getFinancialPostingPaymentMessage();;
        $responseMessage = SocketHelper::getInstance()->sendMessage($telcoPaymentMessage);
        
        if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
        {
            $isoMessage = $responseMessage['message'];
            $result = $telcoMessage->parseResponseMessage($isoMessage, TelcoMessageHelper::TYPE_PAYMENT_RESPONSE);
            
            if($result['status'] === 'success')
            {
                $strukData = $result['message'];
                $filename = $this->generateTelcoStruk($strukData);
                
                $returnVal = array();
                $returnVal['status'] = 'success';
                $returnVal['message'] = $filename;
                
                return $returnVal;
            }
            
            return $result;
        }
        
        return $responseMessage;
    }
    
    private function doPDAMInquiry($billerId, $productId, $pelangganId)
    {
        $pdamMessage = new PDAMMessageHelper();
        $pdamMessage->setBillerId($billerId);
        $pdamMessage->setPayeeId('0000');
        $pdamMessage->setProductId($productId);
        $pdamMessage->setIdPelanggan($pelangganId);
        
        $pdamInquiryMessage = $pdamMessage->getFinancialInquiryMessage();
        $responseMessage = SocketHelper::getInstance()->sendMessage($pdamInquiryMessage);
        
        if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
        {
            $isoMessage = $responseMessage['message'];
            $result = $pdamMessage->parseResponseMessage($isoMessage);
            
            if($result['status'] === 'success')
            {
                $product = $this->productModel
                        ->where('product_code', $billerId)
                        ->first();

                $ppid = Auth::user()->pp_id;
                $outletProduct = $product->outletProducts()
                        ->where('outlet_id', $ppid)
                        ->first();

                $result['message']['adminFee'] = $outletProduct->admin_value;
                return $result;
            }
            
            return $result;
        }
        
        return $responseMessage;
    }
    
    private function doPDAMPayment($data)
    {
        $pdamMessage = new PDAMMessageHelper();
        $pdamMessage->setBillerId($data['billerId']);
        $pdamMessage->setPayeeId($data['payeeId']);
        $pdamMessage->setProductId($data['productId']);
        $pdamMessage->setIdPelanggan($data['idPelanggan']);
        $pdamMessage->setCustomerName($data['customerName']);
        $pdamMessage->setBillPeriode($data['billPeriode']);
        $pdamMessage->setBillAmount($data['billAmount']);
        $pdamMessage->setBillPenalty($data['billPenalty']);
        $pdamMessage->setKubikasi($data['kubikasi']);
        $pdamMessage->setReferenceNumber($data['referenceNumber']);
        $pdamMessage->setAdminFee($data['adminFee']);
        $pdamPaymentMessage = $pdamMessage->getFinancialPostingPaymentMessage();
        $responseMessage = SocketHelper::getInstance()->sendMessage($pdamPaymentMessage);
        
        if($responseMessage['status'] === SocketHelper::EVERYTHING_OK)
        {
            $isoMessage = $responseMessage['message'];
            $result = $pdamMessage->parseResponseMessage($isoMessage);
            
            if($result['status'] === 'success')
            {
                $strukData = $result['message'];
                $filename = $this->generateTelcoStruk($strukData);
                
                $returnVal = array();
                $returnVal['status'] = 'success';
                $returnVal['message'] = $filename;
                
                return $returnVal;
            }
            
            return $result;
        }
        
        return $responseMessage;
    }
    
    private function getOperatorCodeFromIdPelanggan($pelangganId)
    {
        if(substr($pelangganId, 0, 3) === '021')
        {
            return substr($pelangganId, 0, 3);
        }
        
        return substr($pelangganId, 0, 4);
    }
    
    private function getPhoneNumberFromIdPelanggan($pelangganId)
    {
        if(substr($pelangganId, 0, 3) === '021')
        {
            return substr($pelangganId, 3);
        }
        
        return substr($pelangganId, 4);
    }
    
    private function generateTelcoStruk($data, $isTestStruk = false)
    {
        $struk = new TelcoStrukHelper();
        $struk->setNamaPelanggan($data['customerName']);
        $struk->setNomorTelepon($data['phoneNumber']);
        $struk->setTanggalBayar(date('d F Y'));
        $struk->setDataTagihan($data['billData']);
        $struk->setAdminFee($data['adminFee']);
        $filename = $struk->generate($isTestStruk);
        
        return $filename;
    }
    
    private function generatePDAMStruk($data)
    {
        $bulanTagihan = substr($data['billPeriode'], 3);
        
        $struk = new PDAMStrukHelper();
        $struk->setTanggalBayar(date('d F Y'));
        $struk->setNamaPelanggan($data['customerName']);
        $struk->setIdPelanggan($data['idPelanggan']);
        $struk->setBulanTagihan($bulanTagihan);
        $struk->setNominalTagian($data['billAmount']);
        $struk->setBiayaAdmin($data['adminFee']);
        $filename = $struk->generate();
        
        return $filename;
    }
    
    private function isPDAMIndustry($billerId)
    {
        $industryId = substr($billerId, 0, 2);
        
        return $industryId === '00' ? TRUE : FALSE;
    }
    
    private function isTelcoIndustry($billerId)
    {
        $industryId = substr($billerId, 0, 2);
        
        return $industryId === '02' ? TRUE : FALSE;
    }
}
