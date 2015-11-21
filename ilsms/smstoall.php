<?php
/* 
 * New SMS Message
 * 
 */
?>
<?php
    $urlfolder = split("/", $_SERVER['REQUEST_URI']) ;
    $url="http://".$_SERVER['HTTP_HOST']."/".$urlfolder[1];
    $ourl = "/shell/getpersonnelforsms";
    $getjdata = file_get_contents($url.$ourl);
?>
<div class="grid">
    <div class="container">
        <div class="row">
            <div class="container span8">
                <h3><a href="start"><img src="img/back.png" /></a>  send to all</h3>
                <div id="confirm"></div>
                <form method="post" id="sta" name="sta" action="shell/">
                    <label for="senderid">Sender ID</label>  
                    <div class="input-control text" style="width:50%;">
                        <input type="text" name="sender" maxlength="11" id="sender" placeholder="enter sender ID" required autofocus/>
                        <button class="btn-clear"></button>
                    </div>
                   
                    <label for="message">Message</label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea name="message" id="message"  placeholder="enter message here" style="margin: 5px; height: 150px; width: 500px;" required/></textarea>
                    </div>    
                    Message Count: <input type="text" id="totalmsg" size="3" maxlength="4" disabled="disabled" value="0" /><br ><br >
                    <input type="hidden" name="cmd" value="sendtoall" id="cmd" />
                    <input type="submit" name="btnsend" class="large success" value="Send" id="btnsend" />
                    <input type="reset" name="btnreset" class="large danger"value="Clear" id="btnreset" />
                    
                </form>
                
                <form method="post" id="smstoall" class="smstoall" name="smstoall" style="display: none;" action="shell/">
                    <label for="senderid">Sender ID</label>  
                    <div class="input-control text" style="width:50%;">
                        <input type="text" name="sender" maxlength="11" id="sender" placeholder="enter sender ID" required autofocus/>
                        <button class="btn-clear"></button>
                    </div>
                   
                    <label for="message">Message</label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea name="message" id="message"  placeholder="enter message here" style="margin: 5px; height: 150px; width: 500px;" required/></textarea>
                    </div>    
                    Message Count: <input type="text" id="totalmsg" size="3" maxlength="4" disabled="disabled" value="0" /><br ><br >
                    <input type="hidden" name="cmd" value="sendtoall" id="cmd" />
                    <input type="submit" name="btnsend" class="large success" value="Send" id="btnsend" />
                    <input type="reset" name="btnreset" class="large danger"value="Clear" id="btnreset" />
                </form>    
                    </div>
            
            <div class="span4">
                 <h3>sms</h3>             
                <a href="newsms">
                <div class="tile bg-pink" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                    <span class="name">new sms</span>
                </div>
                </div>
                </a>
                
                <a href="smssent">
                <div class="tile bg-red" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                    <span class="name">sent sms</span>
                </div>
                </div>
                </a>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <h3>other places</h3>     
                <a href="personel">
                <div class="tile bg-teal" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-user-2"></i>
                </div>
                <div class="tile-status">
                    <span class="name">personnel</span>
                </div>
                </div>
                </a>
        
                <a href="group">
                <div class="tile bg-orange" data-click="transform">
                <div class="tile-content icon">
                <i class="icon-grid"></i>
                </div>
                <div class="tile-status">
                <span class="name">groups/categories</span>
                </div>
                </div>
                </a>

                <a href="sms">
                <div class="span4">
                <div class="tile bg-olive" data-click="transform">
                <div class="tile-content icon">
                <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                <span class="name">sms</span>
                </div>
                </div>
                </div>
                </a> 
                 
            </div>
            
            </div>
            
            
        </div>
    </div>

<script>
$(document).ready(function() {
 
$('#smstoall').submit(function(){
        // show that something is loading
        //$('#btnsave').val('Loading...');
        $('#response').html("<img src='img/loader3.gif' alt=''/><br />Loading ...");
        $('#confirm').html('');
        /*
         * 'post_receiver.php' - where you will pass the form data
         * $(this).serialize() - to easily read form data
         * function(data){... - data contains the response from post_receiver.php
         */
        $.ajax({
            type: 'POST',
            url: 'shell/', 
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false
        })
        .done(function(data){
            // show the response
            if(data === "OK") {
                $('#response').html('');
                //$('#newpersonnel').reset();
                
                $('#confirm').html('<div id="confirm" class="notice bg-green marker-on-top fg-white">Message Sent</div>');
                $('#response').html('');
            }
            else {
                $('#response').html("<div style='padding: 10px;' class='bg-darkRed fg-white'>"+data+"</div>");
                $('#confirm').html('');
            }
        })
        .fail(function() {
            // just in case posting your form failed
            alert( "Error in processing, try again" );
            $('#response').html('');
            $('#confirm').html('');
        });
        // to prevent refreshing the whole page page
        return false;
    });


$("#sender").focus(function(){
    $('#confirm').html('');
});

$("#message").keyup(function(){
    $('#totalmsg').val($(this).val().length);
 });
});
</script>