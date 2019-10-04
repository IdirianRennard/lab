<link rel="stylesheet" href="https://code.jquery.com/ui/jquery-ui-git.css" >
<script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="css/ui_mod.css">
<body class='upload'>
<?php


$target_file = 'paper.jpg';
$uploadOk = 1;
$imageFileType = strtolower( pathinfo( $target_file , PATHINFO_EXTENSION ) );

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";

} else {
  if ( move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"], $target_file ) ) {
    echo "<div id='progressbar'><center><div class='progress-label'>Loading...</div></center></div>";
  } else {
    echo "Sorry, there was an error uploading your file. <br><br>";
    echo "<a href='./'>Return Home</a>";
  }
}
?>
</body>