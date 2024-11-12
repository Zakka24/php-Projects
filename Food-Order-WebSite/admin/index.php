<?php include("partials/menu.php");?>

        <div class="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>

                <br><br><br>
                <?php 
                    // Message for successfull login
                    if(isset($_SESSION['user-logged'])){
                        echo $_SESSION['user-logged']; // Display session message
                        unset($_SESSION['user-logged']); // Remove session message
                    }
                ?>

                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <h1>5</h1>
                    <br>
                    Categories
                </div>
                <div class="clearfix"></div>
            </div>
         </div>

<?php include("partials/footer.php");?>