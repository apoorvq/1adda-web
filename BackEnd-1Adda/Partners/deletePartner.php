<?php
//called from viewMentor.php
require_once "formLogin.php";

if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{

  $partnerToDelete=$_POST['id'];
  $query=array('uniqueId'=>$partnerToDelete);
  $collection->deleteOne($query);
  $file = $_POST['img'];
  if($file!='none')       //if Image was provided for the mentor , it's deleted from the directory
  {
    unlink($file);
  }
}
?>
