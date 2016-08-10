<?php
  require_once('basicCaman.php');

  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_description = ce_unescape_string($_POST['description']);
  $image_caption = ce_unescape_string($_POST['caption']);
  $image_title = ce_unescape_string($_POST['title']);

  $image_directory = "./images/";

  $image_name = ce_random_string();

  if($image_data != "")
  {
    // delete old file
    unlink($image_tmp_location);
    $filestream = fopen($image_directory.$image_name.".".$image_type, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);
  
    ce_create_thumbnails($image_directory . $image_name . "." . $image_type);
    $data['filename'] = $image_name.".".$image_type;
    $data['title'] = $image_title;
    $data['caption'] = $image_caption;
    $data['description'] = $image_description;
    ce_add_to_database($data, C_DATABASENAME, C_USERNAME, C_PASSWORD, C_TABLE);
  }
  else
  {
    // say "nothing" so we know why it didn't put it in the database.
    echo "nothing.";
  }
?>
