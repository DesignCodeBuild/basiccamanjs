## Important notes
+ Use the NEWEST release of CamanJS: the one from github.  Because 4.1.1 and the CDN version have a bug in Caman.revert(true)
+ Must transfer image from CamanJS to php through AJAX, and must reconfigure base64 because it contains '/', ';', ':', '+', '/'
+ wordpress/wp-admin/TEST.php will currently make thumbnails for specific images.
  - This line: wp-content/themes/twentythirteen/functions.php: set\_post\_thumbnail\_size( 604, 270, true );
  - It is difficult because there is a specific size (in this case, 604, 270) that is determined by the theme, where the url will vary.
  - Need to figure out how to find ID for an image once submitted. (done)
  - Figure out how to get wordpress to actually recognize the existence of the image (probably has to do with wp\_postmeta)
  - Probably look at [wp\_insert\_attachment](https://codex.wordpress.org/Function_Reference/wp_insert_attachment)
