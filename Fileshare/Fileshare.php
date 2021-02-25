<?php
     session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" href="styles.css">
    <title>FileZara</title>
</head>
<body>
    <h1>FileZara</h1>
    <img src="FileZara.png" alt="FileZara logo" class = "center" style="width:200px;height:200px;">
    <form>
    <div class = "username">
    <h2>Enter your username to get started.</h2><br>
    <input type = "text" id = "username" name = "username"><br><br>
    <button type="submit" name="submitUser" value="submitUser">Go</button><br>
    </div>
    </form>

    <?php
        if (isset($_GET['submitUser'])){
            $_SESSION["username"]=(string)$_GET['username'];

            $username = (string)$_GET['username'];
            $readUsers = fopen("/home/udirose/filesharePrivate/users.txt", "r");
            $invalidLogin = false;
            
            while(!feof($readUsers)){
                
                if(trim(fgets($readUsers)) == (string)$_GET['username']){
                    echo "<p style = 'font-family: avenir; text-align:center;'>Logged in!</p>";
                    $invalidLogin = false;
                    header("Location: mainPage.php");
                    exit;
                } else{
                    $invalidLogin = true;
                }
            }
            if($invalidLogin){
                echo "<p style = 'font-family: avenir; text-align:center;'>Invalid username. Please try again.</p>";
            }

            fclose($readUsers);

        }
    ?>
</body>
</html>