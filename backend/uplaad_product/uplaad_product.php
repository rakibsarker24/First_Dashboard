<?php
    session_start();
    require_once '../config/db_connection.php';

    require_once '../header.php';


    $err_name = $err_file_size= $err_formate = $err_category = $err_old_price= $err_new_price='';

    if(isset($_POST['submit'])){
        // print_r($_POST);
        $pro_name = $_POST['pro_name'];
        $category = $_POST['category'];
        $discription = $_POST['discription'];
        $old_price = $_POST['old_price'];
        $new_price = $_POST['new_price'];

        // print_r($_POST['discription']);

        if(empty($pro_name)){
            $err_name = "fill is required";
        }

        if(empty($category)){
            $err_category = "fill is required";
        }
        
        if(empty($old_price)){
            $err_old_price = "fill is required";
        }

        if(empty($new_price)){
            $err_new_price = "fill is required";
        }


// file uploade
        // print_r($_FILES);

        // $file_name = $_FILES['file'];

        $file_name = $_FILES['file']['name'];
        // print_r($file_name);

        $after_explode =  explode('.' , $file_name);
        //print_r($after_explode);         //3 ta dot ase amon image upload korle extension dora plm
       
        $check_extention = end($after_explode);  // end() ses er dot(.) er por extension print korbe
        //print_r(end($check_extention));    

        //new array of my extension support
        $all_extention = array('jpg', 'jpeg', 'png');

// check extention
        if(in_array($check_extention, $all_extention)){
// check file size
            $file_size = $_FILES['file']['size'];   //byte a thake
            // print_r($file_size);

            if($file_size > 2000000){   
                $err_file_size = 'file size less than 2MB';
            }else{
                if(!empty($pro_name) && !empty($category) && !empty($discription) && !empty($old_price) && !empty($new_price) && !empty($file_name)){

                    // insert query
                    $insert_query = "INSERT INTO products (product_name, product_category, product_discription, old_price, new_price, image_location ) VALUES('$pro_name ', '$category', '$discription', '$old_price', '$new_price', 'primary_location' )"; 
                    mysqli_query($db_connection, $insert_query);
                    //print id form db and rename to image
                    $contate_iamge_name = mysqli_insert_id($db_connection). "." .$check_extention;
                    //create new location for uploded iamge
                    $new_location = '../upload_images/products/'.$contate_iamge_name;
                    // print_r($_FILES['file']['tmp_name']);
                    move_uploaded_file($_FILES['file']['tmp_name'], $new_location);
                    
                    // update image name
                    $id_no = mysqli_insert_id($db_connection);
                    $update_image_name = "UPDATE products SET image_location = '$new_location' WHERE id= '$id_no' ";
                    mysqli_query($db_connection, $update_image_name);
                    // echo "Done!";
                }
            }
        }else{
            $err_formate = 'This file formate not support!';

        }

    }

    $products_all_data = "SELECT id, product_name, product_category, product_discription, old_price, new_price, image_location, active_status FROM products";
    $data =  mysqli_query($db_connection, $products_all_data);
    $after_assoc = mysqli_fetch_assoc($data);
    // print_r($after_assoc['id']);
    // print_r($after_assoc['product_name']);
    // print_r($after_assoc['product_category']);
    // print_r($after_assoc['product_discription']);
    // print_r($after_assoc['old_price']);
    // print_r($after_assoc['new_price']);
    // print_r($after_assoc['image_location']);
    // print_r($after_assoc['active_status']);





// //Get user name & password form db
//     $search_query = "SELECT user_name, user_password FROM users_table WHERE user_email='$email'";
//     $query = mysqli_query($db_connection, $search_query);

//     $after_assoc = mysqli_fetch_assoc($query);
//     $name = ($after_assoc['user_name']);
//     $password = ($after_assoc['user_password']);



// // Update Code into DB
//     if(isset($_POST['submit'])){
//         $update_name = $_POST['user_name'];
//         $update_query = "UPDATE users_table SET user_name ='$update_name' WHERE user_email = '$email'";
//         $query = mysqli_query($db_connection, $update_query);
//         header("location: profile.php");
//     }
    
   
?>




<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php
                    require_once '../navber/navber.php'
                ?>
            </div>
            <div class="col-lg-6 mt-5">

                <div class="bg-primary text-white text-center pb-2 pt-2 rounded mb-3">
                    <h3>Product Upload</h3>
                </div>
                <form method='POST' enctype='multipart/form-data' action='uplaad_product.php'>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"><b>Product Name</b></label>
                        <input type="text1" class="form-control" placeholder='name' name='pro_name' value='<?php echo ''; ?>' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_name. "</span>"; } ?>
                    </div>
                    <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label"><b>Product Category</b></label>
                        <select class="form-select" name='category' aria-label="Default select example">
                            <option selected>select category</option>
                            <option value="Shirt">Shirt</option>
                            <option value="Pant">Pant</option>
                            <option value="T-shirt">T-shirt</option>
                        </select>
                        <!-- <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_category. "</span>"; } ?> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"><b>Old Price</b></label>
                        <input type="number" class="form-control" placeholder='old price' name='old_price' value='<?php echo ''; ?>' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_old_price. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"><b>New Price</b></label>
                        <input type="number" class="form-control" placeholder='new price' name='new_price' value='<?php echo ''; ?>' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_new_price. "</span>"; } ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"><b>Product Discription</b></label><br>
                        <textarea name='discription' rows="6" cols="70" > </textarea>
                        <!-- <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$errname. "</span>"; } ?> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"><b>Upload File</b></label><br>
                        <input type="file" name='file' value='<?php echo ''; ?>' >
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_file_size. "</span>"; } ?>
                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>" .$err_formate. "</span>"; } ?>
                    </div>
                    <button type="submit" name='submit' class="btn btn-primary w-100">Update</button>
                </form>

        </div>
        <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card">
                    <h5 class="card-header">Featured</h5>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">product_name</th>
                            <th scope="col">product_category</th>
                            <th scope="col">product_discription</th>
                            <th scope="col">old_price</th>
                            <th scope="col">New_price</th>
                            <th scope="col">Images</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($data as $rakib){
                                
                        ?>
                            <tr>
                            <th><?= $rakib['id'] ?></th>
                            <th><?= $rakib['product_name'] ?></th>
                            <th><?= $rakib['product_category'] ?></th>
                            <th><?= $rakib['product_discription'] ?></th>
                            <th><?= $rakib['old_price'] ?></th>
                            <th><?= $rakib['new_price'] ?></th>
                            <th><img  width='100' src="<?= $rakib['image_location'] ?>" alt=""></th>
                            <th><?= $rakib['active_status'] ?></th>
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
        </div>
            
    </div>
</section>




<?php
    require_once '../footer.php';
?>