<?php
    require_once '../header.php';
    require_once '../config/db_connection.php';

// Get Data Query 
    $all_user_query = "SELECT id, user_name, user_email, user_password FROM users_table";
    $send_query = mysqli_query($db_connection, $all_user_query);
    // $after_assoc = mysqli_fetch_assoc($send_query);

    // print_r($after_assoc);
    // print_r($after_assoc['user_name']);

// Foreach loop
    // foreach($send_query as $rakib){
    //     print_r($rakib['user_name']);
    // }

?>


<section>
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
               <?php
                    require_once '../navber/navber.php'
                ?>
            </div>

            <div class="col-lg-9 mt-5">
            <div class="card">
                <h5 class="card-header">User Data Table</h5>
                    <div class="card-body">
                    
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
<!-- foreach loop -->
                                <?php
                                 foreach($send_query as $rakib){
                                ?>
                                <tr>
                                    <td><?= $rakib['id'] ?></td>
                                    <td><?= $rakib['user_name'] ?></td>
                                    <td><?= $rakib['user_email'] ?></td>
                                    <td><?= $rakib['user_password'] ?></td>
                                    <td><a class="btn btn-primary btn-sm" href='edit_user_data.php'>Edit</a></td>
                                    
                                </tr>
                                <?php
                                   }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</section>





<?php
    require_once '../footer.php'
?>