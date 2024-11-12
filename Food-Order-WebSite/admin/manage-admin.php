<?php include("partials/menu.php");?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            
            <br>

            <?php 
                // Message for adding a new admin
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }

                // Message for updating admin informations (full_name, username)
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display session message
                    unset($_SESSION['update']); // Remove session message
                }

                // Message for deleting an admin
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete']; // Display session message
                    unset($_SESSION['delete']); // Remove session message
                }

                // Message for updating an admin password
                if(isset($_SESSION['update-password'])){
                    echo $_SESSION['update-password']; // Display session message
                    unset($_SESSION['update-password']); // Remove session message
                }
            ?>

            <br> <br> <br>
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br> <br>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    // Query to get all admin
                    $sql = "SELECT * FROM tbc_admin";
                    
                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Check if the query is executed
                    if($res){
                        // Count rows to check if we have data
                        $rows = mysqli_num_rows($res);
                        if($rows > 0){
                            while($rows = mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="update-password-admin.php?id=<?php echo $id;?>" class="btn-primary">Update Password</a> <!-- Passo l'id come query nell'url --->
                                        <a href="update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a> <!-- Passo l'id come query nell'url --->
                                        <a href="delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a> <!-- Passo l'id come query nell'url --->
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