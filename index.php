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
    require_once "Config.php";
    $username=$password=$confirm_password="";
    $username_err=$password_err=$confirm_password_err="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty(trim($_POST["username"]))){
            $username_err="Please enter username";
        }else{
            $sql = "SELECT id FROM users WHERE username=?";
            if($stmt= $mysqli->prepare($sql)){
                $stmt->bind_param("s",$param_username);
                $param_username=trim($_POST["username"]);
                if($stmt->execute()){
                    $stmt->store_result();
                if($stmt->num_rows==1){
                    $username_err= "This username is already taken";
                }else{
                    echo "something went wrong try again!";
                }
                $stmt->close();
                }
            }
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter password";
            }elseif(strlen(trim($_POST["password"]))<8){
                $password_err="please enter atleast 8 characters";
            }else{
                $password=trim($_POST["password"]);
            }
            if(empty(trim($_POST["confirm_password"]))){
                $confirm_password_err="please enter same password";
            }else{
                $confirm_password=trim($_POST["confirm_password"]);
            if(empty($password_err)&&($password!=$confirm_password)){
                $confirm_password_err="password didnot match";
            }
            }
            if(empty($username_err)&&empty($password_err)&&empty($confirm_password_err)){
                $sql = "INSERT INTO users(username,password) VALUES (?,?)";
                if($stmt=$mysqli->prepare($sql)){
                    $stmt->bind_param("ss", $param_username, $param_password);
                    $param_username=$username;
                    $param_password=password_hash($password, PASSWORD_DEFAULT);
                    if($stmt->execute()){
                        header("loaction: login.php");
                    }else{
                        echo "something went wrong please try again";
                    }
                    $stmt->close();
                }
            }
            $mysqli->close();
            
        }
    }
    ?>
<div class="wrapper">
    <h3>Sign Up</h3>
    <p>Create Your Account</p>
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

<div class="form-group" <?php echo(!empty($confirm_password_err)) ? 'has-error':''?>>
<label>Confirm Password</label>
<input type="text" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
<span class="help-block"><?php echo $confirm_password_err?></span>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" value="submit">
    <input type="reset" class="btn btn-success" value="reset">
</div>
<p>Already Have An Account? <a href="login.php">Login Here!</a> </p>
    </form>
</div>
</body>
</html>