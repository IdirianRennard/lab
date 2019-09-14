<?php
$target_file = 'paper.jpg';
$uploadOk = 1;
$imageFileType = strtolower( pathinfo( $target_file , PATHINFO_EXTENSION ) );
// Check if image file is a actual image or fake image
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
// if everything is ok, try to upload file
} else {
    if ( move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file ) ) {
      echo "<style>
        .container {
          height: 200px;
          position: relative;
        }

        .center {
          margin: 0;
          position: absolute;
          top: 25%;
          left: 25%;
          -ms-transform: translateY(-25%, -25%);
          transform: translateY(-25%, -25%);
        }
        </style>";
      echo "<div class='center'><img src='loading.gif'></div>";
      header( "refresh: 4 ; URL= reset.php" );
    } else {
      echo "Sorry, there was an error uploading your file. <br><br>";
      echo "<a href='reset.php'>Return Home</a>";
    }
}
?>
