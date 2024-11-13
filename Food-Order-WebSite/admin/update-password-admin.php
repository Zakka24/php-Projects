<?php include("partials/menu.php"); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Password</h1>
              
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
                        <td>Current password: </td>
                        <td><input type="password" name="current_password" placeholder="Enter your current password..."></td>
                    </tr>
                    <tr>
                        <td>New password: </td>
                        <td><input type="password" name="new_password" placeholder="Enter your new password..."></td>
                    </tr>
                    
                    <tr>
                        <td>Confirm new password: </td>
                        <td><input type="password" name="confirm_password" placeholder="Confirm the password..."></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Update Password" class="btn-primary" >
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


<?php include("partials/menu.php"); ?>

<?php
    // Check if button is pressed
    if(isset($_POST['submit'])){
        // Check if 'id' is set
        if(isset($_GET['id'])){
            // information taken from the url
            $id = intval($_GET['id']);
            
            // Query to retrieve current full_name and username
            $sql = "SELECT password FROM tbc_admin WHERE id = ?";

            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "i", $id);
                if(mysqli_stmt_execute($stmt)){
                    // Save the result in the variables 'current_password'
                    mysqli_stmt_bind_result($stmt, $current_password_hashed);
                    mysqli_stmt_fetch($stmt);
                }
                mysqli_stmt_close($stmt);
            }

            $current_password= $_POST['current_password'];
            $new_password = $_POST["new_password"];
            $confirm_password = $_POST["confirm_password"];

            if(password_verify($current_password, $current_password_hashed)){
                if($new_password === $confirm_password){
                    // SQL query to update the admin password
                    $sql = "UPDATE tbc_admin SET password = ? WHERE id = ?";
                    
                    // Statement
                    $stmt = mysqli_prepare($conn, $sql);
                    if($stmt){
                        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
                        // Binding the parameters to avoid SQL injection
                        mysqli_stmt_bind_param($stmt, "si", $new_password_hashed, $id);
                        
                        // Execution of the statement
                        if(mysqli_stmt_execute($stmt)){
                            // Create a session variable to display the message
                            $_SESSION['update-password'] = '<div class="success">Admin password updated successfully</div>';
                            header("location:". SITEURL. 'admin/manage-admin.php');
                        }
                        else{
                            $_SESSION['update-password'] = '<div class="error">Failed password update</div>';
                            header("location:". SITEURL. 'admin/manage-admin.php');
                        }
        
                        // Close the statement
                        mysqli_stmt_close($stmt);
                    }
                }
                else{
                    $_SESSION['update-password'] = '<div class="error">Failed to update password. The two passwords does not match. Try Again</div>';
                    header("location:". SITEURL. 'admin/manage-admin.php');
                }
            }
            else{
                $_SESSION['update-password'] = '<div class="error">Failed to update password. The current password is wrong</div>';
                header("location:". SITEURL. 'admin/manage-admin.php');
            }

        }  
        else{
            echo "no id found";
        }
    }
?>