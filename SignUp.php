<?php

    session_start();

    if(isset($_SESSION['sign'])) {
        header("Location: index.php");
    }

    $db = mysqli_connect('localhost', 'root', '', 'simp1');
    $email = "";    
    $errors = array();
    $_SESSION['step']=1;

    if(isset($_POST['sendotp'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);              

        if(empty($email)) {
            array_push($errors, "Email is required.");
        }        
        if(count($errors) == 0) {
            $query = "Select * FROM admin_list WHERE email='$email'";
            $result1 = mysqli_query($db, $query);
            if(mysqli_num_rows($result1)==1) $_SESSION['role'] = 'Admin';

            $query = "Select * FROM student_list WHERE email='$email'";
            $result2 = mysqli_query($db, $query);
            if(mysqli_num_rows($result2)==1) $_SESSION['role'] = 'Student';

            $query = "Select * FROM teacher_list WHERE email='$email'";
            $result3 = mysqli_query($db, $query);
            if(mysqli_num_rows($result3)==1) $_SESSION['role'] = 'Teacher';

            if( isset($_SESSION['role']) ) {
                $_SESSION['email']=$email;
                //$otp = rand(100000, 999999);
                //mail = "";
                //send(mail);
                $_SESSION['otp']='111111';
                $_SESSION['step']=2;
            }
            else {
                array_push($errors, "Email not in admin's list. Contact Admin.");
            }         
        }
    }

    if(isset($_POST['verifyotp'])) {
        $email = $_SESSION['email'];
        $otp = mysqli_real_escape_string($db, $_POST['otp']);
        //$otp = strval($otp);        

        if($otp != $_SESSION['otp']) {
            array_push($errors, "OTP not correct");
        }        
        if(count($errors) == 0) {            
            $_SESSION['step']=3;            
        }
    }

    if(isset($_POST['signup'])) {
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $confirmpassword = mysqli_real_escape_string($db, $_POST['confirmpassword']);     

        if(empty($password)) {
            array_push($errors, "Password is required.");
        }
        if($password != $confirmpassword) {
            array_push($errors, "Passwords don't match");
        }    
        if(count($errors) == 0) {
            $email = $_SESSION['email'];
            $password = md5($password);
            $role = $_SESSION['role'];
            $signstatus = 1;            
            $query = "INSERT INTO user_sign (email, password, role, signstatus) VALUES ('$email', '$password', '$role', '$signstatus')";
            mysqli_query($db, $query);
            $_SESSION['sign']=1;
            header("Location: index.php");                        
        }
    }

?>

<!-- Compating different devices and applicatons -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />

<!-- Title bar -->
<title>Sign Up | Simp</title>
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

<?php if($_SESSION['step'] == 1) : ?>
<form method="post" action="SignUp.php">
    <div>
        <label>Email</label>
        <input type="text" name="email" value= <?php echo $email; ?> >
    </div>    
    <div>
        <button type="submit" name="sendotp">Send OTP</button>
    </div> 
</form>
<?php endif; ?>

<?php if($_SESSION['step'] == 2) : ?>
<form method="post" action="SignUp.php">
    <div>
        <label>OTP</label>
        <input type="text" name="otp">
    </div>    
    <div>
        <button type="submit" name="verifyotp">Verify OTP</button>
    </div> 
</form>
<?php endif; ?>

<?php if($_SESSION['step'] == 3) : ?>
<form method="post" action="SignUp.php">
    <div>
        <label>Password</label>
        <input type="text" name="password">
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="text" name="confirmpassword">
    </div>    
    <div>
        <button type="submit" name="signup">Sign Up</button>
    </div> 
</form>
<?php endif; ?>

<div>
    <?php foreach($errors as $error) : ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
</div>

<p>Already Signed Up ? <a href="SignIn.php">Sign In</a></p>
