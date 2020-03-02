<?php

class ProductController extends BaseController 
{
    protected $productModel;
    protected $outletProductModel;
    
    public function __construct(Product $productModel, OutletProduct $outletProductModel)
    {
        $this->productModel = $productModel;
        $this->outletProductModel = $outletProductModel;
    }
    
    public function ajaxGetAllPostPaidProducts()
    {
        $response = array();
        $ppid = Auth::user()->pp_id;
        $outletProducts = $this->outletProductModel
                ->where('outlet_id', $ppid)
                ->get();
        
        foreach($outletProducts as $outletProduct)
        {
            $product = $outletProduct->product;
            if($product->is_postpaid)
            {
                $subProducts = $product->subProducts()
                    ->where('nominal', 0)
                    ->get();
            
                $data = array();
                $data['product'] = $product;
                $data['sub_products'] = $subProducts;

                array_push($response, $data);
            }
        }
        
        return Response::json($response);
    }
    
    public function ajaxGetAllPrePaidProducts()
    {
        $response = array();
        $ppid = Auth::user()->pp_id;
        $outletProducts = $this->outletProductModel
                ->where('outlet_id', $ppid)
                ->get();
        
        foreach($outletProducts as $outletProduct)
        {
            $product = $outletProduct->product;
            if(!$product->is_postpaid)
            {
                $subProducts = $product->subProducts()
                    ->where('nominal', '>', 0)
                    ->get();
            
                $data = array();
                $data['product'] = $product;
                $data['sub_products'] = $subProducts;

                array_push($response, $data);
            }
        }
        
        return Response::json($response);
    }
}
