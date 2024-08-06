<?php
    session_start();
    require_once '../config/db_connection.php';



    require_once '../header.php';

    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
    }
    $search_query = "SELECT user_name, user_email, user_password FROM users_table WHERE user_email ='$email' ";
    $send_query = mysqli_query($db_connection, $search_query);
    $after_assoc = mysqli_fetch_assoc($send_query);

    // print_r($after_assoc['user_password']);


    
   
?>




<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php
                    require_once '../navber/navber.php'
                ?>
            </div>
            <div class="col-lg-4 mt-5">

                <div class="bg-primary text-white text-center pb-2 pt-2 rounded mb-3">
                    <h3>Your Information</h3>
                </div>
                <p><b>Name:</b> <?=$after_assoc['user_name']?></p>
                <p><b>Email:</b> 
                    <?php 
                        if(isset($_SESSION['email'])){
                            echo $_SESSION['email'];
                        }
                        ?>
                </p>
                <p><b>Password:</b> <?=$after_assoc['user_password']?></p>
                <a class='btn btn-sm btn-danger' href="edit_user_data.php">Edit</a>

            </div>
        </div>
    </div>
</section>




<?php
    require_once '../footer.php';
?>