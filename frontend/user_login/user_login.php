<?php
    session_start();
    require_once '../../backend/config/db_connection.php';

    
    $erremail = $errpassword = $len_password ='';
    
    if(isset($_POST['submit'])){
        

        $email = $_POST['email'];
        $password = $_POST['password'];

        
        if(empty($password)){
            $errpassword = 'Fill up the form.';
        }else{
            if(strlen($password) < 5){
                $len_password = 'Password must more than 5 char.';
            }
        }
        
        if(empty($email)){
            $erremail = 'Fill up the form.';
        }else{
            $mdpassword = md5($password) ;
            $checking_email = "SELECT COUNT(*) AS total_count FROM users_table WHERE user_email='$email' AND user_password='$mdpassword' ";
            $after_check = mysqli_query($db_connection, $checking_email);
            $fter_acssoc = mysqli_fetch_assoc($after_check);

            print_r($fter_acssoc['total_count']);

            if($fter_acssoc['total_count'] == 0){
                echo 'Email & password not match.';
            }else{
                header("location: ../../backend/dashboard/dashboard.php");
                $_SESSION['email']= $email;
                $_SESSION['login']= 'Login Successful!';
                $_SESSION['user']= 'yes';
            }
            
        }


    };



                    
    
?>

    <?php
        require_once '../header.php';
    ?>

<section>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4">
                <div class="bg-primary text-white text-center pb-2 pt-2 rounded mb-3">
                    <h3>Login</h3>
                </div>
                <form method='POST' action='user_login.php'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder='email' name='email' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$erremail. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Create Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder='create password' name='password' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errpassword. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$len_password. "</span>"; } ?>
                    </div>
                    <button type="submit" name='submit' class="btn btn-primary w-100">Login</button>
                    <div class="mt-3">
                        <p>Have not and Account? <a href="../users_registration/user_registration.php">Registration</a></p>
                    </div>
                </form>

                <div class="">
                    <!-- <?php
                        if(isset($_POST['account_created'])){
                            echo $_POST['account_created'];
                        }
                    ?> -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    require_once '../footer.php';
?>
