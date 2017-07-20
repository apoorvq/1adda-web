<?php
require '../vendor/autoload.php';
if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{


  $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

  if(isset($_POST['mentorRequest']))
  {
  //  $toGet=array("Menotors"=>1);
    $collection=$client->IDs->MentorCount;
    $result=$collection->find();
    $idToReturn;
    foreach($result as $document)
    {
      $idToReturn=$document['Mentors'];
      $idChange=$document['Mentors']+1;
      $toFind=array("Mentors" =>$document['Mentors']);
      $setTo=array("Mentors" => $idChange);
      $set=array('$set'=>$setTo);
      $collection->updateOne($toFind, $set);
    }

    echo $idToReturn;
  }



}

?>
