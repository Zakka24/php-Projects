<?php include("partials/menu.php");?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Admin</h1>
              
            <br>
            <?php 
                // Check if sessione message is there
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }
            ?>
            <br> <br> <br>

            <form action="" method="post">
                <table class="tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td><input type="text" name="full_name" placeholder="Enter your name..."></td>
                    </tr>
                    
                    <tr>
                        <td>Username: </td>
                        <td><input type="text" name="username" placeholder="Enter your username..."></td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="password" placeholder="Enter your password..."></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary" >
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

<?php include("partials/footer.php");?>


<?php 
    // Check if button is pressed
    if(isset($_POST["submit"])){
        
        // Get data from the form
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];
        $password = md5($_POST["password"]); // password encryption

        
        // SQL query to save data into database
        $sql = "INSERT INTO tbc_admin (full_name, username, password) VALUES (?, ?, ?)";

        // Statement
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            // Binding of the parameters to avoid SQL injection
            mysqli_stmt_bind_param($stmt, "sss", $full_name, $username, $password);

            // Execution of the statement
            if(mysqli_stmt_execute($stmt)){
                // create a sessione variabile to display the message
                $_SESSION['add'] = 'Admin added succesfully';
                header("location:". SITEURL. 'admin/manage-admin.php');
            }
            else{
                $_SESSION['add'] = 'Failed to add admin: '. mysqli_stmt_error($stmt);
                header("location:". SITEURL. 'admin/add-admin.php');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
        else{
            $_SESSION['add'] = 'Failed to add admin' . mysqli_error($conn);
            header("location:". SITEURL. 'admin/add-admin.php');
        }

        mysqli_close($conn);
    }



?>