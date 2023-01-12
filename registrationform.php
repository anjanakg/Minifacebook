<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>User Registration Form</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
    <div class="container">
        <h2>Register for a new Account</h2>

<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
        <form action="addnewuser.php" method="POST" class="form login">
            <div class="user-details">
                <div class="input-box">
                  <span class="details">Username</span>
                  <input type="text" class="text_field" name="username" required
                    pattern="[A-Za-z]{3,20}"
                    title="Please enter a valid username" 
                    placeholder="Your username"
                    onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
                    <br>
                </div>
                <div class="input-box">
                  <span class="details">Email</span>
                  <input type="email" class="text_field" name="email" required
                  pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                  title="Please enter a valid email" 
                  placeholder="Your email"
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
                  <br>
                </div>
                <div class="input-box">
                  <span class="details">Password</span>
                  <input type="password" class="text_field" name="password" required
                  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                  placeholder="Your password"
                  title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: ''); form.repassword.pattern =this.value;"/> 
                  <br>
                  </div>
                <div class="input-box">
                  <span class="details">Retype Password</span>
                  <input type="password" class="text_field" name="repassword"
                  placeholder="Retype your password" required
                  title="Password does not match"
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/> 
                  <br>
                </div>
                <div class="input-box">
                  <span class="details">First Name</span>
                  <input type="text" class="text_field" name="fname" required pattern="[A-Za-z]{3,20}" 
                  placeholder="Your First Name"
                  title="Please enter only alphabets"
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
                  <br>
                  </div>
                <div class="input-box">
                  <span class="details">Last Name</span>
                  <input type="text" class="text_field" name="lname" required pattern="[A-Za-z]{3,20}"
                  placeholder="Your Last Name" 
                  title="Please enter only alphabets"
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
                  <br>
                </div>
                <div class="input-box">
                  <span class="details">Phone Number</span>
                  <input type="text" class="text_field" name="phonenumber" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" 
                  placeholder="000-000-0000"
                  title="Please enter your phone number" 
                  onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" /> 
                  <br>
                </div>
                <div class="input-box">
                  <span class="details">Date of Birth</span>
                  <input type="date" name="DOB" max="2022-01-01" required />
                  <br> 
                </div>
                <div class="input-box">
                   <span class="details">Gender</span>
                  <select id="gender" name="gender">
                    <option disabled selected>Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Others</option>
                  </select>
                  <br>
                </div>
            </div>
              <div class="button">
                <input type = "submit" value="Register">
              </div>
              <div class="text">
                <h3>Already have an account?<a href="form.php">Login here</a></h3>
              </div>
        </form>
    </div>
  </body>
</html>

