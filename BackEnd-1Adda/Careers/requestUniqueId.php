<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['careerRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->CareerCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Careers'];
      $idChange=$document['Careers']+1;
      $toFind=array("Careers" =>$document['Careers']);
      $setTo=array("Careers" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
