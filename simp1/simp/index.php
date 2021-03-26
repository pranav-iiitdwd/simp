<?php 

    $db = mysqli_connect('localhost', 'root', '', 'simp1');

    session_start();    

    if(isset($_POST['signout'])) {
        session_destroy();
        session_start();
    }

    if(!isset($_SESSION['sign'])) {
        header("Location: SignIn.php");
    }

    if(isset($_POST['addadmin'])) {
        $email = $_POST['email'];
        $query = "Select * FROM admin_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==0) {
            $query = "INSERT INTO admin_list (email) VALUES ('$email')";
            mysqli_query($db, $query);            
        }       
    }
    if(isset($_POST['removeadmin'])) {        
        $email = $_POST['email'];
        $query = "Select * FROM admin_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)!=0) {
            $query = "DELETE FROM admin_list WHERE email = '$email'";            
            mysqli_query($db, $query);            
        }       
    }
    if(isset($_POST['addstudent'])) {
        $email = $_POST['email'];
        $query = "Select * FROM student_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==0) {
            $query = "INSERT INTO student_list (email) VALUES ('$email')";
            mysqli_query($db, $query);            
        }       
    }
    if(isset($_POST['removestudent'])) {        
        $email = $_POST['email'];
        $query = "Select * FROM student_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)!=0) {
            $query = "DELETE FROM student_list WHERE email = '$email'";            
            mysqli_query($db, $query);            
        }       
    }
    if(isset($_POST['addteacher'])) {
        $email = $_POST['email'];
        $query = "Select * FROM teacher_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==0) {
            $query = "INSERT INTO teacher_list (email) VALUES ('$email')";
            mysqli_query($db, $query);            
        }       
    }
    if(isset($_POST['removeteacher'])) {        
        $email = $_POST['email'];
        $query = "Select * FROM teacher_list WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)!=0) {
            $query = "DELETE FROM teacher_list WHERE email = '$email'";            
            mysqli_query($db, $query);            
        }       
    }
?>

<!-- Compating different devices and applicatons -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />

<!-- Title bar -->
<title>Home | Simp</title>
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

<p>Signed In as - <?php echo $_SESSION['email']; ?> </p>
<p>Role - <?php echo $_SESSION['role']; ?> </p>

<form method="post" action="index.php">    
    <div>
        <button type="submit" name="signout">Sign Out</button>
    </div> 
</form>

<?php if($_SESSION['role']=='Admin') : ?>
    <hr>
    <h3>Admin List</h3>    
    <?php
        $query = "Select * FROM admin_list WHERE 1=1";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result)) echo($row['email']."<br>");
    ?>
    <br><hr>
    <h3>Student List</h3>    
    <?php
        $query = "Select * FROM student_list WHERE 1=1";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result)) echo($row['email']."<br>");
    ?>
    <br><hr>
    <h3>Teacher List</h3>    
    <?php
        $query = "Select * FROM teacher_list WHERE 1=1";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result)) echo($row['email']."<br>");
    ?>
    <br><hr>
    <form method="post" action="index.php">
        <br> 
        <div>
            <label>Email</label>
            <input type="text" name="email">
        </div>
        <br> 
        <div>
            <button type="submit" name="addadmin">Add Admin</button>
            <button type="submit" name="removeadmin">Remove Admin</button>
        </div>
        <br>    
        <div>
            <button type="submit" name="addstudent">Add Student</button>
            <button type="submit" name="removestudent">Remove Student</button>
        </div>
        <br> 
        <div>
            <button type="submit" name="addteacher">Add Teacher</button>
            <button type="submit" name="removeteacher">Remove Teacher</button>
        </div>  
    </form>
<?php endif; ?>