<?php
 
session_start();

if ( isset($_SESSION["login"])){
    header('location: dashboard.php');
    exit;
}
require('functions.php');

if (isset($_POST["login"])) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $con->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // cek username
        if ($result->num_rows === 1) {
            // cek password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                
                $_SESSION["login"] = true;
                $_SESSION['roles'] = $user['roles'];
                 
                header("Location: dashboard.php");
                exit;
            } else {
                $msg = "Password salah!";
            }
        } else {
            $msg = "Username tidak ditemukan!";
        }

        $stmt->close();
    } else {
        $msg = "Username dan Password harus diisi!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css2/styleLogin.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h1 class="text-center mb-4" style="font-family: 'arial', sans-serif; font-size: 2rem; color: #333;">KERKHOF PARKING MANAGEMENT</h1>
                    <!-- Tampilkan pesan kesalahan jika ada -->
                    <?php if (isset($msg)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

