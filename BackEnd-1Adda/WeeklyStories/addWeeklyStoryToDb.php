<?php
//called by addMentor.html
require_once "formLogin.php";                    // connection to the Mentor's database
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{
  $data=$_POST['formdata'];                       //serialised form data
  $imgPath=$_POST['i'];
  $id=$_POST['w'];
  $fieldsAndValues=array();
  $toStore=array();
  $toS=array();
  $cnt=0;

  $toStore['uniqueId']=$id;                        //the uniqueId is stored first

  $fieldsAndValues=explode('&',$data);              //the serialized data is separated like key=value

  foreach ($fieldsAndValues as $fAndV) {
    $f=explode('=',$fAndV);
    if($f[0]=="Profiles"&&$f[1]=="Start")             //When profiles start save in adifferent array
    {
      $cnt=1;
    }
    if($f[0]=="Profiles"&&$f[1]=="End")               //When profiles end
    {
        $cnt=0;                                        //carry on with the original toStore array
        $toStore['Profiles']=$toS;                      //Store the profiles array as a sub-array in toStore under the profiles tag
    }
    if($cnt==1&&$f[0]!="Profiles")
    {
      $f[0]=str_replace("ProfileURL","",$f[0]);             //Profiles are added in a separate array
      $toS[urldecode($f[0])]=urldecode($f[1]);               //serialized data is urlencoded.
    }
    elseif ($cnt==0&&$f[0]!="Profiles"&&($f[1]!="Start"||$f[1]!="End"))
    {
      $toStore[urldecode($f[0])]=urldecode($f[1]);           //serialized data is urlencoded
    }

  }
  $toStore['Image']=$imgPath;                                   //save the image path

  $result=$collection->insertOne($toStore);                   //save to database

}
?>
