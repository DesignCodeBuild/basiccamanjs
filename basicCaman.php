<?php

  // Takes mime type and returns extention (png or jpg)
  // Returns (false) if the extention is unsupported
  //    Otherwise, it returns the extention ("png" or "jpg")
  function ce_find_extention($ce_image_type)
  {
    $ce_extention;

    if($ce_image_type == "image/jpg" || $ce_image_type== "image/jpeg")
      $ce_extention = "jpg";

    if($ce_image_type == "image/png")
      $ce_extention = "png";

    if($ce_image_type != "image/jpg" && $ce_image_type != "image/jpeg" && $ce_image_type != "image/png")
      $ce_extention = false;

    return $ce_extention;
  }

  // Takes extention and returns mime type ("image/png" or "image/jpg"
  // Returns (false) if the extention is unsupported.
  function ce_create_mime_type($ce_extention)
  {
    $ce_mime_type;

    if($ce_extention == "png")
      $ce_mime_type = "image/png";

    if($ce_extention == "jpeg" || $ce_extention == "jpg")
      $ce_mime_type = "image/jpeg";

    if($ce_extention != "jpeg" && $ce_extention != "jpg" && $ce_extention != "png")
      $ce_mime_type = false;
    return $ce_mime_type;
  }

  function ce_random_string()
  {
    $hash = substr(base_convert(hash("md5", date("d m Y G i s u"), false), 16, 32), 0, 11);
    return $hash;
  }
  
  // Using the uploads/year/month format, this will return the current directory
  //   or create it if it doesn't exist.
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
  }

?>
