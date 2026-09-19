<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$namalengkap = $username = $password = $confirm_password = "";
$namalengkap_err = $username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "masukkan username.";
    } else{

        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE username = :username";
        if($stmt = $pdo->prepare($sql)){

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "username ini telah ada.";
                } else{
                    $username = trim($_POST['username']);
                }

            } else{
                echo "Oops! ada yang salah. Harap coba kembali.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "masukkan password.";
    } elseif(strlen(trim($_POST['password'])) < 4){
        $password_err = "Password minimal 4 karakter.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err = 'Konfirmasi password.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password tidak cocok.';
        }
    }

    // Validate nama lengkap
    $input_namalengkap = trim($_POST["namalengkap"]);
    if(empty($input_namalengkap)){
        $namalengkap_err = 'masukkan namalengkap';
    } else{
        $namalengkap = $input_namalengkap;
    }

    // Check input errors before inserting in database
    if(
        empty($namalengkap_err) &&
        empty($username_err) &&
        empty($password_err) &&
        empty($confirm_password_err)
    ){
        // Prepare an insert statement
    $sql = "INSERT INTO user (namalengkap, username, password)
            VALUES (:namalengkap, :username, :password)";

    if($stmt = $pdo->prepare($sql)){

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':namalengkap', $param_namalengkap, PDO::PARAM_STR);
        $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);

        // Set parameters
        $param_username = $username;

        // Creates a password hash
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Set parameters
        $param_namalengkap = $namalengkap;

            // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            header("location: login.php"); //dia mencari file login.php yang belum dibuat
        } else{
            echo "Something went wrong. Please try again later.";
        }
    
    }
    // Close statement
    unset($stmt);
}
}
// Close connection
unset($pdo);
?>

<!-- batas kode php -->
<!-- kode html dibawah ini adalah hasil copy-paste "register.html" -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register user</title>

<style>
.login {
border: 1px solid rgb(250, 219, 219);
width: 450px;
height: 650px;
background: url('../image-slide/bawakaraeng 1.jpg.jpeg');
color: white;
border-radius: 20px;
box-shadow: 0px 0px 20px rgba(0, 0, 0, .75);
background-size: cover;
background-position: center;
overflow: hidden;
}

form {
display: block;
box-sizing: border-box;
padding: 40px;
width: 100%;
height: 100%;
backdrop-filter: brightness(60%);
flex-direction: column;
display: flex;
gap: 5px;
}

h1 {
    font-weight: normal;
    font-size: 28px;
    text-shadow: 0px 0px 2px rgba(0, 0, 0, 5);
    margin-bottom: 60px;
    text-align: center;
}

label {
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 2px;
    padding-left: 10px;
}

input {
    background: rgba(255, 255, 255, 0.3);
    height: 40px;
    line-height: 40px;
    border-radius: 20px;
    padding: 0px 20px;
    border: none;
    margin-bottom: 20px;
    color: white;
}

button {
    background: rgba(45, 126, 231);
    height: 45px;
    line-height: 40px;
    border-radius: 30px;
    border: none;
    margin: 10px 0px;
    color: white;
    font-size: 15px;
}

</style>

</head>

<body>
<!-- ikuti kode dibawah ini -->
    <div class="login">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <h1>REGISTER</h1>
            <div <?php echo (!empty($namalengkap_err)) ? 'has-error' : ''; ?>>
                <label>Nama Lengkap</label>
                <input type="text" name="namalengkap" placeholder="Nama lengkap">
                <span><?php echo $namalengkap_err; ?></span>
            </div>

            <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username">
            <span><?php echo $username_err; ?></span>
    </div>

    <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password">
            <span><?php echo $password_err; ?></span>
    </div>

   <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
            <label>Konfirmasi password</label>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password">
            <span><?php echo $confirm_password_err; ?></span>
   </div>

           <button type="submit">Register</button>
           <botton type="reset"><a href="login.php">batal</a></botton>
</form>

</div>

    
</body>
</html>