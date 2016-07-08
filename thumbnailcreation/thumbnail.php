<?php
$inputfilename = "IMG_6117.JPG";
$outputfilename = "thumb.jpg";


function imgResize($filename, $width, $height, $crop = true)
{
  $src_image = imagecreatefromjpeg($filename);
//  echo "yay we're resizing";
  $old_x=imageSX($src_image);
  $old_y=imageSY($src_image);
  $thumb_x;
  $thumb_y;
/*  $new_x = $width;
  $new_y = $height;*/
  $new_x = $old_x/2;
  $new_y = $old_y/2;
  
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
  
  return $dst_image;
} 

$output = imgResize($inputfilename, 400, 400, true);
header('Content-Type:image/jpeg');
imagejpeg($output);







?>
