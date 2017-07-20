<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['eventRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->EventCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Events'];
      $idChange=$document['Events']+1;
      $toFind=array("Events" =>$document['Events']);
      $setTo=array("Events" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
