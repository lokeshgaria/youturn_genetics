﻿<?php
session_start();
$msg = " ";
include('includes/header.php');
include 'connection.php';
  
//on submit button new account created
if (isset($_POST['submit'])) {
    $CID = openssl_random_pseudo_bytes(8);
    $CID = bin2hex($CID);
    $joindate = date('Y:m:d');
    $jointime = date("h:i:s");
    $f_name = $_POST['fname'];
    $l_name = $_POST['lname'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $DOB = $_POST['date'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { ?>
         <script>alert("email already exist. Try to login in your Account ");</script>
    <?php } else {
        // inserting data in users table 
        $insqry = "INSERT INTO `users` (`id`, `cid`, `f_name`, `l_name`, `email`, `email_verify`, `countrycode`, `mobile`, `mobile_verify`, `DOB`, `password`, `joindate`, `jointime`, `status`) VALUES (NULL, '$CID ', '$f_name', '$l_name', '$email', 'no', '$country', '$phone', 'no', '$DOB', ' $password', '$joindate', '$jointime', 'active')";

        $run = mysqli_query($conn, $insqry);
        if ($run) { ?>
            <script>
                alert("data inserted succesfully ");
            </script>
        <?php } else {  ?>
            <script>
                alert("failed");
            </script>
<?php }
    }
}

//login to account
if (isset($_POST['login'])) {
    $emailCheck = $_POST['email_verify'];
    $passCheck = $_POST['password_check'];

    $sql = " select `id` from `users` where `email` = '$emailCheck' and `password` = '$passCheck' ";  
    $result = mysqli_query($conn, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
    // If result matched $myusername and $mypassword, table row must be 1 row
      echo $count;
    if($count == 1) { ?>
    <script>alert("login Succesfull");</script>
       
    <?php }else {
       $msg = "Your Login Name or Password is invalid   " . mysqli_error($conn);
    }
 }


?>

<!--site-main start-->

<section class="login_bg">
    <div class="container-fluid">
        <div class="col-sm-9 login_main">
            <div class="row">
                <div id="login" style="display: block;">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="register">
                                <div class="heading">Don't Have an account?</div>
                                <p>Don’t have an account? Create your youturn Account using your email address and password today. </p>
                                <a href="#" class="btn register_btn" id="register_fo">Sign Up</a>
                            </div>
                        </div>
                        <!--login-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="login">
                                <div class="heading">Member Login</div>
                                <form action="" method="post" id="login_form" name="" >
                                   
                                    <div class="form-group">
                                        <input type="text" name="email_verify" value="" class="form-control" placeholder="Email">
                                        <p id="login_msg " class="text-capitalize text-danger"><?php echo $msg; ?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_check" value="" class="form-control" placeholder="Password">
                                         
                                        <a href="https://www.mandarinresorts.in/user/forgot_password" style="color:#012b72; font-size:13px; float:right;">Forgot your password?</a>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label style="font-weight:400; float:none; text-align:left;" class="sign_up"><input type="checkbox" name="">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="login" id="submit" class="btn">Log In</button>
                                    </div>
                                    <div class="form-group">
                                        <div class="middle"><span>or</span></div>
                                        <div class="facebook">
                                            <a href="#"><img src="images/facebook-icon.png" alt="">Login with Facebook</a>
                                        </div>
                                        <div class="google_plus">
                                            <a href="#"><img src="images/gmail-icon.png" alt="">Login with Gmail</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>

                <!--end login-->

                <div id="register" style="display: none;">
                    <div class="row">
                        <!--login-->
                        <div class="col-sm-12 col-lg-7">
                            <div class="login">
                                <div class="row">
                                    <div class="heading col-sm-12">Member Registration</div>
                                </div>
                                <form action="" method="post" id="registration_form" onsubmit="validations()">
                                    <p id="reg_msg"></p>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="text" name="fname" id="f_name" value="" class="form-control" style="padding-left:15px;" placeholder="Enter Your First Name" onkeyup="FirstNameValidation()" required>
                                            <p class="text-danger  text-capitalize" id="f_nameError"> </p>
                                            <p class="text-success text-capitalize" id="f_name_sucess"></p>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <input type="text" name="lname" id="l_name" value="" class="form-control" style="padding-left:15px;" placeholder="Enter Your Last Name" onkeyup="LastNameValidation()" required>
                                            <p class="text-danger text-capitalize" id="l_nameError"></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="email" name="email" id="email" value="" class="form-control" placeholder="Enter Your Email" onkeyup="emailVal()" required>
                                            <p class="text-danger text-capitalize" id="emailError"></p>
                                             
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <select class="form-control" name="country" id="country" oninput="counVal()" required>
                                                <option value="">Select Country</option>
                                                <!-- Adding Country Name and Country code -->
                                                <?php
                                                $selCon = "select * from country ";
                                                $run = mysqli_query($conn, $selCon);
                                                while ($conData = mysqli_fetch_assoc($run)) { ?>
                                                    <option value="+<?php echo $conData['phonecode']; ?>"> <?php echo $conData['name']; ?><span style="color: blue;" name="c_code"> (+<?php echo $conData['phonecode']; ?>)</span> </option>
                                                <?php  } ?>

                                            </select>
                                            <p class="text-danger text-capitalize" id="countryError"></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="text" name="phone" id="phone" value="" class="form-control" placeholder="Enter Your Phone" onkeyup="phoneVal()" required>
                                            <p class="text-danger text-capitalize" id="phoneError"></p>
                                        </div>
                                        <div class="form-group col-sm-6 date">
                                            <input type="date" name="date" oninput="dateVal()" required>
                                            <p class="text-danger text-capitalize" id="dateError"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="password" name="password" id="password" value="" class="form-control" placeholder="Enter Your Password" onkeyup="passVal()" required>
                                            <p class="text-danger text-capitalize" id="passError"></p>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <input type="password" name="con_password" id="con_password" value="" class="form-control" placeholder="Enter Your Confirm Password" onkeyup="cpassVal()" required>
                                            <p class="text-danger text-capitalize" id="con_passError"></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label style="font-weight:400; float:none; text-align:left;" class="sign_up"><input type="checkbox" name="">I have read terms of service & Privacy statement</label>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-sm-12">
                                            <button type="submit" name="submit" id="submitRejis" onclick="validations()"   class="btn">Register</button>
                                        </div>
                                    </div>
                                     
                                </form>
                            </div>
                        </div>
                        <!--end login-->
                        <div class="col-lg-5 col-sm-12">
                            <div class="register">
                                <div class="heading">Have an account?</div>
                                <p>Log in using the email address and password you registered with in order to access your youturn Account.</p>
                                <a href="#" class="btn register_btn" id="login_fo">Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--footer start-->
<?php include('includes/footer.php')
?>