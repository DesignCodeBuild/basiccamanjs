<?php

  /*
  require_once('../wp-config.php');
  require_once(ABSPATH.'wp-includes/functions.php');
  require_once(ABSPATH.'wp-includes/media.php');
  require_once(ABSPATH.'wp-includes/option.php' );
  require_once(ABSPATH.'wp-includes/post.php' );
  require_once(ABSPATH.'wp-admin/includes/image.php' ); */


  //simplifies resizing using GD functions
  function ce_img_resize($inputfilename, $outputfilename, $type, $width, $height, $crop = true)
  {
	$src_image;
	if($type == "jpg")
	  $src_image = imagecreatefromjpeg($inputfilename);
	else if($type == "png")
	  $src_image = imagecreatefrompng($inputfilename);
	else if($type == "gif")
	  $src_image = imagecreatefromgif($inputfilename);
	else
	  return false;

    $old_x=imageSX($src_image);
    $old_y=imageSY($src_image);
    $thumb_x;
    $thumb_y;
    $new_x = $width;
    $new_y = $height;

    if($new_x > $old_x)
      $new_x = $old_x;
    if($new_y > $old_y)
      $new_y = $old_y;

    if($new_x == $old_x && $new_y == $old_y)
      return true;

    $smallerProp = min($old_x/$new_x, $old_y/$new_y);
    $src_w = intval($new_x*$smallerProp);
    $src_h = intval($new_y*$smallerProp);

    $src_x = ($old_x-$src_w)/2;
    $src_y = ($old_y-$src_h)/2;
  //  echo $src_x . " " . $src_y;

    if(!$crop)
    {
      $src_x = $src_y = 0;
      $src_w = $old_x;
      $src_h = $old_y;
    }

    $dst_image;
    $dst_image=ImageCreateTrueColor($new_x,$new_y);

    imagecopyresampled($dst_image, $src_image,
      0,0,
      $src_x, $src_y,
      $new_x, $new_y,
      $src_w, $src_h);


    if($type == "jpg")
      imagejpeg($dst_image, $outputfilename);
    else if($type == "png")
      imagepng($dst_image, $outputfilename);
    else if($type == "gif")
      imagegif($dst_image, $outputfilename);

    return true;
  }

  // Takes mime type and returns extension (png or jpg)
  // Returns (false) if the extension is unsupported
  //    Otherwise, it returns the extension ("png" or "jpg")

  function ce_find_extension($ce_image_type)
  {
    $ce_extension;

    if($ce_image_type == "image/jpg" || $ce_image_type== "image/jpeg")
      $ce_extension = "jpg";

    if($ce_image_type == "image/png")
      $ce_extension = "png";

    if($ce_image_type == "image/gif")
      $ce_extension = "gif";

    if($ce_image_type != "image/jpg" && $ce_image_type != "image/jpeg" && $ce_image_type != "image/png" && $ce_image_type != "image/gif")
      $ce_extension = false;

    return $ce_extension;
  }

  // Takes extension and returns mime type ("image/png" or "image/jpg"
  // Returns (false) if the extension is unsupported.
  function ce_create_mime_type($ce_extension)
  {
	$ce_extension = strtolower($ce_extension);
    $ce_mime_type;

    if($ce_extension == "png")
      $ce_mime_type = "image/png";

    if($ce_extension == "jpeg" || $ce_extension == "jpg")
      $ce_mime_type = "image/jpeg";

    if($ce_extension == "gif")
      $ce_mime_type = "image/gif";

    if($ce_extension != "jpeg" && $ce_extension != "jpg" && $ce_extension != "png" && $ce_extension != "gif")
      $ce_mime_type = false;
    return $ce_mime_type;
  }

  function ce_random_string()
  {
    $hash = substr(base_convert(hash("md5", microtime(), false), 16, 32), 0, 11);
    return $hash;
  }

  // Using the uploads/year/month format, this will return the current directory
  //   or create it if it doesn't exist.

  /*
  function ce_get_media_directory($ce_wordpress_dir = "./", $ce_base = "wp-content/uploads/")
  {
    // Find out the current year
    $ce_media_dir = "wp-content/uploads/" . date("Y") . "/";
    //Check to see if year directory exists; create it if not.
    if(!is_dir($ce_wordpress_dir.$ce_media_dir))
      mkdir($ce_wordpress_dir.$ce_media_dir);

    // Find out the current month
    $ce_media_dir .=  date("m") . "/";
    // Create the month directory if it doesn't exist
    if(!is_dir($ce_wordpress_dir.$ce_media_dir))
      mkdir($ce_wordpress_dir.$target_dir);
    return $ce_media_dir;
  }*/

  // When exporting as base64 data, must specify either "jpeg" or "png"
  //   It uses "jpeg" instead of "jpg"
  function ce_caman_image_type($ce_extension)
  {
    // If this really is an extension
    if(strpos($ce_extension, '/') === false)
    {
      if($ce_extension == "jpg" || $ce_extension == "jpeg")
        return "jpeg";
      if($ce_extension == "png")
        return "png";
    }
    else // If this is actually a mime type
    {
      if($ce_extension == "image/jpg" || $ce_extension == "image/jpeg")
        return "jpeg";
      if($ce_extension == "image/png")
        return "png";
    }
    return false;
  }

  function ce_escape_string($input)
  {
    return htmlentities($input);
  }

  function ce_unescape_string($input)
  {
    return html_entity_decode($input);
  }

  function ce_base64_to_image($input)
  {
    $dataArr = explode(',', $input);
    return base64_decode($dataArr[1]);
  }

/*
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
  } */

/*
  function ce_smaller_image($ce_image_location)
  {
    $ce_image_data = wp_get_image_editor($ce_image_location);
    if( ! is_wp_error($ce_image_data) )
    {
      $ce_image_data->resize(640, 640, false);
      $ce_image_data->save($ce_image_location);
    }
    else
      return false;
  } */

  function ce_extension_from_filename($filename)
  {
    $lastperiod = strrpos($filename, ".");
    if($lastperiod > 0 && $lastperiod < strlen($filename)-1)
    {
      $ext = substr($filename, $lastperiod+1);
      $mime = ce_create_mime_type($ext);
      return ce_find_extension($mime);
    }
    else
      return false;
  }

  function ce_smaller_image($ce_image_location)
  {
	ce_img_resize($ce_image_location, $ce_image_location,
	              ce_extension_from_filename($ce_image_location),
	              640, 640, true );
  }

  function ce_get_sizes()
  {
    $sizes = array();
    $sizes["100x100"] = array(100,100);
    return $sizes;
  }

  function ce_create_thumbnails($ce_image_location)
  {

	  $sizes = ce_get_sizes();
	  foreach($sizes as $name=>$size )
	  {
		  // strrpos = str[Reverse]pos
		  $extension = ce_extension_from_filename($ce_image_location);
		  $dotpos = strrpos($ce_image_location, ".");
		  $thumb_name = substr($ce_image_location, 0, $dotpos);
		  $thumb_name .= "-" . $name . "." . $extension;

		  //              input file,         save file, jpg/png,     width,     height, crop?
		  ce_img_resize($ce_image_location, $thumb_name, $extension, $size[0], $size[1], true);
	  }
  }

  function ce_add_thumbnail_suffix($ce_image_location)
  {
    $name = "100x100";
    $extension = ce_extension_from_filename($ce_image_location);
    $dotpos = strrpos($ce_image_location, ".");
    $thumb_name = substr($ce_image_location, 0, $dotpos);
    $thumb_name .= "-" . $name . "." . $extension;

    return $thumb_name;
  }

/*
  function ce_create_thumbnails($ce_image_location)
  {
    $requiredSizes = ce_get_image_sizes();
    $image = wp_get_image_editor($imageLocation);
    if( ! is_wp_error($image) )
    {
      $iarray = $image->multi_resize($requiredSizes);
    }
  } */


  function ce_add_to_database($data, $databasename, $username, $password, $tablename)
  {
  //$filename, $imageTitle, $imageCaption, $imageDescription

  if(!isset($data['filename'])
  || !isset($data['title'])
  || !isset($data['caption'])
  || !isset($data['description']))
    return false;

  if(trim($data['title']) == "")
    $data['title'] = "Image";

  $conn = new mysqli("localhost",$username,$password,$databasename);

  $stm = "INSERT INTO $tablename(filename, title, caption, description)".
    " VALUES (?,?,?,?)";
  $stmt = $conn->prepare($stm);
  $stmt->bind_param("ssss", $data['filename'], $data['title'], $data['caption'], $data['description']);
  $stmt->execute();
  $stmt->close();

  $conn->close();

  }

  function ce_update_reactions($databasename, $username, $password, $tablename, $filename, $reactions)
  {
    $conn = new mysqli("localhost",$username,$password,$databasename);

    $stm = "UPATE $tablename SET reactions=? WHERE $filename=?";
    $stmt = $conn->prepare($stm);
    $stmt->bind_param("ss", $reactions, $filename);
    $stmt->execute();
    $stmt->close();


    $conn->close();
  }

  function ce_get_database_list($databasename, $username, $password, $tablename)
  {
    $conn = new mysqli("localhost",$username,$password,$databasename);

    if($result = $conn->query("SELECT * FROM $tablename", MYSQLI_USE_RESULT))
    {
      $out = array();
      while($row = $result->fetch_array())
        $out[] = $row;
      $conn->close();
      return $out;
    }

    $conn->close();
  }

/*
  function ce_add_to_database($ce_filename, $ce_imageMimeType, $ce_imageTitle, $ce_imageCaption, $ce_imageDescription)
  {
    if(trim($ce_imageTitle) == "")
    {
      $ce_imageTitle = "Image";
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

    $ce_imageLocation = $ce_filename;
    echo "iloc: " . $ce_imageLocation . "<br />";
    $attach_ID = wp_insert_attachment($UploadPicture, $ce_imageLocation);
    $attach_data = wp_generate_attachment_metadata($attach_ID, $ce_imageLocation);
    wp_update_attachment_metadata($attach_ID, $attach_data);
    return $attach_ID;
  } */
/*
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

  } */

?>
