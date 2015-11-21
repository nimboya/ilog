<?php
/* 
 * Group Page
 * 
 */
?>
<div class="grid">
<div class="container">
    <div class="row">
    <div class="container span4">
    <h3><a href="start"><img src="img/back.png" /></a>  new group</h3>
    <form method="post" name="newgroup" action="shell/">
    <label for="grpname">Group Name</label>  
    <div class="input-control text">
        <input type="text" value="" name="grpname" id="grpname" placeholder="input group name" required/>
        <button class="btn-clear"></button>
    </div>
    <label for="grpname">Group Description</label>  
    <div class="input-control textarea" data-role="input-control">
        <textarea name="grpdesc" id="grpdesc" placeholder="describe the group" style="margin: 0px; height: 40px; width: 300px;" required/></textarea>
    </div>
    <input type="hidden" name="cmd" value="newgroup" id="cmd" />
    <input type="hidden" name="source" value="newgroup" id="source" />
    <input type="submit" name="btnsave" class="large success" value="Save" id="btnsave" />
    <input type="reset" name="btnreset" class="large danger"value="Clear" id="btnreset" />
    </form>
    </div>

    <div class="span8" style="padding-left: 3em;">
        
        <h3>group</h3>
        <table id="tblgroup" class="table striped hovered condensed dataTable" width="100%" border="1">
            <thead>
            <tr>
                <th width="35%">Group/Category Name</th>
                <th width="35%">Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{Group Name}</td>
                <td>{Group Description}</td>
            </tr>
            </tbody>
        </table>
        <hr/>
        
        
        <h3>other places</h3>     
        <a href="#">
        <div class="tile bg-green" data-click="transform">
        <div class="tile-content icon">
        <i class="icon-dashboard"></i>
        </div>
        <div class="tile-status">
        <span class="name">dashboard</span>
        </div>
        </div>
        </a>
        
        <a href="#">
        <div class="tile bg-orange" data-click="transform">
        <div class="tile-content icon">
        <i class="icon-grid"></i>
        </div>
        <div class="tile-status">
        <span class="name">groups/categories</span>
        </div>
        </div>
        </a>
        
        <a href="#">
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
    $('#tblgroup').dataTable({   
        "bProcessing": true,
        "sAjaxSource": "http://localhost/il/shell/getgroup",
         "aoColumns": [
                    { "mData": "grpname" },
                    { "mData": "grpdesc" }
                        ]
    });
        
        
});
</script>