<?php
//called from viewMentor.php
require_once "formLogin.php";

if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{

  $blogToDelete=$_POST['id'];
  $query=array('uniqueId'=>$blogToDelete);
  $collection->deleteOne($query);
  $file = $_POST['img'];
  if($file!='none')       //if Image was provided for the mentor , it's deleted from the directory
  {
    unlink($file);
  }
}
?>
