<?php
require_once('basicCaman.php');

//gathering data related to the image:
  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_caption = ce_unescape_string($_POST['caption']);
 //tell the program where to store the image on your server. 
  $image_directory = "./images/";
  $image_name = ce_random_string();
 //check to see if file is really an image - if not, do not add to server.
 if($image_data != "")
  {
    // delete old file
    unlink($image_tmp_location);
    $filestream = fopen($image_directory.$image_name.".".$image_type, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);

    ce_create_thumbnails($image_directory . $image_name . "." . $image_type);
    $data['filename'] = $image_name.".".$image_type;
    $data['caption'] = $image_caption;
    ce_add_to_database($data, "david_database", "david_caman", "kuR[GuBHE801", "photos2");
  }
  else
  {
    // say "nothing" so we know why it didn't put it in the database.
    echo "nothing.";
  }

?>
