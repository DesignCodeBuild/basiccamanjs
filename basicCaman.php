<?php


  //simplifies resizing using GD functions (graphics library in PHP that makes it possible to manipulate files (the $ arguments are what we deem important to the process of resizing - for the filter.php page and gallery.php page)
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

  // returns false for unsuccessful like; true for successful like.
  function ce_like_image($databasename, $username, $password, $tablename, $filename)
  {
    // find out if the image has been liked before
    // grab all previous liked images
    session_start();
    $likedArray; 
    if(!isset($_SESSION['ig_files']) || ( isset($_SESSION['ig_files']) && $_SESSION['ig_files'] == "" ) )
    {
      $likedArray = array();
    }
    else
    {
      $likedArray = explode("|", $_SESSION['ig_files']);
    }

    // check to see if this image has been liked
    $matchFound = false;
    
    for($i = 0; $i<count($likedArray);++$i)
    {
      if ($likedArray[$i] == $filename) 
      {
        $matchFound = true;
        break;
      }
    }

    $output = false;
    //act
    if($matchFound)
    {
      $output = false;
    }
    else
    {
      $likedArray[] = $filename;
      $output = true;
    
      // Send the like to the database
      $conn = new mysqli("localhost",$username,$password,$databasename);
    
      $stm = "UPDATE $tablename SET likes = likes + 1 WHERE filename = ?";
      $stmt = $conn->prepare($stm);
      $stmt->bind_param("s", $filename);
      
      $stmt->execute();
      
      $stmt->close();
      $conn->close();
    }
    
    // update & remember liked files
    $_SESSION['ig_files'] = implode("|",$likedArray);

    return $output;    
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

?>
