<?php

class Product extends Eloquent 
{
    
    protected $table = 'product';
    public $timestamps = false;
    
    public function outletProducts()
    {
        return $this->hasMany('OutletProduct', 'product_id');
    }
    
    public function subProducts()
    {
        return $this->hasMany('SubProduct', 'product_id');
    }
}
