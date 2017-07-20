<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['advisorRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->AdvisorCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Advisors'];
      $idChange=$document['Advisors']+1;
      $toFind=array("Advisors" =>$document['Advisors']);
      $setTo=array("Advisors" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }


}

?>
