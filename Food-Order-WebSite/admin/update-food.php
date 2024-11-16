<?php include("partials/menu.php"); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
              
            <br>
            <?php 
                // Check if sessione message is there
                if(isset($_SESSION['update-food'])){
                    echo $_SESSION['update-food']; // Display session message
                    unset($_SESSION['update-food']); // Remove session message
                }
            ?>
            <br> <br> <br>

            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>New Title: </td>
                        <td><input type="text" name="new_title" placeholder="Enter the new title..."></td>
                    </tr>
                    
                    <tr>
                        <td>New Description: </td>
                        <td><input type="text" name="new_description" placeholder="Enter the new description..."></td>
                    </tr>
                    
                    <tr>
                        <td>New Price: </td>
                        <td><input type="number" name="new_price" placeholder="Enter the new price..."></td>
                    </tr>
                    
                    <tr>
                        <td>New Image: </td>
                        <td><input type="file" name="new_image_name"></td>
                    </tr>
                    
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="new_featured" value="Yes"> Yes
                            <input type="radio" name="new_featured" value="No"> No
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="new_active" value="Yes"> Yes
                            <input type="radio" name="new_active" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Update Food" class="btn-primary" >
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>


<?php include("partials/footer.php"); ?>

<?php
    // Check if button is pressed
    if(isset($_POST['submit'])){
        // Check if 'id' is set
        if(isset($_GET['id'])){
            // information taken from the url and casting to int
            $id = intval($_GET['id']);
            
            // Query to retrieve current title, image, featured, active attributes
            $sql = "SELECT title, description, price, image_name, featured, active FROM tal_food WHERE id = ?";

            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "i", $id);
                if(mysqli_stmt_execute($stmt)){
                    // Save the result in the variables
                    mysqli_stmt_bind_result($stmt, $current_title, $current_description, $current_price, $current_image_name, $current_featured, $current_active);
                    mysqli_stmt_fetch($stmt);
                }
                mysqli_stmt_close($stmt);
            }

            $new_title = $_POST['new_title'];
            $new_description = $_POST['new_description'];
            $new_price = $_POST['new_price'];
            $new_image_name = '';
            $new_featured = $_POST['new_featured'];
            $new_active = $_POST['new_active'];

            // If title field is empty => new_title = current_title
            if(empty($new_title)){
                $new_title = $current_title;
            }

            // If description field is empty => new_descriptio = current_description
            if(empty($new_description)){
                $new_description = $current_description;
            }

            // If price field is empty => new_price = current_price
            if(empty($new_price)){
                $new_price = $current_price;
            }

            // If featured field is empty => new_featured = current_featured
            if(empty($new_featured)){
                $new_featured = $current_featured;
            }

            // If active field is empty => new_acive = current_active
            if(empty($new_active)){
                $new_active = $current_active;
            }

            // if image field is set, upload new image
            if(!empty($_FILES['new_image_name']['name'])){
                $new_image_name = $_FILES['new_image_name']['name']; // Image name
                $source_path = $_FILES['new_image_name']['tmp_name']; // Source path of the image
                $destination_path = "../images/food/".$new_image_name; // Where i want to upload my image
                $upload = move_uploaded_file($source_path, $destination_path); // Move my image from source to destination

                // Check if the upload failed
                if(!$upload){
                    $_SESSION['upload-food'] = '<div class="error">Failed to upload food image</div>';
                    header("location:".SITEURL.'admin/update-food.php');
                    die();
                }
            }
            // else, new_image_name => current_image_name
            else{
                $new_image_name = $current_image_name;
            }

            // SQL query to update the admin info
            $sql = "UPDATE tal_food SET title = ?, description = ?, price = ?, image_name = ?, featured = ?, active = ? WHERE id = ?";
            
            // Statement
            $stmt = mysqli_prepare($conn, $sql);
            if($stmt){
                // Binding the parameters to avoid SQL injection
                mysqli_stmt_bind_param($stmt, "ssdsssi", $new_title, $new_description, $new_price, $new_image_name, $new_featured, $new_active , $id);
                
                // Execution of the statement
                if(mysqli_stmt_execute($stmt)){
                    // Create a session variable to display the message
                    $_SESSION['update-food'] = '<div class="success">Food updated successfully</div>';
                    header("location:". SITEURL. 'admin/manage-food.php');
                }
                else{
                    $_SESSION['update-food'] = '<div class="error">Failed food update</div>';
                    header("location:". SITEURL. 'admin/update-food.php');
                }
                // Close the statement
                mysqli_stmt_close($stmt);
            }
        }  
        else{
            echo "no id found";
        }
    }
?>