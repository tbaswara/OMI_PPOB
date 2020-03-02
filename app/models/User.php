<?php

use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface
{
    use Illuminate\Auth\UserTrait;
    
    protected $table = 'pp_user';
    protected $hidden = array('password', 'auth_token');
    
    public $timestamps = false;
    
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if(!$isRememberTokenAttribute)
        {
            parent::setAttribute($key, $value);
        }
    }
    
    public function paymentPoint()
    {
        return $this->hasOne('PaymentPoint');
    }
}
