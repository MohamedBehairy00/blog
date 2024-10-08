<?php 

require_once '../inc/connection.php' ;

// Check Submit

if (isset($_POST['submit'])) {

    // Catch Data && Filter && Validation

    $errors = [] ;

// 1- email

$email = trim(htmlspecialchars($_POST['email']));

if (empty($email)) {
    $errors[] = "Email is Required" ;
}elseif(! filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = "Email is not correct" ;
}elseif(strlen($email) > 25){
    $errors[] = "Email must be legnth more than 25" ;
}


// 2- Password

$password = trim(htmlspecialchars($_POST['password']));

if (empty($password)) {
    $errors[] = "Password is Required" ;
}elseif(strlen($password) < 7){
    $errors[] = "Password must be legnth more than 7" ;
}

// Password Hash

$passwordHashed = password_hash($password,PASSWORD_DEFAULT);

// Check Errors

if (empty($errors)){

    // Check Email , Password

    $query = "select * from users where `email` = '$email'" ;
    $runQuery = mysqli_query($conn,$query) ;

    if(mysqli_num_rows($runQuery) == 1) {
        
        $users = mysqli_fetch_assoc($runQuery);
        $oldPassword = $users['password'];
        $name = $users['name'];
        $id = $users['id'];
        $verify = password_verify($password,$oldPassword);
       
        if ($verify) {
            $_SESSION['user_id'] = $id ;
            $_SESSION['success'] = "Welcome $name" ;
            header("location:../index.php") ;
        }else{
            $_SESSION['errors'] = ["Credintials Not Correct"];
            header("location:../Login.php") ;
        }
    }else{
        $_SESSION['errors'] = ["Email is Not Founded"];
        header("location:../Login.php") ;
    }


}else{
    $_SESSION['errors'] = $errors ;
    header("location:../Login.php") ;    
}


}else{
    $_SESSION['errors'] = ["You Must be A Login"];
    header("location:../Login.php") ;
}