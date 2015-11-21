<?php
/* 
 * Title: group
 * Type: kernel
 * Description: Holds all the kernel inclusion to be included once 
 * in the shell file and in all kernel files
 * Date and Time: 2015-03-26 12:39am
 * Author: Ewere Diagboya
 */
class Group extends easyDB {
    // Properties
    public $grptable = "`group`"; // Table Name
    
    // POST /CreateGroup
    // Description: Creates a group or category using some parameters
    function CreateGroup(){
        $grpname = ""; $grpdesc="";
        extract($_POST);
        $grpid = $this->generateGuid();
        $vs = [$grpname, $grpid, $grpdesc];
        $f = array("grpname", "grpid", "grpdesc");
        $cg = $this->Insert($this->grptable, $f, $vs);
        return $cg;
    }
    
    // GET /DeleteGroup
    // Description: Deletes a group using the parameter id of the group
    function DeleteGroup($groupid) {
        $proc = $this->Delete($this->grptable, "WHERE groupid = '$groupid'");
        return $proc;
    }
    
    // GET /ViewGroups
    // Description: Displays a list of all the groups in the system
    public function GetGroup() {
        $resource = $this->Retrieve();
        $query = mysqli_query($resource, "SELECT grpname, grpdesc FROM `group`");
        while ($row = mysqli_fetch_object($query)) {
            $p[] = $row;
        }
        return json_encode($p);
    }
    
}
?>