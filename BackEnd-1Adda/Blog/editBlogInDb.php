<?php
//The entire record is deleted and saved anew.
require_once "formLogin.php";
session_start();
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{
  $data=$_POST['formdata'];
  $imgPath=$_POST['imgPath'];
  $id=$_SESSION['idToEdit'];
  $fieldsAndValues=array();
  $toStore=array();

  $query=array('uniqueId'=>$id);
  $collection->deleteOne($query);

  $toStore['uniqueId']=$id;
  $fieldsAndValues=explode('&',$data);

  foreach ($fieldsAndValues as $fAndV) {
    $f=explode('=',$fAndV);
    $toStore[urldecode($f[0])]=urldecode($f[1]);
  }

  //if image wasn't edited
  if($imgPath=="NoEdit")
  {
    $imgPath=$_SESSION['img'];
  }

  $toStore['Image']=$imgPath;
  $result=$collection->insertOne($toStore);
  print_r($toStore);
}
?>
