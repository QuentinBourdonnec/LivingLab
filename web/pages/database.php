<?php
include'conf.php';
function dbConnect(){
  try{
    $conn=new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
    $conn->exec("SET NAMES utf8");
  }
  catch (PDOException $exception){
    return false;
  }
  return $conn;
}

?>
