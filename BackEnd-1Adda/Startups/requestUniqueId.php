<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['startupRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->StartupCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Startups'];
      $idChange=$document['Startups']+1;
      $toFind=array("Startups" =>$document['Startups']);
      $setTo=array("Startups" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
