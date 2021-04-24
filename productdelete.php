<?php

include_once'connectdb.php';
$id=$_POST['pid'];
$sql="delete from tbl_product where p_id=$id";
$delete=$pdo->prepare($sql);
if($delete->execute()){
    
}else{
    echo'error in deleting';
}

?>