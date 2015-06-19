<?php
  
  require_once('../wp-config.php');
  require_once(ABSPATH.'wp-includes/functions.php');
  require_once(ABSPATH.'wp-includes/media.php');
  require_once(ABSPATH.'wp-includes/option.php' );
  require_once(ABSPATH.'wp-includes/post.php' );
  require_once(ABSPATH.'wp-admin/includes/image.php' );

  function correctBase64($input, $justSlash=false)
  {
    $input = str_replace("^", "/", $input);
    if($justSlash === false)
    {
      $input = str_replace("-", "+", $input);
      $input = str_replace("*", ":", $input);
      $input = str_replace("_", ";", $input);
      $input = str_replace("~", "=", $input);
    }
    return $input;
  }
  
  function base64ToImage($input)
  {
    $dataArr = explode(',', $input);
    return base64_decode($dataArr[1]);
  }

  function ce_createMimeType($extention)
  {
    if($extention == "png")
      return "image/png";
    if($extention == "jpeg" || $extention == "jpg")
      return "image/jpeg";
  }

  function ce_get_image_sizes()
  {
    $ce_sizes = array();
    foreach(array('thumbnail', 'medium', 'large') as $ce_size)
    {
      $ce_sizes[ $ce_size ]['width'] = get_option( $ce_size . '_size_w' );
      $ce_sizes[ $ce_size ]['height'] = get_option( $ce_size . '_size_h' );
      $ce_sizes[ $ce_size ]['crop'] = get_option( $ce_size . '_crop' );
    }
      // This one is hard to find: I think it depends on the theme.
    $ce_sizes['sixzerofour'] = array('width' => 604, 'height' => 270, 'crop'=>true);
    return $ce_sizes;
  }

  function ce_create_thumbnails($ce_image_location)
  {
    $requiredSizes = ce_get_image_sizes();
    $image = wp_get_image_editor($imageLocation);
    if( ! is_wp_error($image) )
    {
      $iarray = $image->multi_resize($requiredSizes);
    }
  }

  function ce_add_to_database($ce_directory, $ce_imageName, $ce_imageExtention, $ce_imageMimeType, $ce_imageTitle, $ce_imageCaption, $ce_imageDescription)
  {
    if(trim($ce_imageTitle) == "")
    {
      $ce_imageTitle = $ce_imageName;
    }
    $UploadPicture = array(
      //'ID'		=> {}, // leave empty to specify that this is a NEW
      'post_content'	=> $ce_imageDescription,
      'post_name'	=> strtolower($ce_imageTitle),
      'post_title'	=> $ce_imageTitle,
      'post_status' 	=> 'inherit',
      'post_author'	=> 1,
      'post_excerpt'	=> $ce_imageCaption,
      'post_mime_type'	=> $ce_imageMimeType
    );

    $ce_imageLocation = $ce_directory . $ce_imageName . "." . $ce_imageExtention;
    echo "iloc: " . $ce_imageLocation . "<br />";
    $attach_ID = wp_insert_attachment($UploadPicture, $ce_imageLocation);
    $attach_data = wp_generate_attachment_metadata($attach_ID, $ce_imageLocation);
    wp_update_attachment_metadata($attach_ID, $attach_data);
    return $attach_ID;
  }

  function ce_add_to_photo_gallery($ce_gallery_id, $ce_image_id)
  {
    // Get that post's content, eg "...[gallery ids="1, 2, 5"]..."
    $ce_postdata = get_post($ce_gallery_id);
    $ce_oldcontent = $ce_postdata->post_content;
    // Find where the first gallery begins
    $ce_startpos = strpos($ce_oldcontent, '[gallery');
    // (if there is no gallery, exit.)
    if($startpos === false)
      return false;
    
    // Cut off anything before "[gallery.." and save it
    $ce_begin_portion = substr($ce_oldcontent, 0, $ce_startpos);
    // Gallery portion is "[gallery.." and after
    $ce_gallery_portion = substr($ce_oldcontent, $ce_startpos);
    
    // Find where '[gallery..' ends: where there is a ']'.
    $ce_endpos = strpos($ce_gallery_portion, ']');
    // Cut off the end, and save it (if there are more characters there.
    $ce_end_portion = "";
    if(strlen($ce_gallery_portion) > $ce_endpos+1)
    {
      $ce_end_portion = substr($ce_gallery_portion, $ce_endpos+1);
    }
    $ce_gallery_portion = substr($ce_gallery_portion, 0, $ce_endpos+1);

    // This should specifically find the ids within parentheses.
    // e.g. in '[gallery ids="4,7,10,15"]' this would find "4, 7, 10, 15"
    $e1 = explode('ids=', $ce_gallery_portion);
    $e2 = explode('"', $e1[1]);
    $ids = $e2[1];
      //$ids = explode('"', explode('ids', $ce_gallery_portion)[1])[1];
    // Add the new image we just created.
    $ids = $ce_image_id . "," . $ids;

    //Put the new ids's section back into a [gallery] shortlist.
    $ce_gallery_portion = $e1[0] . 'ids="' . $ids . '"' . $e2[2];
    //Add information preceeding or going after the [gallery].
    $ce_newdata = $ce_begin_portion . $ce_gallery_portion . $ce_end_portion;
    echo "cenewdata: " . $ce_newdata . "<br />";

    // Change this object
    $ce_postdata->post_content=$ce_newdata;
    // Make the changes live in the database.
    wp_update_post($ce_postdata);
    
  }

  $ce_photo_gallery_ID = 6;

  $imageData = correctBase64($_POST['data']);
  $imageName = $_POST['name'];
  $imageType = $_POST['type'];
  $imageMimeType = ce_createMimeType($imageType);
  $imageDirectory = ABSPATH . correctBase64($_POST['dir'], true);
  $imageDescription = correctBase64($_POST['description'], true);
  $imageCaption = correctBase64($_POST['caption'], true);
  $imageTitle = correctBase64($_POST['title'], true);

  if($imageData != "")
  {
    echo "<!doctype html><html><head><style>body{font-family:\"Courier New\", Courier, monospace;}</style></head><body>";
    echo $imageName . "<br />" . $imageType . "<br />" . $imageMimeType . "<br />" . $imageDirectory . "<br />" . $imageDescription . "<br />" . $imageCaption . "<br />" . $imageTitle. "<br />";
    $filestream = fopen($imageDirectory.$imageName.".".$imageType, "wb");
    fwrite($filestream, base64ToImage($imageData));
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
