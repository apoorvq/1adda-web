<?php

session_start();

if(strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
{

        $errMsg;
        $filename=basename($_FILES["image"]["name"]);
        $target_dir = "uploads/";                            //Directory to store images

        //find today's dat in format (day-month-year)
        $date_from1 = new DateTime('1-9-2016');
        $thisdate=$date_from1->add(new DateInterval('P1D'));

        //extract file's extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        //Id is sent from addMentor.html to add in name at the form submission
        if(isset($_POST['e']))
        {
          $target_file = $target_dir .$_POST['e']."--".$thisdate->format('Y-m-d').".".$ext;
        }

        //This is used when editMentor.php calls this file.Since this is called from jquery , and no uniqueId is
        //requested on edit . Session is used to store the id of the mentor to edit in the php code,.
        else {
          $target_file = $target_dir .$_SESSION['idToEdit']."--".$thisdate->format('Y-m-d').".".$ext;
        }

        $uploadOk;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file))
            {

                $uploadOk=1;
            }
            else
            {

                $errMsg="There was an error uploading your file.";
                $uploadOk=0;
            }


        if($uploadOk==1)
        {
          echo $target_file;
        }
        else
        {
            echo $errMsg;

        }



}


?>
