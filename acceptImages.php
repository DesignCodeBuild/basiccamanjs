<?php
  
  require_once('basicCaman.php');

  $ce_photo_gallery_ID = 4;

  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_description = ce_unescape_string($_POST['description']);
  $image_caption = ce_unescape_string($_POST['caption']);
  $image_title = ce_unescape_string($_POST['title']);

  $image_directory = ABSPATH. ce_get_media_directory("../");

  $image_name = ce_random_string();

  if($image_data != "")
  {
    // delete old file
    unlink($image_tmp_location);
    echo "<!doctype html><html><head><style>body{font-family:\"Courier New\", Courier, monospace;}</style></head><body>";
    echo $image_name . "<br />" . $image_type . "<br />" . $image_mime_type . "<br />" . $image_directory . "<br />" . $image_description . "<br />" . $image_caption . "<br />" . $image_title. "<br />";
    $filestream = fopen($image_directory.$image_name.".".$image_type, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);
  
    ce_create_thumbnails($image_directory.$image_name.$image_type);
    $image_id = ce_add_to_database($image_directory, $image_name, $image_type, $image_mime_type, $image_title, $image_caption, $image_description);
    ce_add_to_photo_gallery($ce_photo_gallery_ID, $image_id);
    echo "</body></html>";
  }
  else
  {
    echo "nothing.";
  }

?>
