<?php
  
  require_once('../wp-config.php');
  require_once(ABSPATH.'wp-includes/functions.php');
  require_once(ABSPATH.'wp-includes/media.php');
  require_once(ABSPATH.'wp-includes/option.php' );
  require_once(ABSPATH.'wp-includes/post.php' );
  require_once(ABSPATH.'wp-admin/includes/image.php' );
  require_once('basicCaman.php');

  $ce_photo_gallery_ID = 4;

  $imageData = ce_correct_base64($_POST['data']);
  $imageName = $_POST['name'];
  $imageType = $_POST['type'];
  $imageMimeType = ce_create_mime_type($imageType);
  $imageDirectory = ABSPATH . ce_correct_base64($_POST['dir']);
  $imageDescription = ce_correct_base64($_POST['description']);
  $imageCaption = ce_correct_base64($_POST['caption']);
  $imageTitle = ce_correct_base64($_POST['title']);


  if($imageData != "")
  {
    echo "<!doctype html><html><head><style>body{font-family:\"Courier New\", Courier, monospace;}</style></head><body>";
    echo $imageName . "<br />" . $imageType . "<br />" . $imageMimeType . "<br />" . $imageDirectory . "<br />" . $imageDescription . "<br />" . $imageCaption . "<br />" . $imageTitle. "<br />";
    $filestream = fopen($imageDirectory.$imageName.".".$imageType, "wb");
    fwrite($filestream, ce_base64_to_image($imageData));
    fclose($filestream);
  
    ce_create_thumbnails($imageDirectory.$imageName.$imageType);
    $imageID = ce_add_to_database($imageDirectory, $imageName, $imageType, $imageMimeType, $imageTitle, $imageCaption, $imageDescription);
    ce_add_to_photo_gallery($ce_photo_gallery_ID, $imageID);
    echo "</body></html>";
  }
  else
  {
    echo "nothing.";
  }



?>
