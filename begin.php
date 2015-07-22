<!DOCTYPE html>
<html>
<head>
  <title>Upload A Picture</title>
  <style type="text/css">
    body
    {

    }
    /* Making the "Choose file" button less ugly */
    div.uploadButton
    {
      position:relative;
      width:130px;
      height:30px;
      background-color:#AA1155;
      overflow:hidden;
      border: 1px solid brown;
      border-radius:4px;
      color:white;
      font-weight:900;
    }
    div.labelUpload
    {
      position:absolute;
      padding:5px;
      top:0; left:0;
      width:130px;
      height:30px;
      background-color:none;
      z-index:3;
      color:white;
    }
    div.uploadButton input
    {
      position:absolute;
      top: 0; left: 0;
      width:130px;
      height:30px;
      opacity:0 !important;
      z-index:9;
    }
  </style>
  <script type="text/javascript">
    function uploadImage()
    {
      var str=document.getElementById('image').value;
      var strParts = str.split(".");
      var strExt = strParts[strParts.length-1].toLowerCase();
      if(strExt == "jpg" || strExt == "png" || strExt == "jpeg")
      {
        document.getElementById("imageForm").submit();
        //equiv. jQuery: $("#imageForm").submit();
      }
      else
      {
        document.getElementById("alarm").innerHTML = "Only supports JPG and PNG files.";
      }
    }
  </script>
</head>
<body>
  <form action="second.php" method="post" enctype="multipart/form-data" id="imageForm">
    <h2 style="color:red;" id="alarm">
      <?php
        // If there's an error code sent by upload file, report it to the user.
        if(isset($_GET['q']))
        {
          if($_GET['q']=="type")
            echo "Only supports JPG and PNG files.";
          else if($_GET['q']=="error")
            echo "Unknown error uploading file.  Try again.";
        }
      ?>
    </h2>
    <div class="uploadButton">
      <div class="labelUpload">Choose a File</div>
      <input type="file" name="image" id="image" onChange="uploadImage()" />
    </div>
  </form>
</body>
</html>
