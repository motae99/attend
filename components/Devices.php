<?php
namespace app\components;

use yii\base\Object;

class Devices extends Object
{
	public $ip;
    public $port;
    public $device;
    
    public $data_recv = '';
    public $session_id = 0;
    public $userdata = array();
    public $attendancedata = array();
	public function __construct($ip, $port, $config = [])
	{
		$this->ip = $ip;
        $this->port = $port;
        
        $this->device = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        
        $timeout = array('sec'=>60,'usec'=>500000);
        socket_set_option($this->device,SOL_SOCKET,SO_RCVTIMEO,$timeout);
    
        include_once("const.php");
        include_once("connect.php");
        include_once("device.php");
        include_once("user.php");
        include_once("attendance.php");
	// ... initialization before configuration is applied
		parent::__construct($config);
	}
	// public function init()
	// {
	// parent::init();
	// // ... initialization after configuration is applied
	// }
	function createChkSum($p) {
        $l = count($p);
        $chksum = 0;
        $i = $l;
        $j = 1;
        while ($i > 1) {
            $u = unpack('S', pack('C2', $p['c'.$j], $p['c'.($j+1)] ) );
            
            $chksum += $u[1];
            
            if ( $chksum > USHRT_MAX )
                $chksum -= USHRT_MAX;
            $i-=2;
            $j+=2;
    	}

        if ($i)
            $chksum = $chksum + $p['c'.strval(count($p))];
        
        while ($chksum > USHRT_MAX)
            $chksum -= USHRT_MAX;
        
        if ( $chksum > 0 ) 
            $chksum = -($chksum);
        else
            $chksum = abs($chksum);
            
        $chksum -= 1;
        while ($chksum < 0)
            $chksum += USHRT_MAX;
        
        return pack('S', $chksum);
    }
    
    public function createHeader($command, $chksum, $session_id, $reply_id, $command_string) {
        $buf = pack('SSSS', $command, $chksum, $session_id, $reply_id).$command_string;
        
        $buf = unpack('C'.(8+strlen($command_string)).'c', $buf);
        
        $u = unpack('S', $this->createChkSum($buf));
        
        if ( is_array( $u ) ) {
            while( list( $key ) = each( $u ) ) {
                $u = $u[$key];
                break;
            }
        }
        $chksum = $u;
        
        $reply_id += 1;
        
        if ($reply_id >= USHRT_MAX)
            $reply_id -= USHRT_MAX;
        
        $buf = pack('SSSS', $command, $chksum, $session_id, $reply_id);
        
        return $buf.$command_string;
    
    }	

    function checkValid($reply) 
    {
        $u = unpack('H2h1/H2h2', substr($reply, 0, 8) );
        
        $command = hexdec( $u['h2'].$u['h1'] );
        if ($command == CMD_ACK_OK)
            return TRUE;
        else
            return FALSE;
    }


    function connection(){
        $connect = connect($this);
        return $connect;
    }

    function disConnection(){
        $disconnect = disconnect($this);
        return $disconnect;
    }

    function getLogs(){
        $logs = getattendance($this);
        return $logs;
    }

    function clearLogs(){ 
     $cleared = clearattendance($this);
     return $cleared ;
        
    }

    function enable(){
     $en = enabledevice($this);
     return $en ;
        
    }

    function disable(){
     $dis = disabledevice($this);
     return $dis ;
        
    }

    function allUsers(){
    	$users = getuser($this);
    	return $users;
    }

    function clearUsers(){
        $cleared = clearuser($this);
        return $cleared ;
    }

    function setUsers($uid, $userid, $name, $password, $role){
        $set = setuser($this, $uid, $userid, $name, $password, $role);
        return $set ;
    }
    // setuser($this, $uid, $userid, $name, $password, $role)
    // getSizeUser($this)
    // getuser($this)
    // clearuser($this)
    // clearadmin($this)

    function getSizeOfAtt(){
        $size = getSizeAttendance($this);
        return $size ;
    }
    

}