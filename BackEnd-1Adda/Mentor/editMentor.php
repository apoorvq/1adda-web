<?php

  session_start();
  $_SESSION['idToEdit']=$_GET['id'];       //Id was sent in the url stored in a session variable to use in checkImage.php

  //MongoDb\Client won't help in reading the data like an array , therfore this was used.
  $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
  $filter = ['uniqueId' => $_GET['id']];
  $query = new MongoDB\Driver\Query($filter);
  $rows = $manager->executeQuery('backEndData.Mentors', $query);
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
          <link rel="stylesheet" type="text/css" href="../addStyle.css"/>
    </head>
    <body>
    <div id="main">
         <div id="addMentor" style="border:2px solid black; margin :20px;padding:20px;">
            <form   method="post" enctype="multipart/form-data" id="formData">
                name
                </br>
                <input required type="text" name="Name" value="<?php echo $Arr['Name']?>"></input>
                </br></br>
                Description
                </br>
                <textarea  name="Description"  ><?php echo $Arr['Description']?></textarea>
                </br></br>
                Select image to upload:
                </br></br>
                <input  type="file" name="image" id="fileToUpload" ></input>
              </br></br>
                <div id="preview-image"><img src=<?php echo $Arr['Image']?> style="height:200px;width:200px;" id="imgToShow"></div>
                </br></br>
                <?php
                if($Arr['Profiles']){

                  foreach($Arr['Profiles'] as $key => $value){
                      echo "<p>";
                      echo $key;
                      echo "</p>";
                      echo "<input required type='text' name= ";
                      echo 'ProfileURL'.$key;            //Explanation of this oon line 157 in addMentor.php
                      echo " value = ";
                      echo $value;
                      echo " class = url ";
                      echo"></input>";
                      echo "<button class='removeProfile'>Remove</button>";
                  }
                }

                ?>
                <p id ="profiles">Add Profiles</p>

                </br>
                <select id="e2"  >
                    <option value=""><option>
                    <option value="1">Linkedin Profile</option>
                    <option value="2">Twitter</option>
                    <option value="3">Angel.co</option>
                    <option value="4">Blog/website</option>
                    <option value="5">Github</option>
                    <option value="6">Dribble</option>
                    <option value="7">Behance</option>
                </select>
                </br></br>
                Skills
                </br>
                <textarea  name="Skills"  ><?php echo $Arr['Skills']?></textarea>
              </br></br>
                <button type="submit" value="Submit" id="Submit" name="submitForm">Submit</buttton>
            </form>

        </div>

       </div>
    </body>
    <script>
      $(document).ready(function(){
        $("#e2").select2({
              placeholder: "Select a profile",
              allowClear: true
        });
        $('body').on("click",".removeProfile",function(){
          $(this).prev().remove();
          $(this).prev().remove();
          $(this).remove();
        });
        var newInputField,removeButton;
        var inputFieldCntr=0;
        $('#e2').on("select2:select", function (){
          inputFieldCntr++;
          var profileToAdd=$("#e2 option:selected").text();
          newInputField=$("<input required style='display:block;'></input>");
          newInputField.attr('id','input'+inputFieldCntr);
          newInputField.attr('name','ProfileURL'+profileToAdd);
          newInputField.attr('placeholder','Url: '+profileToAdd);
          newInputField.attr('class','url');
          removeButton=$("<button class='removeField'>Remove</button>");
          $('#profiles').after(newInputField);
          //$("#p").prepend(newInputField).after(removeButton);
          newInputField.after(removeButton);
          var endline=$('</br></br>');
          removeButton.after(endline);
         });

        $('body').on("click",".removeField",function(){
          $(this).prev().remove();
          $(this).next().remove();
          $(this).remove();

        });

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


        function insert(str, index, value) {
          return str.substr(0, index) + value + str.substr(index);
        }

        var dontAdd=1;
        var submit=1
        $('#formData').on("submit",function(e){
          e.preventDefault();
          $(".url").each(function(){                              //Check url validity
            if(!($(this).val().match(/^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/)))
              {
                submit=0;
                alert("An incorrect value of url has been entered");
                $(this).focus();
                $(this).css('borderBottom','2px solid red');
                return false;

              }
          });

          if(submit==1)
          {
            var form=$('#formData');
            e.preventDefault();
            var data=form.serialize();
            var pos1=data.indexOf('ProfileURL');
            if(pos1!=-1){
              data=insert(data,pos1,"Profiles=Start&");
              dontAdd=0;
            }
            var pos2=data.indexOf('Skills');
            if(dontAdd==0){
              data=insert(data,pos2,"Profiles=End&");
            }

             $.ajax({
                type:form.attr('method'),
                url:'editMentorInDb.php',
                data:{formdata:data,imgPath},
                async:false,
                success:function(data){
                  alert("Record updated successfully");
                  $('#formData')[0].reset();
                }
            });
        }
          });


      });
    </script>
</html>
