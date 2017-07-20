<html>
    <head>
        <script src="../jquery-3.2.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../viewStyle.css"/>
    </head>
    <body>
      <div id="main">
        <?php
        require_once "formLogin.php";
        $result = $collection->find();
        ?>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Image</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>

    <?php

        foreach($result as $document)
        {

          //Every record's id , name and image are displayed.
          //Along with two buttons remove and edit.
          //Remove has two attribute attached to it , id and image of Mentor
          //id to delete from db
          //img to delete from directory if edited.
            $img="../noImage.png";
            if($document['image'])            //Only if there was an image already providedof the mentor
            {
              $img=$document['image'];
            }
            echo "<tr>";
            echo "<td>";
            echo $document['uniqueId'];
            echo"</td>";
            echo "<td>";
            echo $document['Name'];
            echo"</td>";
            $img=$document['Image'];
            echo"<td><img src=";
            echo $img ;
            echo " style='width:200px;height:200px;'></img></td>";
            echo "<td><button idWS=";
            echo $document['uniqueId'];
            echo " imgWS= ";
            echo $img;
            echo " >Remove</button>";
            echo "<a href=editWeeklyStory.php?id=";                  //Edit button redirects to editMentor.php along with the id
            echo $document['uniqueId'];                         //of the mentor in the url.
            echo ">Edit</a></td>";
            echo "</tr>";
        }
        ?>
      </tbody>
      </table>

      </div>
    </body>
    <script>
      $(document).ready(function(){

        function confirmDelete(elem) {
            var txt;
            var r = confirm("Are you sure?");
            if (r == true) {
              var id=elem.attr('idWS');
              var img=elem.attr('imgWS');
              elem.closest('tr').remove();                    //id and image of the mentor are sent to be deleted
              $.ajax({
                  url:'deleteWeeklystory.php',
                  type:'Post',
                  data :{id,img},
                  success(){
                    alert('deleted');
                  }
              });
            }
            else {

            }

          }

        $('body').on("click","button",function(){
          confirmDelete($(this));                                       //On delete a confirm dialog box opens
        });
      });
    </script>
</html>
