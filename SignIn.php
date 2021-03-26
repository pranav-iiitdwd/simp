<?php

    session_start();

    if(isset($_SESSION['sign'])) {
        header("Location: index.php");
    }

    $db = mysqli_connect('localhost', 'root', '', 'simp1');
    $email = "";
    $errors = array();    

    if(isset($_POST['signin'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(empty($email)) {
            array_push($errors, "Email is required.");
        }
        if(empty($password)) {
            array_push($errors, "Password is required.");
        }
        if(count($errors) == 0) {
            $password = md5($password);
            $query = "Select * FROM user_sign WHERE email='$email' and password='$password'";
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result)==1) {
                $_SESSION['email'] = $email;
                $row = mysqli_fetch_array($result);
                $_SESSION['role'] = $row['role'];                
                $_SESSION['sign']=1;
                header("Location: index.php");  
            }
            else {
                array_push($errors, "Email and Password don't  match.");
            }
        }
    }

?>

<!-- Compating different devices and applicatons -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />

<!-- Title bar -->
<title>Sign In | Simp</title>
<link rel = "icon" type = "image/png" href = "stock/logo.png">

<!-- Style sheet -->
<link rel="stylesheet" type="text/css" href="styleFiles/style.css" />

<!-- Adobe fonts -->
<link rel="stylesheet" href="https://use.typekit.net/oyy6bsf.css">

<!-- jQuery files include -->
<script src="effectFiles\jQuery\jQuery compressed.js"></script>
<script src="effectFiles\jQuery\jquery-ui.js"></script>
<script src="effectFiles\jQuery\jQuery ease1.js"></script>
<script src="effectFiles\jQuery\jQuery ease2.js"></script>

<!-- Javascript file -->
<script type="text/javascript" src="effectFiles\effect.js"></script>

<form method="post" action="SignIn.php">
    <div>
        <label>Email</label>
        <input type="text" name="email">
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div>
    <div>
        <button type="submit" name="signin">Sign In</button>
    </div> 
</form>

<p>Not yet Signed Up ? <a href="SignUp.php">Sign Up</a></p>