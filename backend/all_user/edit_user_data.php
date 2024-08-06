<?php
    session_start();
    require_once '../config/db_connection.php';


    require_once '../header.php';

    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
    }
//Get user name & password form db
    $search_query = "SELECT user_name, user_password FROM users_table WHERE user_email='$email'";
    $query = mysqli_query($db_connection, $search_query);

    $after_assoc = mysqli_fetch_assoc($query);
    $name = ($after_assoc['user_name']);
    $password = ($after_assoc['user_password']);



// Update Code into DB
    if(isset($_POST['submit'])){
        $update_name = $_POST['user_name'];
        $update_query = "UPDATE users_table SET user_name ='$update_name' WHERE user_email = '$email'";
        $query = mysqli_query($db_connection, $update_query);
        header("location: profile.php");
    }
    
   
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
                    <h3>Edit Data</h3>
                </div>
                <form method='POST' action='edit_user_data.php'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Your Name</label>
                        <input type="text1" class="form-control" placeholder='name' name='user_name' value='<?php echo $name; ?>' >
                        <!-- <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errname. "</span>"; } ?> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  value='<?php echo $email; ?>' placeholder='email' name='email' >
                        <!-- <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$erremail. "</span>"; } ?> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Create Password</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder='create password' name='password'value='<?php echo $password; ?>' >
                        <!-- <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errpassword. "</span>"; } ?> -->
                    </div>
                    <button type="submit" name='submit' class="btn btn-primary w-100">Update</button>
                </form>

            </div>
        </div>
    </div>
</section>




<?php
    require_once '../footer.php';
?>