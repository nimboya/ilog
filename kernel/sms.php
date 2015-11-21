<?php
/*
 * Title: sms
 * Type: kernel
 * Description: Performs all SMS Operations: Send, Check Balance etc
 * Date and Time: 2015-04-05 01:07pm
 * Author: Ewere Diagboya
 */
class SMS extends easyDB {
    // POST: Send SMS
    function SendSMS($sender, $to, $msg) {
        foreach ($to as $recs) {
            $sender = trim($sender);
            $recs = trim($recs);
            $msg = trim($msg);
          
        // Send SMS Through API
        $sendresponse = $this->SMSThruAPI($sender, $recs, $msg);
        
        // Deduct from Total SMS
        //$deductresponse = $this->SMSDeduct($senderid, $to, $msg, $clid);
        }
        echo "OK";
    }
    
    // POST: Send a Message to All Members in system
    function SendToAll($sender, $msg) {
        $resource = $this->Retrieve();
        $qry = "SELECT phone FROM personel";
        $rec = "";
        $getallqry = mysqli_query($resource, $qry);
        while($phone = mysqli_fetch_array($getallqry)) {  
             $rec .= $phone['phone'].",";
        }
        $recs = explode(",", $rec);
        $this->SendSMS($sender, $recs, $msg);
    }
    
    // GET: Get Balance
    function SMSBalance() {
        $res = $this->sysconnect();
        $query = "SELECT * FROM ilmanager WHERE clid='cyonstp'";
        $qry = mysqli_query($res, $query);
        while($row = mysqli_fetch_object($qry)) {
            $p[] = $row;
        }
        $data = json_encode($p);
        return $data;
    }
    
    function SMSThruAPI($from, $recs, $msg) {
        /*
         * http://smsc.xwireless.net/API/WebSMS/Http/v1.0a/index.php?method=show_dlr&username=wicee&password=tarsus01&msg_id=42048-150607-10442406-4120611102-78786&seq_id=1&limit=0,10&format=json
         */
        
        $username = "wicee";
        $password = "tarsus01";
        $out = file("http://smsc.xwireless.net/API/WebSMS/Http/v3.1/index.php?username=".$username."&password=".$password."&sender=".$from."&to=".$recs."&message=".urlencode($msg)."&reqid=1&format=text");    
        return $out;
    }
    // Shows List of SMS Sent
    function SentSMS($from, $recs, $msg) {
         foreach ($to as $recs) {
            $sender = trim($sender);
            $recs = trim($recs);
            $msg = trim($msg);
        $f = '["sender","to","msg"]';
        $v = '[$sender, $to,$msg]';
        $resp = $this->Insert("sms", $f, $v);
        return $resp;
            
        }
    }
    
    function SMSDeduct($senderid, $to, $msg, $clid) {
        foreach ($splnos as $recs) { // Sending Loop
            if (SMSBalance() > 0) // If balance is greater than 0 then user can send
            {
                    // Send to Database
                    $link = $this->dbconect();
                    $f = '["senderid","to","msg","status","clid"]';
                    $v = '[$senderid,$to, $msg,$clid]';
                    $insq = $this->Insert("sms", $f, $v);
                    $close = mysqli_close($link);

                    $sysres = $this->sysconnect();
                    // Update balance by deducting from original
                    $sqlupd = "UPDATE client SET smsbal=smsbal-1 WHERE clid='".trim($clid)."'";
                    $runupd = mysqli_query($sysres,$sqlupd) or die("Server Error");
            }
            else // If balance is equal to or greater than 0
            {
                    echo "ER";
                    break;
            }
        } // Sending Loop
    } // SMS Deduction
    
    
}  // Class Closing