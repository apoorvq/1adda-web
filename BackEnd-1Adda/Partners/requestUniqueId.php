<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['partnerRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->PartnerCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Partners'];
      $idChange=$document['Partners']+1;
      $toFind=array("Partners" =>$document['Partners']);
      $setTo=array("Partners" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
