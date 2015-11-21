<?php
/* 
 * New Perosonnel Page
 */
?>
<script>
$("#tblpersonnel").dataTable();
</script>
<div class="grid">
<div class="container">
    <div class="row">
    <div class="container span4">
    <h3><a href="start"><img src="img/back.png" /></a>  new personnel</h3>
    <div id="confirm"></div>
    <form method="post" id="newpersonnel" name="newpersonnel" enctype="multipart/form-data" action="shell/">
    <label for="firstname">Firstname</label>  
    <div class="input-control text">
        <input type="text" value="" name="firstname" id="firstname" placeholder="input firstname" required autofocus/>
        <button class="btn-clear"></button>
    </div>
    <label for="lastname">Lastname</label> 
    <div class="input-control text">
        <input type="text" value="" name="lastname" id="lastname" placeholder="input lastname" required/>
        <button class="btn-clear"></button>
    </div>
    <div class="input-control radio">
    <label>
        <input name="rdsex" id="rdsex" value="Male" type="radio" />
        <span class="check"></span>
        Male
    </label>
    <label>
        <input name="rdsex" id="rdsex" value="Female" type="radio" />
        <span class="check"></span>
        Female
    </label>
    </div>
    <label for="datepicker">Date of Birth</label>
    <div class="input-control text" style="width:40%;" data-role="datepicker" data-format="yyyy-mm-dd" data-effect="slide" data-other-days="1">
        <input type="text" name="dob" id="datepicker" readonly="readonly" required/>
        <button class="btn-date" type="button"></button>
    <div class="calendar calendar-dropdown" style="position: absolute; display: none; max-width: 260px; z-index: 1000; top: 100%; left: 0px;"><table class="bordered"><tbody><tr class="calendar-header"><td class="text-center"><a class="btn-previous-year" href="#"><i class="icon-previous"></i></a></td><td class="text-center"><a class="btn-previous-month" href="#"><i class="icon-arrow-left-4"></i></a></td><td colspan="3" class="text-center"><a class="btn-select-month" href="#"></a></td><td class="text-center"><a class="btn-next-month" href="#"><i class="icon-arrow-right-4"></i></a></td><td class="text-center"><a class="btn-next-year" href="#"><i class="icon-next"></i></a></td></tr><tr class="calendar-subheader"><td class="text-center day-of-week">Su</td><td class="text-center day-of-week">Mo</td><td class="text-center day-of-week">Tu</td><td class="text-center day-of-week">We</td><td class="text-center day-of-week">Th</td><td class="text-center day-of-week">Fr</td><td class="text-center day-of-week">Sa</td></tr><tr><td class="empty"><small class="other-day">27</small></td><td class="empty"><small class="other-day">28</small></td><td class="empty"><small class="other-day">29</small></td><td class="empty"><small class="other-day">30</small></td><td class="empty"><small class="other-day">31</small></td><td class="text-center day"><a href="#">1</a></td><td class="text-center day"><a href="#">2</a></td></tr><tr><td class="text-center day"><a href="#">3</a></td><td class="text-center day"><a href="#">4</a></td><td class="text-center day"><a href="#">5</a></td><td class="text-center day"><a href="#">6</a></td><td class="text-center day"><a href="#">7</a></td><td class="text-center day"><a href="#">8</a></td><td class="text-center day"><a href="#">9</a></td></tr><tr><td class="text-center day"><a href="#">10</a></td><td class="text-center day"><a href="#">11</a></td><td class="text-center day"><a href="#" class="selected">12</a></td><td class="text-center day"><a href="#">13</a></td><td class="text-center day"><a href="#">14</a></td><td class="text-center day"><a href="#">15</a></td><td class="text-center day"><a href="#">16</a></td></tr><tr><td class="text-center day"><a href="#">17</a></td><td class="text-center day"><a href="#">18</a></td><td class="text-center day"><a href="#">19</a></td><td class="text-center day"><a href="#">20</a></td><td class="text-center day"><a href="#">21</a></td><td class="text-center day"><a href="#">22</a></td><td class="text-center day"><a href="#">23</a></td></tr><tr><td class="text-center day"><a href="#">24</a></td><td class="text-center day"><a href="#">25</a></td><td class="text-center day"><a href="#">26</a></td><td class="text-center day"><a href="#">27</a></td><td class="text-center day"><a href="#">28</a></td><td class="text-center day"><a href="#">29</a></td><td class="text-center day"><a href="#">30</a></td></tr></tbody></table></div></div>
    <label for="phone">Phone</label> 
    <div class="input-control text">
        <input type="number" value="" name="phone" id="phone" placeholder="input phone number" required/>
        <button class="btn-clear"></button>
    </div>             
    <label for="email">Email</label> 
    <div class="input-control text">
        <input type="email" value="" name="email" id="email" placeholder="input email" />
        <button class="btn-clear"></button>
    </div>         
    <label for="address">Address</label>
    <div class="input-control textarea" data-role="input-control">
        <textarea name="address" id="address" style="margin: 0px; height: 60px; width: 300px;" /></textarea>
    </div>
    <?php 
    $urlfolder = split("/", $_SERVER['REQUEST_URI']) ;
    $url="http://".$_SERVER['HTTP_HOST']."/".$urlfolder[1];
    //echo $url;
    ?>
    <label for="group" style="display: none;">Select Group/Category</label>
    <div id="group" style="display: none;" class="input-control select">
        <select name="groupid" required>
        <?php 
        $getjdata = file_get_contents($url."/shell/getgroup");
        $grec = json_decode($getjdata);
        foreach($grec->aaData as $g)
        {
        ?>
            <option><?php echo $g->grpname ?></option>        
        <?php } ?>
    </select>
    </div>
    <label for="passport">Upload Passport</label> 
    <div class="input-control file">
        <input type="file" id="passport" name="passport" required />
        <button class="btn-file"></button>
    </div>
    <div id="response">
    </div>
    <div style="padding-top: 20px;">
    <input type="hidden" name="cmd" value="newpersonnel" id="cmd" />
    <input type="submit" name="btnsave" class="large success" value="Save" id="btnsave" />
    <input type="reset" name="btnreset" class="large danger"value="Clear" id="btnreset" />
    </div>
    </form>
    </div>

    <div class="span8" style="padding-left: 3em;">
        <h3>personnel</h3>
        <table id="tblpersonnel" class="table striped hovered condensed dataTable" width="100%" border="1">
            <thead>
            <tr>
                <th width="35%">Firstname</th>
                <th width="35%">Lastname</th>
                <th width="20%">Sex</th> 
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{Firstname}</td>
                <td>{Lastname}</td>
                <td>{Sex}</td>
            </tr>
            </tbody>
            
        </table>
        <hr/>
        
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
$(function(){
    $('#tblpersonnel').dataTable({   
        "bProcessing": true,
        "sAjaxSource": "<?php echo $url."/shell/getpersonnnel"; ?>",
         "aoColumns": [
                    { "mData": "firstname" },
                    { "mData": "lastname" },
                    { "mData": "sex" }
                ]
    });
});

$(document).ready(function(){

    $('#newpersonnel').submit(function(){
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
                $('#firstname').focus();
                //$('#newpersonnel').reset();
                document.getElementById("newpersonnel").reset();
                $('#confirm').html('<div id="confirm" class="notice bg-green marker-on-top fg-white">Profile Saved</div>');
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
});
</script>