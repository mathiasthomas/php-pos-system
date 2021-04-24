<?php

//we use try catch method to dispaly the kind of error message during DB connection
try{
    $pdo = new PDO('mysql:host=localhost;dbname=pos_db','root','');
//echo 'connection succesfull';
}catch(PDOException $f){
    echo $f->getmessage();
}




?>