<?php
// Include config file
$servername = "aa1j2ay19mvo8dl.cew1fvzp06l6.us-east-2.rds.amazonaws.com";
$username = "cap";
$password = "capstonedb";

try {
  $conn = new PDO("mysql:host=$servername;dbname=ebdb", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";
  }catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
 
// Define variables and initialize with empty values
$name = $upassword = $confirm_password = $email = "";
$name_err = $upassword_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT idusers FROM test WHERE name = :name";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $name_err = "This username is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["upassword"]))){
        $upassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["upassword"])) < 6){
        $upassword_err = "Password must have atleast 6 characters.";
    } else{
        $upassword = trim($_POST["upassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($upassword_err) && ($upassword != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if (empty($_POST["email"])) {
    $email_err = "Email is required";
  } else {
    $email = trim($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
  }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($upassword_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO test (name, email, upassword) VALUES (:name, :email, :upassword)");
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":upassword", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($upassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        
    }
    
    // Close connection
    unset($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    * {
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    }

    .wrapper { 
    width: 350px; 
    padding: 20px;
    position: relative;
    left: -25px;
    display: inline-block;
    text-align: right;
}

.wrapper__button { 
    width: 350px; 
    padding: 20px;
    position: relative;
    left: 395px;
    top: -50px;
}

body {
  margin: 0;
  background-color: lightseagreen;
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav b {
    position: center;
    display: block;
    color: #f2f2f2;
    text-align: center;
    left: -100px;
    padding: 14px 16px;
    text-decoration: none;
}

/* Style the content */
.content {
  background-color: #ddd;
  padding: 10px;
  height: 200px; /* Should be removed. Only for demonstration */
}

/* Style the footer */
.footer {
  background-color: #f1f1f1;
  padding: 10px;
}


h1 {
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 180%;
}

h2 {
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 150%;
}

p  {
  text-align: center;
  color: black;
  font-family: verdana;
  font-size: 100%;
}

div {
  text-align: center;
}
    </style>
</head>
<body>

<div class="topnav">
  <a href="#">About</a>
  <a href="#">Contact</a>
  <a href="#">Help</a>
  <b href='#'>Public Transit Ticket System</b>
</div>

<div class="container">
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="upassword" class="form-control <?php echo (!empty($upassword_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $upassword; ?>">
                <span class="invalid-feedback"><?php echo $upassword_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</div>
</body>
</html>