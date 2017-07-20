
<!-- Add mentor details to database -->

<html>
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
                <input required type="text" name="Name" ></input>
                <p>Description (Elevator Pitch, 150 words.)</p>
                <textarea  name="Description"  ></textarea>
                <p>Select image to upload:</p>
                <div id="photo">
                  <span><input type="file" name="image" id="fileToUpload" ></input></span>
                  <div id="preview-image"><img src="../noImage.png" style="height:200px;width:200px;" id="imgToShow"></div>
                </div>
                </br></br>

                <p id="profiles">Add Profiles</p>
                <select id="e2"  >
                    <option value=""><option>
                    <option value="1">Linkedin Profile</option>
                    <option value="2">Twitter</option>
                    <option value="3">Angel.co</option>
                    <option value="4">Blog/website</option>
                    <option value="5">Github</option>
                    <option value="6">Dribble</option>
                    <option value="7">Behance</option>
                    <option value="8">Others<option>
                </select>

                <p>Key Area</p>
                <textarea name="Key_Area"  ></textarea>
                <p>Launch Date</p>
                <input name="LaunchDate"  id="LaunchDate"></textarea>
                </br></br>
                <p>Industry</p>
                <textarea name="Industry"  ></textarea>

                <button type="submit" value="Submit" id="Submit" name="submitForm">Submit</buttton>
            </form>

        </div>

       </div>
        <script>
        $(document).ready(function(){
          $('#LaunchDate').datepick({dateFormat: 'yyyy-mm-dd'});
          $("#e2").select2({
                placeholder: "Select a profile",
                allowClear: true
            });

          var newInputField,removeButton;      // input field and remove button to show on select
          var inputFieldCntr=0;                //To provide Id

          $('#e2').on("select2:select", function (){
            inputFieldCntr++;
            var profileToAdd=$("#e2 option:selected").text();

            newInputField=$("<input required style='display:block;'></input>");

            newInputField.css({'width': '50%','padding': '12px 20px','display': 'block;','border': '1px solid #ccc','borderRadius': '4px','boxSizing': 'borderBox'});
            newInputField.attr('id','input'+inputFieldCntr);
            newInputField.attr('name','ProfileURL'+profileToAdd);                 //This is really stupid. I'll explain at the end.
            newInputField.attr('placeholder','Url: '+profileToAdd);
            newInputField.attr('class','url');                                    //to check if url entered is correct , on submission.

            removeButton=$("<button class='removeField'>Remove</button>");

            removeButton.css({'margin':'10px','width':'130px'});
            $('#profiles').after(newInputField);

            newInputField.after(removeButton);
            var endline=$('</br></br>');
            removeButton.after(endline);
           });

          $('body').on("click",".removeField",function(){     //Removes the remove button , endline and the corresponding input field.
            $(this).prev().remove();
            $(this).next().remove();
            $(this).remove();

          });

          function readURL(input) {                           //Function to preview image before uploading
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $('#imgToShow').attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

        $("#fileToUpload").change(function(){
            readURL(this);
          });

          function insert(str, index, value) {                       //function to insert a string into another at a specified position
            return str.substr(0, index) + value + str.substr(index);
          }

          var dontAdd=1;                                              //This is also stupid .So, at the end.
          var startupUniqueId;
          var imgPath;                                                //The path where the image is stored.
          var submit=1;
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

            if(submit==1){                                        //Propagate only if urls are valid
              var form=$('#formData');

              e.preventDefault();

              $.ajax({                                            //request a unique id for the mentor
                type:'Post',
                url:'requestUniqueId.php',
                data:{startupRequest:1},
                async:false,
                success(id)
                {
                  startupUniqueId="SUP_"+id;

                }
              });

              var img = new FormData();                                   //Upload image
              img.append('image', $('#fileToUpload').prop('files')[0]);  //The image is saved as "Mentorid--date.etension"
              img.append('s',startupUniqueId);                           //Therefore mentor Id is also sent
              $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                data:img,
                url: 'checkImage.php',
                async:false,
                success: function(Data){
                        imgPath=Data;
                },
                error:function(data){
                }
              });

               //Now here is the explanation of those stupid things .
               //More than 1 profiles can be added or none as well.
               //I needed to save the profiles and their url in a separate array.
               //Therefore , needed to know where the profiles began in the form's serialized data.
              var data=form.serialize();

              var pos1=data.indexOf('ProfileURL');          //And , hence this tag was added before every profile.
              if(pos1!=-1){                                 //If it's not found => no profiles were added.
                data=insert(data,pos1,"Profiles=Start&");   //This is inserted right before Profiles start .
                dontAdd=0;                                  //dontAdd is set to 0 (false if any profiles were added)
              }
              var pos2=data.indexOf('Key_Area');
              if(dontAdd==0){                               //If any profiles were added
                data=insert(data,pos2,"Profiles=End&");     //This is inserted right after profiles end.
              }

               e.preventDefault();
               $.ajax({                                     //data is sent to enter into the database
                  type:form.attr('method'),
                  url:'addStartupToDb.php',
                  data:{formdata:data,i:imgPath,s:startupUniqueId},
                  async:false,
                  success:function(data){
                    alert("Record was succesfully inserted with Id:"+startupUniqueId);
                    $('#imgToShow').attr('src','../noImage.png');
                     $('#formData')[0].reset();
                  }
              });
            }

          });
        });
        </script>
    </body>
</html>
