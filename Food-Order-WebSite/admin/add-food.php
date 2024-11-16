<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
    
        <br>

        <?php 
            // Message for adding a new category
            if(isset($_SESSION['add-food'])){
                echo $_SESSION['add-food']; // Display session message
                unset($_SESSION['add-food']); // Remove session message
            }
            
            // Message for upload error
            if(isset($_SESSION['upload-food'])){
                echo $_SESSION['upload-food']; // Display session message
                unset($_SESSION['upload-food']); // Remove session message
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
                    <td>Description:</td>
                    <td><input type="text" name="description" placeholder="Insert food description..."></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" min='0' step="0.01" placeholder="Insert Food Price..."></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td><input type="text" name="category" placeholder="Insert Category Name..."></td>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-primary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>


<?php include('partials/footer.php');?>


<?php
    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image_name = '';
        $category = $_POST['category'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        // Check if all the fields are not empty (image is optional)
        if(empty($title) || empty($description) || empty($price) || empty($category) || empty($featured) || empty($active)){
            $_SESSION['add-food'] = '<div class="error">Insert all the info required</div>';
            header("location:".SITEURL.'admin/add-food.php');
            die();
        }

        // Check if image field is not empty
        if(!empty($_FILES['image']['name'])){
            $image_name = $_FILES['image']['name']; // Image name
            $source_path = $_FILES['image']['tmp_name']; // Source path of the image
            $destination_path = "../images/category/".$image_name; // Where i want to upload my image
            $upload = move_uploaded_file($source_path, $destination_path); // Move my image from source to destination

            // Check if the upload failed
            if(!$upload){
                $_SESSION['upload-food'] = '<div class="error">Failed to upload category image</div>';
                header("location:".SITEURL.'admin/add-category.php');
                die();
            }
        }

        // SQL to check if the category exists
        $sql_check_if_exists = "SELECT id FROM tbl_category WHERE title = ?;";
        // Statement to check if already exists
        $stmt_exists = mysqli_prepare($conn, $sql_check_if_exists);

        if($stmt_exists){
            // Binding the parameters to avoid SQL injection
            mysqli_stmt_bind_param($stmt_exists, "s", $category);
            if(mysqli_stmt_execute($stmt_exists)){
                // Save the result in the variables 'category_db'
                mysqli_stmt_bind_result($stmt_exists, $category_id);
                mysqli_stmt_fetch($stmt_exists);
            }
            mysqli_stmt_close($stmt_exists);

            // Check if category already exists in db
            if(empty($category_id)){
                $_SESSION["add-food"] = "<div class='error'> This category doesn't exists </div>";
                header("location:".SITEURL.'admin/add-food.php');
            }
            else{
                // SQL to add fod attributes
                $category_id = intval($category_id);
                $sql_add = "INSERT INTO tal_food (title, description, price, image_name, category_id, featured, active) VALUES (?, ?, ?, ?, ?, ?, ?);";
                // Statement to add
                $stmt_add = mysqli_prepare($conn, $sql_add);
                if($stmt_add){
                    // Binding the parameters to avoid SQL injection
                    mysqli_stmt_bind_param($stmt_add, "ssdsiss", $title, $description, $price, $image_name, $category_id, $featured, $active);
                    if(mysqli_stmt_execute($stmt_add)){
                        $_SESSION['add-food'] = '<div class="success">Food added successfully</div>';
                        header("location:".SITEURL.'admin/manage-food.php');
                    }
                    else{
                        $_SESSION['add-food'] = '<div class="error">Failed to add food</div>';
                        header("location:".SITEURL.'admin/add-food.php');
                    }
                    // Close the statement
                    mysqli_stmt_close($stmt_add);
                }
                else{
                    $_SESSION['add-food'] = '<div class="error">Failed to add food</div>';
                    header("location:".SITEURL.'admin/add-food.php');
                }
            }
        }
    }
?>