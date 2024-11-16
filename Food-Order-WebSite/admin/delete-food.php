<?php include('partials/menu.php')?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Delete Food</h1>

            <form action="" method="post">
                <p>Are you sure?</p>
                <input type="submit" name="submit" value="Delete Food" class="btn-danger">
            </form>
        </div>
    </div>

<?php include('partials/footer.php')?>

<?php
    if(isset($_POST['submit'])){
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);

            // SQL query to delete the admin
            $sql = "DELETE FROM tal_food WHERE id = ?";
            
            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                // Execution of the statement
                if(mysqli_stmt_execute($stmt)){
                    // Create a session variable to display the message
                    $_SESSION['delete-food'] = '<div class="success">Food deleted successfully</div>';
                    header("location:". SITEURL. 'admin/manage-food.php');
                }
                else{
                    $_SESSION['delete-food'] = '<div class="error">Failed to delete the food</div>';
                    header("location:". SITEURL. 'admin/manage-food.php');
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            }
        }  
        else{
            $_SESSION['delete-food'] = '<div class="error">No id found</div>';
            header("location:". SITEURL. 'admin/manage-food.php');
        }
    }
?>