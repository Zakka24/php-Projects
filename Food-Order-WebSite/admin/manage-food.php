<?php include("partials/menu.php");?>

        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Category</h1>

                <br>

                <?php 
                    // Message for add category
                    if(isset($_SESSION['add-food'])){
                        echo $_SESSION['add-food']; // Display session message
                        unset($_SESSION['add-food']); // Remove session message
                    }
                    
                    // Message for delete category
                    if(isset($_SESSION['delete-food'])){
                        echo $_SESSION['delete-food']; // Display session message
                        unset($_SESSION['delete-food']); // Remove session message
                    }
                    
                    // Message for update category
                    if(isset($_SESSION['update-food'])){
                        echo $_SESSION['update-food']; // Display session message
                        unset($_SESSION['update-food']); // Remove session message
                    }
                ?>

                <br> <br> <br>
                <a href="add-food.php" class="btn-primary">Add Food</a>
                <br> <br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Desciption</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category ID</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    // Query to get all categories
                    $sql = "SELECT * FROM tal_food";
                    
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
                                $description = $rows['description'];
                                $price = $rows['price'];
                                $image_name = $rows['image_name'];
                                $category = $rows['category_id'];
                                $featured = $rows['featured'];
                                $active = $rows['active'];
                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td>
                                        <?php 
                                            if(!empty($image_name)){
                                        ?>
                                                <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" width="100p">
                                        <?php
                                            }
                                            else{
                                                echo "<div class='error'>Image not Added</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $category; ?></td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a> <br><br><!-- Passo l'id come query nell'url --->
                                        <a href="delete-food.php?id=<?php echo $id;?>" class="btn-danger">Delete Food</a> <!-- Passo l'id come query nell'url --->
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