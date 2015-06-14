<!DOCTYPE html>
<html>
<head>
  <title>Upload A Picture</title>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/camanjs/4.0.0/caman.full.min.js"></script>
  <style type="text/css">
    body
    {
      
    }
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
      document.getElementById("imageForm").submit();
    }
  </script>
</head>
<body>
  <form action="second.php" method="post" enctype="multipart/form-data" id="imageForm">
    <h2 style="color:red;" id="alarm"><?php if($_GET['q']=="img") {echo "Only supports JPG and PNG files.";} ?></h2>
    <div class="uploadButton">
      <div class="labelUpload">Choose a File</div>
      <input type="file" name="image" id="image" onChange="uploadImage()" />
    </div>
  </form>
</body>
</html>
