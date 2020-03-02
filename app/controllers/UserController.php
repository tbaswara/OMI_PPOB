<?php

class UserController extends BaseController 
{    
    protected $userModel;
    protected $ppModel;
    
    public function __construct(User $userModel, PaymentPoint $ppModel) {
        $this->userModel = $userModel;
        $this->ppModel = $ppModel;
    }
    
    public function validateAuthToken()
    {
        $username = Input::get('username');
        $authToken = Input::get('auth_token');
        
        $user = $this->userModel
                ->where('username', $username)
                ->where('auth_token', $authToken)
                ->first();
        
        if(is_null($user))
        {
            return View::make('authtoken')
                    ->with('message', 'Username / AuthToken tidak valid');
        }
        else if($user->is_used)
        {
            return View::make('authtoken')
                    ->with('message', 'Token sudah digunakan. Silahkan kontak sistem administrator');
        }
        
        $user->is_used = 1;
        $user->save();
        
        $cookie = Cookie::forever('auth_token', $authToken);
        return Redirect::to('/user/login')
                ->withCookie($cookie);
    }
    
    public function validateUser()
    {
        $username = Input::get('username');
        $password = sha1(Input::get('password'));
        $token = Cookie::get('auth_token');
        
        $user = $this->userModel
                ->where('username', $username)
                ->where('password', $password)
                ->where('auth_token', $token)
                ->first();
        
        if(is_null($user))
        {
            return View::make('login')
                ->with('message', 'username / password salah');
        }
        
        Auth::login($user);
        return Redirect::intended('/transaksi');
    }
    
    public function ajaxChangePassword()
    {
        $oldPassword = Input::get('old_password');
        $newPassword = Input::get('new_password');
        $username = Auth::user()->username;
        $token = Cookie::get('auth_token');
        
        $user = $this->userModel
                ->where('username', $username)
                ->where('password', sha1($oldPassword))
                ->where('auth_token', $token)
                ->first();

        $result = array();
        if(!is_null($user))
        {
            $user->password = sha1($newPassword);
            $user->save();
            
            $result['status'] = 'success';
            $result['message'] = 'Password telah berhasil diganti';
        }
        else
        {
            $result['status'] = 'failed';
            $result['message'] = 'Gagal mengganti password, pastikan password lama anda benar';
        }
        
        return Response::json($result);
    }
    
    public function ajaxUpdateProfile()
    {
        $input = Input::get();
        $ppid = Auth::user()->pp_id;
        $user = $this->ppModel
                ->where('pp_id', $ppid)
                ->first();
        
        $user->nama = $input['nama_pp'];
        $user->nama_pemilik = $input['nama_pemilik'];
        $user->alamat = $input['alamat'];
        $user->kota = $input['kota'];
        $user->kode_pos = $input['kode_pos'];
        $user->kode_propinsi = $input['kode_propinsi'];
        $user->kode_negara = $input['kode_negara'];
        $user->save();
        
        $result = array();
        $result['status'] = 'success';
        $result['message'] = '';
        
        return Response::json($result);
    }
    
    public function ajaxUpdateTimer()
    {
        $timer = Input::get('timer');
        $user = Auth::user();
        $user->timer = $timer;
        $user->save();
        
        $result = array();
        $result['status'] = 'success';
        $result['message'] = '';
        
        return Response::json($result);
    }
}