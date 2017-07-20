<?php

  session_start();
  $_SESSION['idToEdit']=$_GET['id'];       //Id was sent in the url stored in a session variable to use in checkImage.php

  //MongoDb\Client won't help in reading the data like an array , therfore this was used.
  $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
  $filter = ['uniqueId' => $_GET['id']];
  $query = new MongoDB\Driver\Query($filter);
  $rows = $manager->executeQuery('backEndData.Blogs', $query);
  foreach($rows as $row){
    foreach($row as $r=>$v){
      $Arr[$r]=$v;
    }
  }

  $_SESSION['img']=$Arr['Image'];

?>
<html>
<!--since the record will be deleted and entered again , no field can be left blank-->
    <head>
        <script src="../jquery-3.2.1.min.js"></script>
        <link href="../select2.min.css" rel="stylesheet"/>
        <script src="../select2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../jquery.datepick.css">
        <script type="text/javascript" src="../jquery.plugin.js"></script>
        <script type="text/javascript" src="../jquery.datepick.js"></script>
          <link rel="stylesheet" type="text/css" href="../addStyle.css"/>
    </head>
    <body>
    <div id="main">
         <div id="addMentor" style="border:2px solid black; margin :20px;padding:20px;">
            <form   method="post" enctype="multipart/form-data" id="formData">
                <p>Name</p>
                </br>
                <input required type="text" name="Name" value="<?php echo $Arr['Name']?>"></input>
                </br></br>
                <p>Description</p>
                </br>
                <textarea required name="Description"  ><?php echo $Arr['Description']?></textarea>
                </br></br>
                <p>Select image to upload:</p>
                </br></br>
                <input  type="file" name="image" id="fileToUpload" ></input>
              </br></br>
                <div id="preview-image"><img src=<?php echo $Arr['Image']?> style="height:200px;width:200px;" id="imgToShow"></div>
                <p>Key Area</p>
                <textarea name="Key_Area"  ><?php echo $Arr['Key_Area']?></textarea>
                <p>Industry</p>
                <textarea name="Industry"  ><?php echo $Arr['Industry']?></textarea>
                <p>Date</p>
                <input name="Date"  id="Date" value="<?php echo $Arr['Date']?> "></input>
                <p>Publisher</p>
                <textarea name="Publisher"  ><?php echo $Arr['Publisher']?></textarea>
              </br></br>
                <button type="submit" value="Submit" id="Submit" name="submitForm">Submit</buttton>
            </form>

        </div>

       </div>
    </body>
    <script>
      $(document).ready(function(){
        $('#Date').datepick({dateFormat: 'yyyy-mm-dd'});
        function readURL(input) {
          if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#imgToShow').attr('src',e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      var imgPath="NoEdit";
      $("#fileToUpload").change(function(){
          readURL(this);
          var img = new FormData();
          img.append('image', $('#fileToUpload').prop('files')[0]);
          $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            data:img,
            url: 'checkImage.php',
            async:false,
            success: function(Data){
                $('#imgToShow').attr('src',Data);
                imgPath=Data;
              },
            error:function(data){

              }
          });
        });

        var dontAdd=1;

        $('#formData').on("submit",function(e){
            var form=$('#formData');
            e.preventDefault();
            var data=form.serialize();

             $.ajax({
                type:form.attr('method'),
                url:'editBlogInDb.php',
                data:{formdata:data,imgPath},
                async:false,
                success:function(data){
                  alert("Record updated successfully");
                  $('#formData')[0].reset();
                }
            });

        });


      });
    </script>
</html>
