<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{
            font: 14px sans-serif;
            text-align: center;
            color: blueviolet;
        }
    </style>
</head>
<body>
    <?php
session_start();
if(isset($_SESSION["logedin"])|| $_SESSION["loggedin"]!=true){
    header("location:login.php");
    exit;
}
?>
<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> Welcome to the landing page </h1>
</div>
<p><a href="logout.php" class="btn btn-danger">Signout your account</a></p>
</body>
</html>