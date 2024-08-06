<?php
    session_start();
    $errname = $erremail = $len_name = $errpass = $errpassword = $pass_not_match= $len_password = $used_email ='';
    require_once '../../backend/config/db_connection.php';
    
if(isset($_POST['submit'])){
        
        $name = $_POST['user_name'];
        $namelen = strlen($name);

        $email = $_POST['email'];
        $password = $_POST['password'];
        $pass = $_POST['pass'];


// name error
        if(empty($name)){
            $errname = 'Fill up the form.';
        }else{
            if($namelen < 3){
                $len_name = 'Name must more than 3 char.';
            }
        }


// password error
        if(empty($password)){
            $errpassword = 'Fill up the form.';
        }else{
            if(strlen($password) < 5){
                $len_password = 'Password must more than 5 char.';
            }
        }
        
        

// confrim password error
        if(empty($pass)){
            $errpass = 'Fill up the form.';
        }else{
            if($password !== $pass){
                $pass_not_match = 'password not match.';
            }
        }



// email error & data send
        if(empty($email)){
            $erremail = 'Fill up the form.';
        }else{
// checking email query
            $check = "SELECT COUNT(*) AS total_count FROM users_table WHERE user_email='$email' ";
            $afterchecking = mysqli_query($db_connection, $check);
            // print_r($afterchecking);

            $after_assoc = mysqli_fetch_assoc($afterchecking);
            // print_r($after_assoc['total_count']);

            if($after_assoc['total_count'] == 0){
// insert query
                $mdpassword = md5($password);
                if(!empty($name) && $namelen>2 && !empty($email) && !empty($password) && !empty($pass) && $password == $pass){
                    $inser_query = "INSERT INTO users_table (user_name, user_email, user_password) VALUES ('$name', '$email', '$mdpassword')";
                    $query = mysqli_query($db_connection, $inser_query);

                    $_SESSION['account_created'] = 'Account created successfull!';
                    header("location: ../user_login/user_login.php");

                }else{
                   echo 'error';
                }
            }else{
                $used_email = "This email already used.";

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
                    <h3>Registration</h3>
                </div>
                <form method='POST' action='user_registration.php'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Your Name</label>
                        <input type="text1" class="form-control" placeholder='name' name='user_name' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errname. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$len_name. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder='email' name='email' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$erremail. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$used_email. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Create Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder='create password' name='password' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errpassword. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$len_password. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Re-enter Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder='re-enter password' name='pass' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errpass. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$pass_not_match. "</span>"; } ?>
                    </div>
                    <button type="submit" name='submit' class="btn btn-primary w-100">Registration</button>
                    <div class="mt-3">
                    <p>Have already an Account? <a href="../user_login/user_login.php">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
    require_once '../footer.php';
?>
