<?php
  
  function correctBase64($input)
  {
    $input = str_replace("_", "/", $input);
    $input = str_replace("-", "+", $input);
    $input = str_replace("*", ":", $input);
    $input = str_replace("^", ";", $input);
    $input = str_replace("~", "=", $input);
    return $input;
  }

  function base64ToImage($input)
  {
    $dataArr = explode(',', $input);
    return base64_decode($dataArr[1]);
  }


  $imageData = correctBase64($_POST['data']);
  $imageName = $_POST['name'];
  $imageType = $_POST['type'];
  $filestream = fopen($imageName."-alt.".$imageType, "wb");
  fwrite($filestream, base64ToImage($imageData));
  fclose($filestream)

?>
