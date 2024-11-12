<?php 
    include("../config/constants.php"); 
?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1> <br> <br>
            <br><br>

            <?php 
                if(isset($_SESSION['credentials-not-given'])){
                    echo $_SESSION['credentials-not-given'];
                    unset($_SESSION['credentials-not-given']);
                }

                if(isset($_SESSION['user-not-found'])){
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['wrong-password'])){
                    echo $_SESSION['wrong-password'];
                    unset($_SESSION['wrong-password']);
                }

                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

            <br><br>
            <form action="" method="post" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username..."> <br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter password..."> <br><br>
                <input type="submit" name="submit" value="Login" class="btn-primary"> <br><br>
            </form>
            
            <p class="text-center">Created By - <a href="#">Zakaria Aoukaili</a></p>
        </div>
    </body>
</html>


<?php 
    if(isset($_POST['submit'])){
        echo "button pressed <br>";
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username) || empty($password)){
            $_SESSION["credentials-not-given"] = "<div class='error text-center'> Insert username and password </div>";
            header("location:". SITEURL. 'admin/login.php'); 
        }
        else{
            // Query
            $sql = "SELECT username, password FROM tbc_admin WHERE username = ?";
            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                 // Binding the parameters to avoid SQL injection
                 mysqli_stmt_bind_param($stmt, "s", $username);
                 if(mysqli_stmt_execute($stmt)){
                     // Save the result in the variables 'current_password'
                     mysqli_stmt_bind_result($stmt, $username_db, $password_db);
                     mysqli_stmt_fetch($stmt);
                 }
                 mysqli_stmt_close($stmt);

                 // Check if the user exists
                 if(empty($username_db)){
                    $_SESSION["user-not-found"] = "<div class='error text-center'> Incorrect username </div>";
                    header("location:". SITEURL. 'admin/login.php'); 
                 }
                 else{
                    if(password_verify($password, $password_db)){
                        $_SESSION["user-logged"] = "<div class='success'> Successfull login </div>";
                        $_SESSION["user"] = $username;
                        
                        header("location:". SITEURL. 'admin/index.php'); 
                    }
                    else{
                        $_SESSION["wrong-password"] = "<div class='error text-center'> Incorrect password </div>";
                        header("location:". SITEURL. 'admin/login.php'); 
                    }
                 }
            }
        }
    }

    mysqli_close($conn);

?>