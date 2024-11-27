<?php
    session_start();
    if(isset($_SESSION["user"])){
        header("Location:index.php");
       }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
         <?php 
         IF(isset($_POST["submit"])){
            $fullName=$_POST["fullname"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $passwordrepeat=$_POST["repeat_password"];
            $passwordHash=password_hash($password,PASSWORD_DEFAULT);

            $errors=array();

            if(empty($fullName) || empty($email) || empty($password) || empty($passwordrepeat)){  
                array_push($errors,"all fields are required");  
         }
         if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            array_push($errors,"Email is not valid");
         }
         if(strlen($password) < 8){
            array_push($errors,"password must be at least 8 characters");
         }
         if($password!==$passwordrepeat){
         array_push($errors,"password doesnot match");
         }
         require_once("database.php");
        $sql = "SELECT * FROM users WHERE email = '$email'";
         $result = mysqli_query($conn, $sql);
         $rowCount = mysqli_num_rows($result );
         if($rowCount>0){
            array_push($errors,"Email already exist!");
         }
         if(count($errors) > 0){
            foreach($errors as $error){
                echo"<div class='alert alert-danger'>$error</div>";
            }
        }else{
            
            $sql = "INSERT INTO users(full_name, email, password) VALUES( ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if( $prepareStmt){
                mysqli_stmt_bind_param($stmt,"sss", $fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Registration successfully</div>";
            }else{
                die("Something went wrong");
            }
            }


        }
         ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="repeat password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary"value="register" name="submit">
            </div>

        </form><br>
        <div>
        <p>Once registered Go login  <a href="login.php">Login Here</a> </p>
    </div>
    </div>
</body>
</html>