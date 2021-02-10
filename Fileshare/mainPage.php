<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" href="styles.css">
    <title>Filezilla 2</title>
</head>
<body>
    <?php
    $username = (string)$_SESSION["username"];
    echo '<h1 style = "font-family:avenir; text-align:center;"> Welcome '.htmlentities($username).'. This is the main page. </h1>';
    ?>
    <form>

    
        <h2>Your files</h2>
        <?php
        // This next block of code is from https://www.w3schools.com/php/func_directory_readdir.asp
            $dir = "/home/udirose/filesharePrivate/$username/";
            if(is_dir($dir)){
                if($dh = opendir($dir)){
                    while (($file = readdir($dh)) !== false){
                        if($file != "." && $file != ".."){
                            echo "<input type = 'radio' name = 'filebutton' id = '$file' value = '$file' style = 'text-align:center; font-family: avenir; user-select: all;'/>". htmlentities($file) . "<br>";
                        } 
                    }
                    closedir($dh);
                }
            }
        ?>
        

        <div class = "action-buttons">
            <button type="submit" name="view" value="view">View</button>
            <button type="submit" name="delete" value="delete">Delete</button><br><br>
            
            
        </div>
    <div class = "share" style = "text-align:center;">
        <label for="sharedwith" style = "font-family:avenir; text-align: center;">Share with user:</label>
        <input type="text" name="sharedwith" id ="sharedwith" style = "font-family:avenir; text-align: center;" />
        <button type="submit" name="share" value="share" style = "font-family:avenir; text-align: center;">Share</button><br><br>
    </div>

    <button type="submit" name="backhome" value="backhome">Logout</button><br><br>
    </form>
    
    <!-- Block to upload file from 330 wiki php-->
    <form enctype="multipart/form-data" action = "upload.php" method = "post">
         <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
         <input type = "file" name = "fileinput" id = "fileinput">
         <button type="submit" name="upload" value="upload">Upload</button>
	
    </form>

    <form>
        
    </form>


<?php

if (isset($_GET['view'])){
    
    $fileToRead = (string)$_GET['filebutton'];
    
    $path = "/home/udirose/filesharePrivate/$username/$fileToRead";
    if(mime_content_type($path) == "text/plain"){
        echo "<h2 style = 'text-align:center;font-family:avenir;'>".htmlentities($fileToRead)."</h2>";
        echo "<br>";
        //Code block comes from "Reading a File Line-by-Line on the PHP 330 Wiki
        $readFile = fopen($path,"r");
        echo "<ul>\n";
        while( !feof($readFile) ){
            printf(fgets($readFile));
            echo "<br>";
        }
        echo "</ul>\n";

        fclose($readFile);
    } else if (mime_content_type($path) == "image/png"){
        $_SESSION["location"] = $path;
        header("Location: openImage.php");
    } else if (mime_content_type($path)=="image/jpg"){
        $_SESSION["location"] = $path;
        header("Location: openImage.php");
    } else if (mime_content_type($path)=="image/jpeg"){
        $_SESSION["location"] = $path;
        header("Location: openImage.php");
    } else if (mime_content_type($path) == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
        //taken from 330 wiki
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);
        header("Content-Type: ".$mime);
        header('content-disposition: inline; filename="'.$fileToRead.'";');
        readfile($path);
    } else if (mime_content_type($path) == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
        //taken from 330 wiki
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);
        header("Content-Type: ".$mime);
        header('content-disposition: inline; filename="'.$fileToRead.'";');
        readfile($path);
    }
}

if (isset($_GET['delete'])){
    $fileToRead = (string)$_GET['filebutton'];
    $path = "/home/udirose/filesharePrivate/$username/$fileToRead";
    if(unlink($path)){
        header("Location: mainPage.php");
        exit;
    }

}

if (isset($_GET['share'])){
    $fileToRead = (string)$_GET['filebutton'];
    if ($fileToRead == "null"){
        $userpath = (string)$_GET['sharedwith'];
        $path = "/home/udirose/filesharePrivate/$username/$fileToRead"; 
        $endPath = "/home/udirose/filesharePrivate/$userpath/$fileToRead";       
        shell_exec("cp -r $path $endPath");
    } else {
        echo "<p style = 'font-family: avenir; text-align:center;'>Please select a file!</p>";
    }
    
}

if (isset($_GET['backhome'])){
    header("Location: Fileshare.php");
    session_destroy();
    exit;
}
?>

</body>
</html>