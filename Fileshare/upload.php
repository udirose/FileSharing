<?php
session_start();
//A lot of this script was adapted from this blogpost https://blog.filestack.com/thoughts-and-knowledge/php-file-upload/
//many variables from said blogpost
$username = $_SESSION["username"];
$fileName = $_FILES['fileinput']['name'];
$fileTmpName  = $_FILES['fileinput']['tmp_name'];
$fileType = $_FILES['fileinput']['type'];
$fileExtension = strtolower(end(explode('.',$fileName)));
$uploadPath = "/home/udirose/filesharePrivate/$username/";
$fileExtensionsAllowed = ['txt','jpeg','jpg','png','xlsx', 'docx'];
$errors = [];

if(isset($_POST['upload'])){

    //copied this block from 330 wiki
    if( !preg_match('/^[\w_\.\-]+$/', basename($fileName)) ){
        echo "Invalid filename. ";
        echo "\n";
        echo "Make sure there are no spaces in the filename or other such characters. ";
        echo "\n";
        echo "Please hit back on your browser now.";
        exit;
    }

    //from said blogpost
    if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not supported/allowed. ";
      }


//thsee if statement headers are from the blogpost
if(empty($errors)){
    if(move_uploaded_file($fileTmpName, $uploadPath.$fileName)){
        echo "File transfer worked!";
        header("Location: mainPage.php");
    } else {
        echo "File transfer did not work...";
        echo "\n";
        echo "Please hit back on your browser now.";
    }
} else {
    echo "There were errors with your upload.";
    //error printing from the blogpost
    foreach ($errors as $error) {
        echo $error . "These are the errors" . "\n";
      }
      echo "Please hit back on your browser now.";
}

}

?>
