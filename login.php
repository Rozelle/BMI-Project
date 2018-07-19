<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
        
<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
        
<style type="text/css">
.login-page {
		
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #f0f0f0;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #405580;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #405580;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #405580; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #405580, #8DC26F);
  background: -moz-linear-gradient(right, #405580, #8DC26F);
  background: -o-linear-gradient(right, #405580, #8DC26F);
  background: linear-gradient(to left, #405580, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}

.error {
	color: #FF0000;
	font-size: 15px;
}

</style>
</head>
<?php
// define variables and set to empty values
$nameErr = $passErr = "";
$name = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   $nextPage=true;
   if (empty($_POST["uname"]))
   {
     $nameErr = "Name is required";
	 $nextPage=false;
   } 
   
   if (empty($_POST["password"]))
   {
     $passErr = "Password is required";
	 $nextPage=false;
   } 
  
   if($nextPage==true)
   {
	    $con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
	
		else
		{
			$name = test_input($_POST["uname"]);
			$pass = test_input($_POST["password"]);
			
			mysql_select_db("fitness", $con);
		    $sql="SELECT name, password, plan from user WHERE name = '$_POST[uname]' ";
			$result=mysql_query($sql,$con);
			if( $row=mysql_fetch_array($result) )
			{
				if( strcmp( $row["password"] , $pass) == 0 )
				{
					$plan=$row["plan"];
					
					if(strcasecmp ($plan, "Fat Burn") == 0 )
						$str="Location: http://localhost/fatburn.php?uname=".$row["name"];
					else
					if(strcasecmp ($plan, "Weight Gain") == 0 )
						$str="Location: http://localhost/weightgain.php?uname=".$row["name"];
					else
					if(strcasecmp ($plan, "Muscle Building") == 0 )
						$str="Location: http://localhost/musclebuild.php?uname=".$row["name"];
					else
						$str="Location: http://localhost/generalfitness.php?uname=".$row["name"];
					
					header($str);
					exit();
				}
				else
				{
					$passErr = "Incorrect password";
					$nextPage = false;
				}
			}
			else
			{
				$nameErr = "Incorrect user name";
				$nextPage = false;
			}
		}
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<div class="login-page">
  <div class="form">
    <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
      <input type="text" placeholder="username" name="uname" value="<?php echo $name;?>" /><br>
	  <span class="error"> <?php echo $nameErr;?></span><br>
      <input type="password" placeholder="password" name="password" value="<?php echo $pass;?>" /><br>
	  <span class="error"> <?php echo $passErr;?></span><br>
      <button>login</button><br>
      <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
    </form>
  </div>
</div>