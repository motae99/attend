<?php
namespace app\components;

use Yii;

class attend
{
    public $ip;
    public $port;
    public $device;
    
    public $data_recv = '';
    public $session_id = 0;
    public $userdata = array();
    public $attendancedata = array();
    
    public function __construct($ip='192.168.1.201', $port=4370) {
        $this->ip = $ip;
        $this->port = $port;
        
        $this->device = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        
        $timeout = array('sec'=>60,'usec'=>500000);
        socket_set_option($this->device,SOL_SOCKET,SO_RCVTIMEO,$timeout);
    
        include_once("zkconst.php");
        include_once("zkconnect.php");
        include_once("zkdevice.php");
        
        include_once("zkattendance.php");
    }
    
    
    function createChkSum($p) {
        /*This function calculates the chksum of the packet to be sent to the 
        time clock
        
        Copied from zkemsdk.c*/
        
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
        /*This function puts a the parts that make up a packet together and 
        packs them into a byte string*/
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

    function checkValid($reply) {
        /*Checks a returned packet to see if it returned CMD_ACK_OK,
        indicating success*/
        $u = unpack('H2h1/H2h2', substr($reply, 0, 8) );
        
        $command = hexdec( $u['h2'].$u['h1'] );
        if ($command == CMD_ACK_OK)
            return TRUE;
        else
            return FALSE;
    }

    

    public function connect() {

        $command = CMD_CONNECT;
        $command_string = '';
        $chksum = 0;
        $session_id = 0;
        $reply_id = -1 + USHRT_MAX;

        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
        
        socket_sendto($this->device, $buf, strlen($buf), 0, $this->ip, $this->port);
        
        try {
            socket_recvfrom($this->device, $this->data_recv, 1024, 0, $this->ip, $this->port);
            if ( strlen( $this->data_recv ) > 0 ) {
                $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr( $this->data_recv, 0, 8 ) );
                
                $this->session_id =  hexdec( $u['h6'].$u['h5'] );
                return $this->checkValid( $this->data_recv );
            } else 
                return FALSE;
        } catch(ErrorException $e) {
            return FALSE;
        } catch(exception $e) {
            return FALSE;
        }
    }
    // Disable Connection
    function disConnection(){
        $disable = zkdisconnect($this);
        return $disable;
    }

    //ADD THIS FUNCTION AND ADDED this TO CALL IT
    function reverseHex($hexstr) {
            $tmp = '';
            
            for ( $i=strlen($hexstr); $i>=0; $i-- ) {
                $tmp .= substr($hexstr, $i, 2);
                $i--;
            }
            
            return $tmp;
        }

    function getlogs() {
        $command = CMD_ATTLOG_RRQ;
        $command_string = '';
        $chksum = 0;
        $session_id = $this->session_id;
        
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $this->data_recv, 0, 8) );
        $reply_id = hexdec( $u['h8'].$u['h7'] );

        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
        
        socket_sendto($this->device, $buf, strlen($buf), 0, $this->ip, $this->port);
        
        //try {
        socket_recvfrom($this->device, $this->data_recv, 1024, 0, $this->ip, $this->port);
        
        if ( getSizeAttendance($this) ) {
            $bytes = getSizeAttendance($this);
            while ( $bytes > 0 ) {
                socket_recvfrom($this->device, $data_recv, 1032, 0, $this->ip, $this->port);
                array_push( $this->attendancedata, $data_recv);
                $bytes -= 1024;
            }
            
            $this->session_id =  hexdec( $u['h6'].$u['h5'] );
            socket_recvfrom($this->device, $data_recv, 1024, 0, $this->ip, $this->port);
        }
        
        $attendance = array();  
        if ( count($this->attendancedata) > 0 ) {
            # The first 4 bytes don't seem to be related to the user
            for ( $x=0; $x<count($this->attendancedata); $x++) {
                if ( $x > 0 )
                    $this->attendancedata[$x] = substr( $this->attendancedata[$x], 8 );
            }
            
            $attendancedata = implode( '', $this->attendancedata );
            $attendancedata = substr( $attendancedata, 10 );
            
            while ( strlen($attendancedata) > 40 ) {
                
                $u = unpack( 'H78', substr( $attendancedata, 0, 39 ) );
                //24s1s4s11s
                //print_r($u);

                $uid = hexdec( substr( $u[1], 0, 6 ) );
                $uid = explode(chr(0), $uid);
                $uid = intval( $uid[0] ); 
                $id = intval( str_replace("\0", '', hex2bin( substr($u[1], 6, 8) ) ) );
                $state = hexdec( substr( $u[1], 56, 2 ) );
                $timestamp = decode_time( hexdec( $this->reverseHex( substr($u[1], 58, 8) ) ) ); 
                
                # Clean up some messy characters from the user name
                #uid = unicode(uid.strip('\x00|\x01\x10x'), errors='ignore')
                #uid = uid.split('\x00', 1)[0]
                #print "%s, %s, %s" % (uid, state, decode_time( int( reverseHex( timestamp.encode('hex') ), 16 ) ) )
                
                  array_push( $attendance, array( $uid, $id, $state, $timestamp ) );
                // $attendance[]['uid'] = $uid;
                // $attendance[]['id'] = $id;
                // $attendance[]['state'] = $state;
                // $attendance[]['timestamp'] = $timestamp;
                $attendancedata = substr( $attendancedata, 40 );
            }
            
        }
            
        return $attendance;
        //} catch(exception $e) {
            //return False;
        //}
    }

    function clearLogs(){
     $cleared = zkclearattendance($this);
     return $cleared ;
        
    }
    function disable(){
     $dis = zkdisabledevice($this);
     return $dis ;
        
    }
    function enable(){
     $en = zkenabledevice($this);
     return $en ;
        
    }
    
    
}


// this is how you call from controller
//$model->date_of_birth = Attend::getTime($model->date_of_birth);
?>