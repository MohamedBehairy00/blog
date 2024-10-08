<?php 

require_once '../../inc/connection.php' ;

// Check Submit

if (isset($_POST['submit'])) {

    // Catch Data && Filter && Validation

    $errors = [] ;

    // 1- Name

    $name = trim(htmlspecialchars($_POST['name']));

    if (empty($name)) {
        $errors[] = "Name is Required" ;
    }elseif(is_numeric($name)) {
        $errors[] = "Name Must Be A String" ;
    }elseif(strlen($name) > 30 ){
        $errors[] = "Length of name letter than 30" ;
    }

    
    // 2- email

    $email = trim(htmlspecialchars($_POST['email']));

    if (empty($email)) {
        $errors[] = "Email is Required" ;
    }elseif(! filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email is not correct" ;
    }elseif(strlen($email) > 25){
        $errors[] = "Email must be legnth more than 25" ;
    }


    // 3- Password

    $password = trim(htmlspecialchars($_POST['password']));

    if (empty($password)) {
        $errors[] = "Password is Required" ;
    }elseif(strlen($password) < 7){
        $errors[] = "Password must be legnth more than 7" ;
    }

    // Password Hash

    $passwordHashed = password_hash($password,PASSWORD_DEFAULT);


    // 4- Phone

    $phone = trim(htmlspecialchars($_POST['phone']));

    if (empty($phone)) {
        $errors[] = "Phone is Required" ;
    }elseif(strlen($phone) > 15){
        $errors[] = "Phone is not correct" ;
    }


    // Check Errors

    if (empty($errors)) {

        // Query INSERT

        $query = "INSERT INTO users (`name` , `email` , `password` , `phone`) VALUES ('$name' , '$email' , '$passwordHashed' , '$phone')" ;
        $runQuery = mysqli_query($conn,$query);

        // Check Query

        if ($runQuery) {
            $_SESSION['success'] = "Register Done";
            header("location:../../login.php") ;
        }else{
            $_SESSION['errors'] = ["Error While Inserting"];
            header("location:../register.php") ;
        }

    }else{
        $_SESSION['errors'] = $errors ;
        header("location:../register.php") ;    
    }

}else{
    $_SESSION['errors'] = ["You Must be A Register"];
    header("location:../register.php") ;
}