<?php


class OutletProduct extends Eloquent
{
    protected $table = 'outlet_product';
    public $timestamps = false;
    
    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }
}
