<?php
/* 
 * Manage Perosonnel Page
 * 
 */
?>
<div class="grid">
<div class="container">
    <div class="row">
    <div class="span12" style="padding-left: 3em;">
        <h3><a href="start"><img src="img/back.png"></a> personnel</h3>
        <table id="tblp" class="table striped hovered condensed dataTable" width="100%" border="1">
            <thead>
            <tr>
                <th width="10%">Firstname</th>
                <th width="10%">Lastname</th>
                <th width="5%">Sex</th> 
                <th width="10%">Phone</th> 
                <th width="15%">Actions</th> 
            </tr>
            </thead>
            <tbody>
            <?php
            $urlfolder = preg_split("[/]", $_SERVER['REQUEST_URI']);
            //echo $_SERVER['REQUEST_URI']. "<br />";
            //print_r($urlfolder);
            $url="http://".$_SERVER['HTTP_HOST']."/".$urlfolder[1];
            $durl = $url."/shell/morepersonnnel";
            $getjdata = file_get_contents($url."/shell/morepersonnnel");
            $prec = json_decode($getjdata);
            foreach($prec->aaData as $p)
            {
            ?>
            <tr>
                <td id="firstname"><?php echo $p->firstname; ?></td>
                <td id="lastname"><?php echo $p->lastname;  ?></td>
                <td id="sex"><?php echo $p->sex;  ?></td>
                <td id="phone"><?php echo $p->phone;  ?></td>
                <td>
                    <a href="viewprofile&id=<?php echo $p->id;  ?>" class="small bg-blue fg-white button">profile</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr/>
        
        
        <h3>other places</h3>     
        <a href="newpersonnel">
        <div class="tile bg-green" data-click="transform">
        <div class="tile-content icon">
        <i class="icon-user-3"></i>
        </div>
        <div class="tile-status">
        <span class="name">new personnel</span>
        </div>
        </div>
        </a>
        
        <a href="groups">
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
    $('#tblp').dataTable({   
        "bProcessing": true
    });
});
</script>