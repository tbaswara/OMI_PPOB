<?php

class TelcoMessageHelperTest extends TestCase 
{
    const DE48_INQUIRY_TEST_MESSAGE 
        = "02009000000016200217776435   626432Salman El Farisi              1306346720      30231120140000000056400000006500000000000565000000066000000000005660000000670000000003500";
    
    const DE48_POSTING_TEST_MESSAGE
        = "02009000000016200217776435   626432Salman El Farisi              1306346720                          30000000056400000006500000000000565000000066000000000005660000000670000000003500";
    
    const DE48_PURCHASE_TEST_MESSAGE
        = "0200700000001620021009876510000000002500020150101TVLQPD5SF34W82Z40000003500";
    
    protected $telcoMessage;
    protected $purchaseParseResult;
    
    public function setUp() {
        parent::setUp();
        $this->telcoMessage = new TelcoMessageHelper();
        $this->purchaseParseResult = $this->telcoMessage->parseDE48PurchaseResponse(self::DE48_PURCHASE_TEST_MESSAGE);
    }
    
    public function testInquiryBillerIdShould02009()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('02009', $result['billerId']);
    }
    
    public function testInquiryPayeeIdShould0000()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('0000', $result['payeeId']);
    }
    
    public function testInquiryProductIdShould0001()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('0001', $result['productId']);
    }
    
    public function testInquiryCountryCodeShould62()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(62, $result['countryCode']);
    }
    
    public function testInquiryOperatorCodeShould0021()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('0021', $result['operatorCode']);
    }
    
    public function testInquiryPhoneNumberShould7776435()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('7776435', $result['phoneNumber']);
    }
    
    public function testInquiryRegionCodeShould62()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(62, $result['regionCode']);
    }
    
    public function testInquiryDatelCodeShould6432()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(6432, $result['datelCode']);
    }
    
    public function testInquiryCustomerNameShouldSalmanElFarisi()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('Salman El Farisi', $result['customerName']);
    }
    
    public function testInquiryOtherCustomerIdShould1306346720()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('1306346720', $result['otherCustomerId']);
    }
    
    public function testInquiryTotalBillValueShould3()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(3, $result['totalBill']);
    }
    
    public function testInquiryBillStatusShould0()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(0, $result['billStatus']);
    }
    
    public function testInquiryDueDateShould23112014()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals('23112014', $result['dueDate']);
    }
    
    public function testInquiryTotalBillDataShould3()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $totalBillData = sizeof($result['billData'], 3);
        $this->assertEquals(3, $totalBillData);
    }
    
    public function testInquiryFirstBillRefShould00000000564()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][0];
        $this->assertEquals('00000000564', $billData['billRef']);
    }
    
    public function testInquiryFirstBillAmountShould65000()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][0];
        $this->assertEquals(65000, $billData['billAmount']);
    }
    
    public function testInquirySecondBillRefShould00000000565()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][1];
        $this->assertEquals('00000000565', $billData['billRef']);
    }
    
    public function testInquirySecondBillAmountShould66000()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][1];
        $this->assertEquals(66000, $billData['billAmount']);
    }
    
    public function testInquiryThirdBillRefShould00000000566()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][2];
        $this->assertEquals('00000000566', $billData['billRef']);
    }
    
    public function testInquiryThirdBillAmountShould67000()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $billData = $result['billData'][2];
        $this->assertEquals(67000, $billData['billAmount']);
    }
    
    public function testInquiryAdminFeeShould3500()
    {
        $result = $this->telcoMessage->parseDE48InquiryResponse(self::DE48_INQUIRY_TEST_MESSAGE);
        $this->assertEquals(3500, $result['adminFee']);
    }
    
    public function testPostingBillerIdShould02009()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('02009', $result['billerId']);
    }
    
    public function testPostingPayeeIdShould0000()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('0000', $result['payeeId']);
    }
    
    public function testPostingProductIdShould0001()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('0001', $result['productId']);
    }
    
    public function testPostingCountryCodeShould62()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals(62, $result['countryCode']);
    }
    
    public function testPostingOperatorCodeShould0021()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('0021', $result['operatorCode']);
    }
    
    public function testPostingPhoneNumberShould7776435()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('7776435', $result['phoneNumber']);
    }
    
    public function testPostingRegionCodeShould62()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals(62, $result['regionCode']);
    }
    
    public function testPostingDatelCodeShould6432()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals(6432, $result['datelCode']);
    }
    
    public function testPostingCustomerNameShouldSalmanElFarisi()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('Salman El Farisi', $result['customerName']);
    }
    
    public function testPostingOtherCustomerIdShould1306346720()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals('1306346720', $result['otherCustomerId']);
    }
    
    public function testPostingTotalBillValueShould3()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals(3, $result['totalBill']);
    }
    
    public function testPostingTotalBillDataShould3()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $totalBillData = sizeof($result['billData'], 3);
        $this->assertEquals(3, $totalBillData);
    }
    
    public function testPostingFirstBillRefShould00000000564()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][0];
        $this->assertEquals('00000000564', $billData['billRef']);
    }
    
    public function testPostingFirstBillAmountShould65000()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][0];
        $this->assertEquals(65000, $billData['billAmount']);
    }
    
    public function testPostingSecondBillRefShould00000000565()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][1];
        $this->assertEquals('00000000565', $billData['billRef']);
    }
    
    public function testPostingSecondBillAmountShould66000()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][1];
        $this->assertEquals(66000, $billData['billAmount']);
    }
    
    public function testPostingThirdBillRefShould00000000566()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][2];
        $this->assertEquals('00000000566', $billData['billRef']);
    }
    
    public function testPostingThirdBillAmountShould67000()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $billData = $result['billData'][2];
        $this->assertEquals(67000, $billData['billAmount']);
    }
    
    public function testPostingAdminFeeShould3500()
    {
        $result = $this->telcoMessage->parseDE48PostingResponse(self::DE48_POSTING_TEST_MESSAGE);
        $this->assertEquals(3500, $result['adminFee']);
    }
    
    public function testPurchaseBillerIdShould02007()
    {
        $result = $this->purchaseParseResult['billerId'];
        $this->assertEquals('02007', $result);
    }
    
    public function testPurchasePayeeIdShould0000()
    {
        $result = $this->purchaseParseResult['payeeId'];
        $this->assertEquals('0000', $result);
    }
    
    public function testPurchaseProductIdShould0001()
    {
        $result = $this->purchaseParseResult['productId'];
        $this->assertEquals('0001', $result);
    }
    
    public function testPurchaseCountryCodeShould62()
    {
        $result = $this->purchaseParseResult['countryCode'];
        $this->assertEquals('62', $result);
    }
    
    public function testPurchaseOperatorCodeShould0021()
    {
        $result = $this->purchaseParseResult['operatorCode'];
        $this->assertEquals('0021', $result);
    }
    
    public function testPurchasePhoneNumberShould0098765100()
    {
        $result = $this->purchaseParseResult['phoneNumber'];
        $this->assertEquals('0098765100', $result);
    }
    
    public function testPurchaseVoucherNominalShould25000()
    {
        $result = $this->purchaseParseResult['voucherNominal'];
        $this->assertEquals(25000, $result);
    }
    
    public function testPurchaseWindowPeriodShould20150101()
    {
        $result = $this->purchaseParseResult['windowPeriod'];
        $this->assertEquals('20150101', $result);
    }
    
    public function testPurchaseSerialNumberShouldTVLQPD5SF34W82Z4()
    {
        $result = $this->purchaseParseResult['serialNumber'];
        $this->assertEquals('TVLQPD5SF34W82Z4', $result);
    }
    
    public function testPurchaseAdminFeeShould3500()
    {
        $result = $this->purchaseParseResult['adminFee'];
        $this->assertEquals(3500, $result);
    }
}
