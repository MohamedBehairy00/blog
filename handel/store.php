<?php 
// Connection - Session start
require_once '../inc/connection.php';
  if (! isset($_SESSION['user_id'])) {
     header("location:Login.php");
    }else{
        $user_id = $_SESSION["user_id"];

// Check Submit

if (isset($_POST['submit'])) {

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
        $newName = null ;
    }   

    // Check Errors 

    if (empty($errors)) {
       
        // INSERT Query

        $query = "INSERT INTO posts (`title`,`body`,`image`,`user_id`) VALUES ('$title','$body' , '$newName' , '$user_id')" ;
        $runQuery = mysqli_query($conn,$query);
        if ($runQuery) {
            move_uploaded_file($tmp_name,"../uploads/$newName");
            $_SESSION['success'] = "Post Add Successfuly" ;
            header("location:../index.php");
        }
    }else{
        $_SESSION['errors'] = $errors ;
        $_SESSION['title'] = $title ;
        $_SESSION['body'] = $body ;
        
        header("location:../addPost.php");
    }

}else{
    header("location:../addPost.php");
}
}