<!-- tuliskan kode dibawah ini  -->
<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
// kode ini menghubungkan ke halaman index.html pada tugas 1 dan 2
header("location:../carousel/index.html"); 
exit;
?>