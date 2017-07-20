<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['blogRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->BlogCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Blogs'];
      $idChange=$document['Blogs']+1;
      $toFind=array("Blogs" =>$document['Blogs']);
      $setTo=array("Blogs" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
