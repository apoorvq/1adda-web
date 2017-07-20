<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['WSRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->WeeklyStoryCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['WeeklyStories'];
      $idChange=$document['WeeklyStories']+1;
      $toFind=array("WeeklyStories" =>$document['WeeklyStories']);
      $setTo=array("WeeklyStories" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
