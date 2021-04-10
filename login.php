<?php
// Start the session
session_start();

 
// check for previous session, if they are put to post login page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}


 
// Check if form submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $servername = "aa1j2ay19mvo8dl.cew1fvzp06l6.us-east-2.rds.amazonaws.com";
    $username = "cap";
    $password = "capstonedb";
 try {
  //database connection
  $conn = new PDO("mysql:host=$servername;dbname=ebdb", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $name = $upassword = "";
  $name_err = $upassword_err = $login_err = "";
 
    // check for entered name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter username.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // check for entered password
    if(empty(trim($_POST["upassword"]))){
        $upassword_err = "Please enter your password.";
    } else{
        $upassword = trim($_POST["upassword"]);
    }
    
    // Check for errors
    if(empty($name_err) && empty($upassword_err)){
        // SQL statement
        $sql = "SELECT idusers, name, email, upassword FROM test WHERE name = :name";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // execute sql
            if($stmt->execute()){
                // check if name in database, then confirm password is correct
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                      // get data from database
                        $id = $row["idusers"];
                        $name = $row["name"];
                        $email = $row["email"];
                        $hashed_password = $row["upassword"];
                        if(password_verify($upassword, $hashed_password)){
                            //check password matches
                            session_start();
                            
                            // store db data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;     
                            $_SESSION["email"] = $email;                       
                            
                            // go to welcome page
                            header("location: welcome.php");
                        } else{
                            // issue while logging in
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // issues with name
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

          
            unset($stmt);
        }
    }
    
    unset($conn);


}catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
}
 

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<title>Login</title>
<style>
 /*body{ font: 14px sans-serif; } */
.wrapper { 
    width: 350px; 
    padding: 20px; 
    position: relative;
    left: -25px;
    display: inline-block;
    text-align: right;
}

div { 
    text-align: center; 
    position: relative; 
}

body {
  background-color:lightseagreen;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.button {
  position: relative;
  top: 250px;
  border: none;
  padding: 15px 30px;
  text-align: center;
  text-decoration:linen;
  display: inline-block;
  font-size: 20px;
  margin: 5px 2px;
  cursor: pointer;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}
.button2:hover {
  background-color: #4CAF50;
  color: white;
}
.button3:hover {
  background-color: #4CAF50;
  color: white;
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

.topnav b {
    position: relative;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    left: -100px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
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
  position: relative;
  top: 50px;
  text-align: center;
  font-size: 24px;
  text-transform: uppercase;
  color: #303030;
  font-weight: 600;
  margin-bottom: 30px;
}

h2 {
  position: relative;
  top: 1px;
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 100%;
}

p  {
  text-align: center;
  color: black;
  font-family: verdana;
  font-size: 100%;
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
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

	    <div class="container"></div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="upassword" class="form-control <?php echo (!empty($upassword_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $upassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
                <p>
                     <a href="map.html" class="btn btn-warning">See Bus Stops</a>
                </p>
            </div>
            <p>Don't have an account? <a href="newregister.php">Sign up now</a>.</p>
    </div>
        </form>
    </div>
</body>
</html>