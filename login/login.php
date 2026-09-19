<?php

session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
  
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        // echo "tes";
        // die;
        $sql = "SELECT username, password FROM user WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Set parameters
            $param_username = $username;

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // echo $stmt->rowCount();
                // die;
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                       // var_dump

                        $hashed_password = $row['password'];
                        // echo $hashed_password;
                        // $data =password_verify($password, $hashed_password);
                        // echo "<br>";
                        //  echo "ini data " .$data;
                        // echo "<br>";
                        //  echo "ini data " .$password;

                      //  die;
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session and save the username to the session
                            $_SESSION["username"] = $username;
                            // Redirect to success page
                            header("Location: sukses.php");
                            exit;
                        } else {
                            // Password is not valid
                            $password_err = "Password anda salah.";
                        }
                    }
                } else {
                    // Username doesn't exist
                    $username_err = "Anda belum memiliki username.";
                }
            } else {
                echo "Oops! Ada yang salah. Harap coba lagi.";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.kotak {
            width: 100%;
            height: 100vh;
            backdrop-filter: brightness(40%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login {
            border: 1px solid rgb(250, 219, 219);
            width: 350px;
            height: 500px;
            background: url('../image-slide/bawakaraeng 1.jpg.jpeg');
            background-size: cover;
            background-position: center;
            color: white;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.75);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 20px;
        }

        h1 {
            font-weight: normal;
            font-size: 28px;
            text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.5);
            margin-bottom: 60px;
            text-align: center;
        }

        h4 {
            font-weight: normal;
            font-size: 20px;
            text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        label {
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 2px;
            padding-left: 10px;
            display: block;
            margin-bottom: 5px;
        }

        input {
            background: rgba(255, 255, 255, 0.1);
            height: 40px;
            line-height: 40px;
            border-radius: 20px;
            padding: 0px 20px;
            border: none;
            margin-bottom: 20px;
            color: white;
            width: 100%;
        }

        button {
            background: rgba(45, 126, 231, 1);
            height: 45px;
            line-height: 40px;
            border-radius: 30px;
            border: none;
            margin: 10px 0px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
        }

        a:link {
            display: block;
            text-align: center;
            color: white;
            text-decoration: none;
            margin-top: 10px;
        }

        .has-error input {
            border: 1px solid red;
        }

        span {
            color: #ff6b6b;
            font-size: 12px;
            padding-left: 10px;
            margin-top: -15px;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="kotak">
    <div class="login">
        <form action="login.php" method="post">
            <h1>LOGIN</h1>
            
            <div class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>USERNAME</label>
                <input type="text" name="username" placeholder="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>

            <div class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="password">
                <span><?php echo $password_err; ?></span>
            </div>

            <button type="submit">SUBMIT</button>
            <button type="button"><a href="register.php">REGISTER</a></button>
        </form>
    </div>
</body>
</html>