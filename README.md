## Important notes
+ Use the NEWEST release of CamanJS: the one from github.  Because 4.1.1 and the CDN version have a bug in Caman.revert(true)
+ Must transfer image from CamanJS to php through AJAX, and must reconfigure base64 because it contains '/', ';', ':', '+', '/'
+ It is difficult to deal with thumbnails because there is a specific size (in this case, 604, 270) that is determined by the theme, where the url will vary.
  - Need to figure out how to find ID for an image once submitted. (done)
  - (done) Figure out how to get wordpress to actually recognize the existence of the image (probably has to do with wp\_postmeta)
+ Alter base64 stuff to deal with all restricted characters.
+ Need to say something/go somewhere when the image is successfully uploaded

##

####Currently...
+ begin.php -> second.php -> w/acceptImages.php (through ajax)
  - begin.php is only a prompt to upload an image
  - second.php:
    + begins by copying the image from /tmp (on server) to [wordpresshome]/wp-content/uploads/year/month/_filename.ext_
    + It then allows for camanjs to edit the image.
    + Once the image is edited, it converts it to base64 ascii characters, which are modified and sent through ajax post request to wordpress/acceptImages.php
  - acceptImages.php (using wordpress functions):
    + Deals with all the info that just got submitted
    + Creates necessary thumbnails
    + Add image to mysql databases so that wordpress knows that it exists and is an image
    + Alter the photo gallery to include that image (updates actually don't matter; current code will add images without reverting to previous versions)
