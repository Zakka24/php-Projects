<?php include("partials/menu.php"); ?>

<div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>
              
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
                        <td><input type="text" name="full_name" placeholder="Enter your new name..."></td>
                    </tr>
                    
                    <tr>
                        <td>Username: </td>
                        <td><input type="text" name="username" placeholder="Enter your new username..."></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Update Admin values" class="btn-secondary" >
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
            $sql = "SELECT full_name, username FROM tbc_admin WHERE id = ?";

            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "i", $id);
                if(mysqli_stmt_execute($stmt)){
                    // Save the result in the variables 'current_full_name' and 'current_username'
                    mysqli_stmt_bind_result($stmt, $current_full_name, $current_username);
                    mysqli_stmt_fetch($stmt);
                }
                mysqli_stmt_close($stmt);
            }
            
            $new_full_name = $_POST["full_name"];
            $new_username = $_POST["username"];

            if(empty($new_full_name)){
                $new_full_name = $current_full_name;
            }
            if(empty($new_username)){
                $new_username = $current_username;
            }

            // SQL query to update the admin info
            $sql = "UPDATE tbc_admin SET full_name = ?, username = ? WHERE id = ?";
            
            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "ssi", $new_full_name, $new_username, $id);
                
                // Execution of the statement
                if(mysqli_stmt_execute($stmt)){
                    // Create a session variable to display the message
                    $_SESSION['update'] = 'Admin information updated successfully';
                    header("location:". SITEURL. 'admin/manage-admin.php');
                }
                else{
                    $_SESSION['update'] = 'Failed information update';
                    header("location:". SITEURL. 'admin/manage-admin.php');
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            }
        }  
        else{
            echo "no id found";
        }
    }

    // Close connection to MySQL
    mysqli_close($conn);
?>