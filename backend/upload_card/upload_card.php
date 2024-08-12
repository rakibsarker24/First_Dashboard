<?php
    require_once '../header.php';
    require_once '../config/db_connection.php';

    $err_file = '';

    if(isset($_POST['submit'])){

        $title = $_POST['title'];
        $discription = $_POST['discription'];
        // print_r($_FILES['file']);
        $file_name = $_FILES['file']['name'];
        $image_location =  $_FILES['file']['tmp_name'];
        $image_size =  $_FILES['file']['size'];
    }

    if(empty($title)){
        $err_title = "Title is required";
    }else{
        $err_title = '';
    }

    if(empty($discription)){
        $err_discription = "Discription is required";
    }else{
        $err_discription = '';
    }

    if(empty($file_name)){
        $err_file = "Image is required *(png, jpeg, jpg)";
    }else{
        $file_name_explode = explode('.', $file_name);
        $select_extension = end($file_name_explode);
        // print_r($after_explode); 

        $all_extention = array('jpg', 'jpeg', 'png');

        if(in_array($select_extension, $all_extention)){
            if($image_size > 2000000){
                echo "file size less than 2MB";
            }else{
                $insert_query = "INSERT INTO card_table (title, discription, image_location) VALUES ('$title', '$discription', 'primary_location')";
                mysqli_query($db_connection, $insert_query);

                $id = mysqli_insert_id($db_connection);
                $contate_name = $id.".".$select_extension;
                // echo $contate_name;
                $new_location = '../upload_images/products/'.$contate_name;
                // echo $new_location;
                // $new_location = '../upload_images/products/'.$new_name;
                // print_r($_FILES['file']['tmp_name']);
                move_uploaded_file($_FILES['file']['tmp_name'], $new_location);

                $update_name = "UPDATE card_table SET image_location ='$new_location' WHERE id='$id' ";
                mysqli_query($db_connection, $update_name);
                echo "done";

            }
        }else{
            echo "file formate not support.";
        }
    }


    $card_all_data = "SELECT id, title, discription, image_location, active_status FROM card_table";
    $data =  mysqli_query($db_connection, $card_all_data);
    $after_assoc = mysqli_fetch_assoc($data);
    // print_r($after_assoc);
    // print_r($after_assoc['title']);
    // print_r($after_assoc['discription']);
    // print_r($after_assoc['image_location']);
    // print_r($after_assoc['active_status']);

    // foreach($data as $rakib){
    //     print_r($rakib['title']);
    // }




?>

<section>
    <div class="container">
        <div class="row">

            <div class="col-lg-2">
                <?php
                    require_once '../navber/navber.php'
                ?>
            </div>

            <div class="col-lg-3 mt-3">
                <div class="card text-bg-light mb-3" style="max-width: 100%;">
                    <div class="card-header text-light bg-primary"><b>Upload Card</b></div>
                        <div class="card-body">         
                            <form aciton='upload_card.php' method='POST' enctype='multipart/form-data'>
                                <div class="">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label"><b>Upload Image</b></label>
                                        <input class="form-control" type="file" id="formFile" name='file'>
                                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>".$err_file."</span>" ;} ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label"><b>Title</b></label>
                                        <input type="text" class="form-control" name='title'>
                                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>".$err_title."</span>" ;} ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label"><b>Discription</b></label>
                                        <input type="text" class="form-control" name='discription'>
                                        <?php if(isset($_POST['submit'])){ echo "<span class='text-danger'>".$err_discription."</span>" ;} ?>
                                    </div>
                                </div>
                                <button type="submit" name='submit' class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                </div>
            </div>

            <div class="col-lg-7 mt-5">
                <div class="card">
                    <h5 class="card-header">Featured</h5>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Discription</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($data as $rakib){
                                
                        ?>
                            <tr>
                            <th><?= $rakib['id'] ?></th>
                            <th><?= $rakib['title'] ?></th>
                            <th><?= $rakib['discription'] ?></th>
                            <th><img class='img-fluid' src="<?= $rakib['image_location'] ?>" alt=""></th>
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
</section>











<?php
    require_once '../footer.php';

?>