<?php include('partials/menu.php')?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Delete Category</h1>

            <form action="" method="post">
                <p>Are you sure?</p>
                <input type="submit" name="submit" value="Delete Category" class="btn-danger">
            </form>
        </div>
    </div>


<?php include('partials/footer.php')?>

<?php
    if(isset($_POST['submit'])){
        if(isset($_GET['id'])){
            $id = intval($_GET['id']);

            // SQL query to delete the admin
            $sql = "DELETE FROM tbl_category WHERE id = ?";
            
            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                // Execution of the statement
                if(mysqli_stmt_execute($stmt)){
                    // Create a session variable to display the message
                    $_SESSION['delete-category'] = '<div class="success">category deleted successfully</div>';
                    header("location:". SITEURL. 'admin/manage-category.php');
                }
                else{
                    $_SESSION['delete-category'] = '<div class="error">Failed to delete the category</div>';
                    header("location:". SITEURL. 'admin/manage-category.php');
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            }
        }  
        else{
            $_SESSION['delete-category'] = '<div class="error">No id found</div>';
            header("location:". SITEURL. 'admin/manage-category.php');
        }
    }
?>