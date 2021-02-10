<?php
session_start();
$path = $_SESSION["location"];
//taken from 330 wiki
$finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);
        header("Content-Type: ".$mime);
        header('content-disposition: inline; filename="'.$fileToRead.'";');
        readfile($path);
?>