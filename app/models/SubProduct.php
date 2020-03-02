<?php

class SubProduct extends Eloquent 
{
    
    protected $table = 'subproduct';
    
    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }
}
