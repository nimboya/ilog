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
                <h3><a href="start"><img src="img/back.png" /></a>  new sms</h3>
                <div id="confirm"></div>
                <form method="post" id="newsms" name="newsms" action="shell/">
                    <label for="senderid">Sender ID</label>  
                    <div class="input-control text" style="width:50%;">
                        <input type="text" name="sender" maxlength="11" id="sender" placeholder="enter sender ID" required autofocus/>
                        <button class="btn-clear"></button>
                    </div>
                    <label for="receiver">Receiver</label>  
                    <div class="input-control textarea" style="width:50%;">
                    <select name="recs[]" style="width:500px;" id="rec" class="rec" multiple="multiple">
                    <?php
                    $grec = json_decode($getjdata);
                    foreach($grec->aaData as $g)
                    {
                    ?>
                       <option value="<?php echo $g->id; ?>"><?php echo $g->name; ?></option>
                    <?php } ?>
                    </select>
                        
                    <label for="message">Message</label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea name="message" id="message"  placeholder="enter message here" style="margin: 0px; height: 50px; width: 500px;" required/></textarea>
                    Counter: <input type="text" name="counter" maxlength="3" disabled="disabled" id="counter" placeholder="0" required autofocus/>
                    </div>
                    <div id="response">
                    </div>
                    <input type="hidden" name="cmd" value="newsms" id="cmd" />
                    <input type="submit" name="btnsend" class="large success" value="Send" id="btnsend" />
                    <input type="reset" name="btnreset" class="large danger"value="Clear" id="btnreset" />
                    
                    </div>
                </form>
            </div>
            
            <div class="span4">
                <h3>sms</h3>             
                <a href="smstoall">
                <div class="tile bg-pink" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                    <span class="name">send to all</span>
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
    $("#rec").select2({ 
       tags: true,
       tokenSeparators: [',', ' ']
    });
 
$('#newsms').submit(function(){
        $('#response').html("<img src='img/loader3.gif' alt=''/><br />Loading ...");
        $('#confirm').html('');
    
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
    //alert(($(this).val().length));
    //var strlent = $(this).val().length);
    //$("#smscounter").html('Message Length');
    $('#counter').val($(this).val().length);
    
 });
});
//document.getElementById("smscounter").innerHTML = "GAME";
</script>