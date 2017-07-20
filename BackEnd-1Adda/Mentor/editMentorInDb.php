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
  $toS=array();
  $cnt=0;

  $query=array('uniqueId'=>$id);
  $collection->deleteOne($query);

  $toStore['uniqueId']=$id;
  $fieldsAndValues=explode('&',$data);
  foreach ($fieldsAndValues as $fAndV) {
    $f=explode('=',$fAndV);
    if($f[0]=="Profiles"&&$f[1]=="Start")
    {
      $cnt=1;
    }
    if($f[0]=="Profiles"&&$f[1]=="End")
    {
        $cnt=0;
        $toStore['Profiles']=$toS;
    }
    if($cnt==1&&$f[0]!="Profiles")
    {
      $f[0]=str_replace("ProfileURL","",$f[0]);
      $toS[urldecode($f[0])]=urldecode($f[1]);
    }
    elseif ($cnt==0&&$f[0]!="Profiles"&&($f[1]!="Start"||$f[1]!="End"))
    {
      $toStore[urldecode($f[0])]=urldecode($f[1]);
    }

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
