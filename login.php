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
            color: blueviolet;
        }
        .wrapper{
            width: 450px;
            padding: 40px;
        }

    </style>
</head>
<body>
    <?php
    session_start();
    if(isset ($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
        header("location:shop.php");
        exit;
    }

    require_once "Config.php";
    $username=$password="";
    $username_err=$password_err="";
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        if (empty(trim($_POST["username"]))) {
            $username_err="Please enter username";
        } else {
            $username=trim($_POST["username"]);
        }
        if (empty(trim($_POST["password"]))) {
            $password_err="Please enter password";
        } else {
            $password=trim($_POST["password"]);
        }

        if (empty($username_err)&&empty($password_err)&&empty($confirm_password_err)) {
            $sql = "SELECT id,username,password FROM users where username=?";
            if ($stmt=$mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
                $param_username=$username;
                if ($stmt->execute()) {
                    $stmt->store_result();
                }
                if ($stmt->num_rows==1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"]=true;
                            $_SESSION["id"]=$id;
                            $_SESSION["username"]=$username;
                            header(("location:login.php"));
                        } else {
                            $password_err="password is incorrect";
                        }
                    } else {
                        $username_err="no username found";
                    }
                } else {
                    echo "something went wrong please try again";
                }
                $stmt->close();
            }
        }
        $mysqli->close();
    }
    ?>
    <div class="wrapper">
    <h3>Sign In</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="form-group" <?php echo(!empty($username_err)) ? 'has-error':''?>>
<label>User Name</label>
<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
<span class="help-block"><?php echo $username_err?></span>
</div>

<div class="form-group" <?php echo(!empty($password_err)) ? 'has-error':''?>>
<label>Password</label>
<input type="text" name="password" class="form-control" value="<?php echo $password; ?>">
<span class="help-block"><?php echo $password_err?></span>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Login">
</div>
<p>Do Not Have An Account? <a href="index.php">Register Here!</a> </p>
    </form>
</div>
</body>
</html>