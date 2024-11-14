<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
    
        <br>

        <?php 
            // Message for adding a new category
            if(isset($_SESSION['add-category'])){
                echo $_SESSION['add-category']; // Display session message
                unset($_SESSION['add-category']); // Remove session message
            }
            
            // Message for upload error
            if(isset($_SESSION['upload-category'])){
                echo $_SESSION['upload-category']; // Display session message
                unset($_SESSION['upload-category']); // Remove session message
            }
        ?>

        <br> <br> <br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Insert Category title..."></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-primary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>


<?php include('partials/footer.php');?>


<?php
    if(isset($_POST['submit'])){
        $category_title = $_POST['title'];
        $is_featured = $_POST['featured'];
        $is_active = $_POST['active'];
        $image_name = '';

        // Check if all the fields are not empty (image is optional)
        if(empty($category_title) || empty($is_featured) || empty($is_active)){
            $_SESSION['add-category'] = '<div class="error">Insert all the info required</div>';
            header("location:".SITEURL.'admin/add-category.php');
            die();
        }

        // Check if image field is not empty
        if(!empty($_FILES['new_image_name']['name'])){
            $image_name = $_FILES['image']['name']; // Image name
            $source_path = $_FILES['image']['tmp_name']; // Source path of the image
            $destination_path = "../images/category/".$image_name; // Where i want to upload my image
            $upload = move_uploaded_file($source_path, $destination_path); // Move my image from source to destination

            // Check if the upload failed
            if(!$upload){
                $_SESSION['upload-category'] = '<div class="error">Failed to upload category image</div>';
                // header("location:".SITEURL.'admin/add-category.php');
                die();
            }
        }

        // SQL to check if te category already exists
        $sql_check_if_exists = "SELECT title FROM tbl_category WHERE title = ?;";
        // Statement to check if already exists
        $stmt_exists = mysqli_prepare($conn, $sql_check_if_exists);

        if($stmt_exists){
            // Binding the parameters to avoid SQL injection
            mysqli_stmt_bind_param($stmt_exists, "s", $category_title);
            if(mysqli_stmt_execute($stmt_exists)){
                // Save the result in the variables 'category_db'
                mysqli_stmt_bind_result($stmt_exists, $category_db);
                mysqli_stmt_fetch($stmt_exists);
            }
            mysqli_stmt_close($stmt_exists);

            // Check if category already exists in db
            if($category_db === $category_title){
                $_SESSION["add-category"] = "<div class='error'> This category already exists </div>";
                header("location:".SITEURL.'admin/add-category.php');
            }
            else{
                // SQL to add category attributes
                $sql_add = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES (?, ?, ?, ?);";
                // Statement to add
                $stmt_add = mysqli_prepare($conn, $sql_add);
                if($stmt_add){
                    // Binding the parameters to avoid SQL injection
                    mysqli_stmt_bind_param($stmt_add, "ssss", $category_title, $image_name, $is_featured, $is_active);
                    if(mysqli_stmt_execute($stmt_add)){
                        $_SESSION['add-category'] = '<div class="success">Category added successfully</div>';
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                    else{
                        $_SESSION['add-category'] = '<div class="error">Failed to add category</div>';
                        header("location:".SITEURL.'admin/add-category.php');
                    }
                    // Close the statement
                    mysqli_stmt_close($stmt_add);
                }
                else{
                    $_SESSION['add-category'] = '<div class="error">Failed to add category</div>';
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }
        }
    }
?>