<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman sukses | aisyah</title>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <a href="logout.php" class="btn btn-warning">Log Out atau Keluar</a>
        
        <div>
            <h4>Assalamu'alaikum warahmatullahi wabarakatuh...</h4>
            
            <h1 class="text-danger">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </h1>
            
            <h3>
                Selamat Datang di Pemrograman Web Kelas XI PPLG<br>
            </h3>
            
            <a href="#" class="btn btn-success">Link-1</a>
            <a href="#" class="btn btn-primary">Link-2</a>
            <a href="#" class="btn btn-secondary">Link-3</a>
        </div>
        
    </div>

</body>
</html>