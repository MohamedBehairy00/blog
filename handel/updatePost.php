<?php 


require_once '../inc/connection.php' ;
     if (! isset($_SESSION['user_id'])) { header("location:Login.php");} 

// Check ID && Submit 

if (isset($_GET['id']) && isset($_POST['submit'])) {

    $id = $_GET['id'] ;

    // Check id in DB

    $query = "select * from posts where id=$id" ;
    $runQuery = mysqli_query($conn,$query);

    if (mysqli_num_rows($runQuery) == 1) {

        $oldNameImage = mysqli_fetch_assoc($runQuery)['image'];
        
        $errors = [] ;

        // Catch Data + Filter + Validation
    
         // 1- Title
    
        $title = htmlspecialchars(trim($_POST['title']));
    
        if(empty($title)) {
            $errors[] = "Title is Required" ;
        }elseif(is_numeric($title)){
            $errors[] = "Title Must Be String" ;
        }
    
    
        // 2- Body
    
        $body = htmlspecialchars(trim($_POST['body']));
    
        if(empty($body)) {
            $errors[] = "Body is Required" ;
        }elseif(is_numeric($body)){
            $errors[] = "Body Must Be String" ;
        }
    
    
        // image
    
        if ($_FILES['image'] && $_FILES['image']['name']) {
            
            $image = $_FILES['image'];
            $name = $image['name'];
            $tmp_name = $image['tmp_name'];
            $ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
            $size = $image['size']/(1024*1024);
            $error = $image['error'];
            $newName = uniqid().time().$ext ;
    
    
            $ext_arr = ['png' , 'jpg' , 'gif' , 'jpeg' , ' avif' , 'webp'] ;
            if($error !=0) {
             $errors[] = "Image is Required" ;
            }elseif(! in_array($ext,$ext_arr)){
             $errors[] = "Extention image is not correct" ;
            }elseif($size >1){
                $errors[] = " image large size" ;
            }
        }else{
            $newName = $oldNameImage ;
        }   
    
        // Check Errors 

            if (empty($errors)) {
                
                // Query Update

                $query = "update posts set `title` = '$title' , `body` = '$body' , `image` = '$newName' where id=$id";
                $runQuery = mysqli_query($conn,$query);

                if ($runQuery) {
                    if ($_FILES['image'] && $_FILES['image']['name']) {
                        unlink("../uploads/" . $oldNameImage);
                        move_uploaded_file($tmp_name,"../uploads/$newName");
                    }

                    $_SESSION['success'] = "Post Updated Successfuly" ;
                    header("location:../viewPost.php?id=$id");
                }else{
                    $_SESSION['errors'] = ["Error While Updating"] ;
                    header("location:../viewPost.php?id=$id");
                }   


            }else{
                $_SESSION['errors'] = $errors ;
                header("location:../editPost.php?id=$id");
            }


    }else{
        $_SESSION['errors'] = ["Post Not Found"];
        header("location:../index.php");
    }



}else{
    header("location:../index.php");
}