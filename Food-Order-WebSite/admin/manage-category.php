<?php include("partials/menu.php");?>

        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Category</h1>

                <br>

                <?php 
                    // Message for adding a new category
                    if(isset($_SESSION['add-category'])){
                        echo $_SESSION['add-category']; // Display session message
                        unset($_SESSION['add-category']); // Remove session message
                    }
                ?>

                <br> <br> <br>
                <a href="add-category.php" class="btn-primary">Add Category</a>
                <br> <br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                    </tr>

                    <?php
                    // Query to get all categories
                    $sql = "SELECT * FROM tbl_category";
                    
                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Check if the query is executed
                    if($res){
                        // Count rows to check if we have data
                        $rows = mysqli_num_rows($res);
                        if($rows > 0){
                            while($rows = mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $title = $rows['title'];
                                $image_name = $rows['image_name'];
                                $featured = $rows['featured'];
                                $active = $rows['active'];


                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td>
                                        <?php 
                                            if(!empty($image_name)){
                                        ?>
                                                <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" width="100px">
                                        <?php
                                            }
                                            else{
                                                echo "<div class='error'>Image not Added</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="#" class="btn-secondary">Update Category</a> <!-- Passo l'id come query nell'url --->
                                        <a href="#" class="btn-danger">Delete Category</a> <!-- Passo l'id come query nell'url --->
                                    </td>
                                </tr>


                                <?php
                            }
                        }
                    }
                ?>
                </table>
            </div>
         </div>

<?php include("partials/footer.php");?>