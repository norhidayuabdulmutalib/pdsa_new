<?PHP

// this script zips up a directory (on the fly) and delivers it
// C.Kaiser 2002
// No Copyright, free to use.

  // get the filename of this php file without extension.
  // that is also the directory to zip and the name of the
  // zip file to deliver
  $filename_no_ext=basename($_SERVER['SCRIPT_FILENAME'], ".php"); 

  // we deliver a zip file
  header("Content-Type: archive/zip");

  // filename for the browser to save the zip file
  header("Content-Disposition: attachment; filename=$filename_no_ext".".zip");

  // get a tmp name for the .zip
  $tmp_zip = tempnam ("tmp", "tempname") . ".zip";

  // zip the stuff (dir and all in there) into the tmp_zip file
  `zip -r $tmp_zip $filename_no_ext`;
 
  // calc the length of the zip. it is needed for the progress bar of the browser
  $filesize = filesize($tmp_zip);
  header("Content-Length: $filesize");

  // deliver the zip file
  $fp = fopen("$tmp_zip","r");
  echo fpassthru($fp);

  // clean up the tmp zip file
  `rm $tmp_zip `;
?>