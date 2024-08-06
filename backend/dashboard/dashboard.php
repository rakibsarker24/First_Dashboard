<?php
    session_start();
        if(!isset($_SESSION['user'])){
            header("location: ../../frontend/user_login/user_login.php");
        }
        
    require_once '../../frontend/header.php';
    ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php
                    require_once '../navber/navber.php'
                ?>
            </div>
            <div class="col-lg-9 mt-5 text-center">
                    <h3>Welcome to 
                    <?php 
                        if(isset($_SESSION['email'])){
                            print_r($_SESSION['email']);
                        }
                    ?>
                !</h3>
<!-- session for login and unset -->
                    <?php
                        if(isset($_SESSION['login'])){
                            echo $_SESSION['login'];
                            unset($_SESSION['login']);
                        }
                    ?>
            </div>
        </div>
    </div>
</section>

        




<?php
require_once '../../frontend/footer.php';
?>