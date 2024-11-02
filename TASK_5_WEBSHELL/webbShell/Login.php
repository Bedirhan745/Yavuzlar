<?php

session_start();
$correct = "yavuzshell";
$message = "şifre:yavuzshell";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    if($password === $correct) {
        $_SESSION['logged'] = true;
      
    
        header("Location: YavuzShell.php");
        exit();
    }else {
        $message;
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/log.css">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="POST">

    <div class="container">
        <input type="password" id="password" name="password" placeholder="şifre:yavuzshell" required>
        <button type="submit">Login</button>
    </div>
        
    </form>

    <?php
    if($message) {
      echo "<h2>$message;</h2> " ;
}
 ?>
    
</body>
</html>