<?php

class PDAMMessageHelperTest extends TestCase
{
    
    const PDAM_INQUIRY_TEST_MESSAGE = '0000100000005000113000100561Salman El Farisi              2014110000001300000002500012345678-12345678000001306346720000000003500';
    protected $pdamMessage;
    protected $parseResult;
    
    public function setUp() 
    {
        parent::setUp();
        $this->pdamMessage = new PDAMMessageHelper();
        $this->parseResult = $this->pdamMessage->parseDE48Response(self::PDAM_INQUIRY_TEST_MESSAGE);
    }
    
    public function testInquiryBillerIdShould00001()
    {
        $this->assertEquals('00001', $this->parseResult['billerId']);
    }
    
    public function testInquiryPayeeIdShould0000()
    {
        $this->assertEquals('0000', $this->parseResult['payeeId']);
    }
    
    public function testInquiryProductIdShould0005()
    {
        $this->assertEquals('0005', $this->parseResult['productId']);
    }
    
    public function testInquiryIdPelangganShould113000100561()
    {
        $this->assertEquals('113000100561', $this->parseResult['idPelanggan']);
    }
    
    public function testInquiryCustomerNameShouldSalmanElFarisi()
    {
        $this->assertEquals('Salman El Farisi', $this->parseResult['customerName']);
    }
    
    public function testInquiryBillPeriodeShould201411()
    {
        $this->assertEquals('201411', $this->parseResult['billPeriode']);
    }
    
    public function testInquiryBillAmountShould130000()
    {
        $this->assertEquals(130000, $this->parseResult['billAmount']);
    }
    
    public function testInquiryBillPenaltyShould25000()
    {
        $this->assertEquals(25000, $this->parseResult['billPenalty']);
    }
    
    public function testInquiryKubikasiShould12345678()
    {
        $this->assertEquals('12345678-12345678', $this->parseResult['kubikasi']);
    }
    
    public function testInquiryReferenceNumberShould1306346720()
    {
        $this->assertEquals('1306346720', $this->parseResult['referenceNumber']);
    }
    
    public function testInquiryAdminFeeShould3500()
    {
        $this->assertEquals(3500, $this->parseResult['adminFee']);
    }
}
