<?php

class SocketHelper 
{
    private static $instance;
    
    const FAILED_TO_CONNECT = 100;
    const FAILED_TO_SEND_DATA = 101;
    const SERVER_NOT_RESPONDING = 102;
    const EVERYTHING_OK = 200;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function sendMessage($message)
    {
        $result = array();
        
        try
        {   
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            
            $address = Config::get('ppob.server_address');
            $port = Config::get('ppob.server_port');
            socket_connect($socket, $address, $port);
            socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 35, "usec" => 0));
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 70, "usec" => 0));
            
            $isSent = socket_send($socket, $message, strlen($message), 0);
            if($isSent)
            {
                $response = socket_read($socket, 2048);
                $result['status'] = self::EVERYTHING_OK;
                $result['message'] = $response;
            }
            else
            {
                $result['status'] = self::FAILED_TO_SEND_DATA;
                $result['message'] = "";
            }
        }
        catch (Exception $ex) 
        {
            $socketErrorCode = socket_last_error();
            $result['status'] = self::FAILED_TO_CONNECT;
            $result['message'] = socket_strerror($socketErrorCode);
        }
        
        socket_close($socket);
        return $result;
    }
}
