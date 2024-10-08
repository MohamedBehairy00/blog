<?php 
require_once '../inc/connection.php' ;
 if (! isset($_SESSION['user_id'])) { header("location:../Login.php");}else{

// Check submit && ID

if (isset($_POST['submit']) && isset($_GET['id'])) {
    

    // Catch ID

    $id = (int)$_GET['id'] ;
    $query = "select id from posts where id =$id" ;
    $runQuery = mysqli_query($conn,$query);
    if (mysqli_num_rows($runQuery) == 1) {

        // Catch image , Check and unlinked

        $post = mysqli_fetch_assoc($runQuery);
        if(!empty($post)){
            unlink("../uploads/". $post['image'] );
        }

        // Query Delete

        $query = "delete from posts where id=$id" ;
        $runQuery = mysqli_query($conn,$query);

        // Check

        if($runQuery){
            $_SESSION['success'] = " Post Deleted Successfuly" ;
            header("location:../index.php") ;
        }else{
            $_SESSION['errors'] = ["Error While Deleting"] ;
            header("location:../index.php") ;
        }
    }else{
        $_SESSION['errors'] = ["Please Choose Correct Operation"] ;
        header("location:../index.php") ;
    }
}else{
    $_SESSION['errors'] = ["Please Choose Correct Operation"] ;
    header("location:../index.php") ;
}
 }