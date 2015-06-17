<?
//require_once( dirname( __FILE__ ) . '/wp-admin/admin.php' );
require_once('wp-config.php');
require_once('wp-includes/functions.php');
require_once('wp-includes/media.php');
require_once( 'wp-includes/option.php' );
require_once( 'wp-includes/post.php' );
require_once( 'wp-content/themes/twentythirteen/functions.php' );
//$postnine = get_post(9);
//$orig_content=$postnine->post_content;
//$postnine->post_content="[gallery ids=\"11,12,13,14,16,21\"]\n\nabc";
//wp_update_post($postnine);

//////////
//$imageLocation=ABSPATH ."/wordpress/wp-content/uploads/2015/06/631px-Barenmutter_Junges_3_2004-11-17.jpg";

$imageLocation="wp-content/uploads/2015/06/631px-Barenmutter_Junges_3_2004-11-17.jpg";
$imageDirectory="wp-content/uploads/2015/06/";
$imageName = "631px-Barenmutter_Junges_3_2004-11-17"; //without extention
$imageExtension = "jpg";
$imageDescription="A polar bear resides in a Canadian national park";
$imageCaption="A Polar Bear";
$imageMimeType="image/jpeg";
//////////

$iarray;

function ce_get_image_sizes()
{
  $ce_sizes = array();
  foreach(array('thumbnail', 'medium') as $ce_size)
  {
    $ce_sizes[ $ce_size ]['width'] = get_option( $ce_size . '_size_w' );
    $ce_sizes[ $ce_size ]['height'] = get_option( $ce_size . '_size_h' );
    $ce_sizes[ $ce_size ]['crop'] = get_option( $ce_size . '_crop' );
  }
  $ce_sizes['sixzerofour'] = array('width' => 604, 'height' => 270, 'crop'=>true);
  return $ce_sizes;
}

$requiredSizes = ce_get_image_sizes();

$image = wp_get_image_editor($imageLocation);
if( ! is_wp_error($image) )
{
  $iarray = $image->multi_resize($requiredSizes);
}
else
{
  echo "error";
}

$files = array ($iarray['thumbnail']['width'], $iarray['medium']['file'], $iarray['large']['file']);
//$files = array("a","b","c");

//before adding to database, must first:
//save in ./wp-content/uploads/yyyy/mm/
//save copies in 150x150, 300x___, 604x___


$UploadPicture = array(
//'ID'		=> {}, // leave empty to specify that this is a NEW
  'post_content'=> $imageDescription,
  'post_name' => strtolower($imageName),
  'post_title' => $imageName,
  'post_status' => 'inherit',
  'post_type' => 'attachment',
  'post_author'	=> 1,
  'post_excerpt'	=> $imageCaption,
  'post_date'	=> date('Y-m-d H:i:s'),
  'post_date_gmt'	=> date('Y-m-d H:i:s'),
  'post_mime_type'	=> $imageMimeType
);

wp_insert_post($UploadPicture);
$imagePost = get_page_by_title($imageName, OBJECT, 'attachment');
$importantID = $imagePost->ID;

$postnine = get_post(9);
$orig_content=$postnine->post_content;
$postnine->post_content="[gallery ids=\"11,12,13,14,16,21," . $importantID . "\"]\n\nabc";
wp_update_post($postnine);

?>


<html>
<head><title>Using Wordpress stuff</title>
<script type="text/javascript">
</script>
<style>
</style>
</head>
<body>

<textarea id="phpstuff" style="width:600px;height:400px;"><?php echo $files[0] . "\n" . $files[1] . "\n" . $files[2] . "\n" . $importantID; ?></textarea>

</body>
</html>
