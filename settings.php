<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>

<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/main.css">
<style type="text/css">
		*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: 'Nunito', sans-serif;
  color: #384047;
}

form {
  max-width: 300px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #f4f7f8;
  border-radius: 8px;
}

h1 {
  margin: 0 0 30px 0;
  text-align: center;
}

input[type="text"],
input[type="password"],
input[type="date"],
input[type="datetime"],
input[type="email"],
input[type="number"],
input[type="search"],
input[type="tel"],
input[type="time"],
input[type="url"],
textarea,
select {
  background: rgba(255,255,255,0.1);
  border: none;
  font-size: 16px;
  height: auto;
  margin: 0;
  outline: 0;
  padding: 15px;
  width: 100%;
  background-color: #e8eeef;
  color: #8a97a0;
  box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
  margin-bottom: 30px;
}

input[type="radio"],
input[type="checkbox"] {
  margin: 0 4px 8px 0;
}

select {
  padding: 6px;
  height: 32px;
  border-radius: 2px;
}

button {
  padding: 19px 39px 18px 39px;
  color: #FFF;
  background-color: #4bc970;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #3ac162;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
  margin-bottom: 10px;
}

fieldset {
  margin-bottom: 30px;
  border: none;
}

legend {
  font-size: 1.4em;
  margin-bottom: 10px;
}

label {
  display: block;
  margin-bottom: 8px;
}

label.light {
  font-weight: 300;
  display: inline;
}

.number {
  background-color: #5fcf80;
  color: #fff;
  height: 30px;
  width: 30px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}

.error {
color: #FF0000;
font-size: 15px;
}

@media screen and (min-width: 480px) {

  form {
    max-width: 480px;
  }

}
</style>
</head>
<body>
	<?php
		$uname=$_GET['uname'];
		$url="http://localhost/settings.php?uname=".$uname;
		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
		mysql_select_db("fitness", $con);
		$sql="SELECT password, email, age, weight, height from user WHERE name = '".$uname."' ";
		$result=mysql_query($sql,$con);
		$row=mysql_fetch_array($result);
		$pass=$row["password"];
		$oldpass=$pass;
		$email=$row["email"];
		$oldemail=$email;
		$age=$row["age"];
		$oldage=$age;
		$wt=$row["weight"];
		$oldwt=$wt;
		$ht=$row["height"];
		$oldht=$ht;
	?>
	
	<?php
		// define variables and set to empty values
		$passErr = $emailErr = $ageErr = $wtErr = $htErr = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$nextPage=true;
			if (empty($_POST["password"]))
			{
				$passErr = "Password is required";
				$nextPage=false;
			} 
			else
			{
				// check if name only contains letters,numbers and allowed special chars
				$pass = test_input($_POST["password"]);
				if (!preg_match("/^[a-z0-9_$@&#]*$/",$pass))
				{
					$passErr = "Only small letters, numbers, _, $, @, &, #  are allowed";
					$nextPage = false;
				}
				else
				if( strlen($pass) < 8 )
				{
					$passErr = "Minimum length should be 8 characters";
					$nextPage = false;
				} 
			}
  
			if (empty($_POST["email"]))
			{
				$emailErr = "Email is required";
				$nextPage=false;
			} 
			else
			{
				$email = test_input($_POST["email"]);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$emailErr = "Invalid email format";
					$nextPage=false;
				}
				else
				{
					$sql="SELECT name, email FROM user";
					$result=mysql_query($sql,$con);

					while($row=mysql_fetch_array($result))
					{
						if( strcasecmp( $row["email"] , $email ) == 0 && strcasecmp( $row["name"] , $uname ) != 0)
						{
							$nextPage = false;
							$emailErr = "This email id already exists, please use another email id!";
							break;
						}
					}
				}
			}
			if (empty($_POST["age"]))
			{
				$ageErr = "Age is required";
				$nextPage=false;
			} 
			else
			{
				$age = test_input($_POST["age"]);
			}
   
			if (empty($_POST["weight"]))
			{
				$wtErr = "Weight is required";
				$nextPage=false;
			} 
			else
			{
				$wt = test_input($_POST["weight"]);
			}
   
			if (empty($_POST["height"]))
			{
				$htErr = "Height is required";
				$nextPage=false;
			} 
			else
			{
				$ht = test_input($_POST["height"]);
			}
			if($nextPage==true)
			{
				if( strcmp ( $oldpass , $pass ) != 0 )
				{
					$sql="UPDATE user SET password = '".$pass."' WHERE name = '".$uname."'";
					if (!mysql_query($sql,$con))
					{
						header('Location: http://localhost/fail.html');
						exit();
					}	
				}
				if( strcmp ( $oldemail , $email ) != 0 )
				{
					$sql="UPDATE user SET email = '".$email."' WHERE name = '".$uname."'";
					if (!mysql_query($sql,$con))
					{
						header('Location: http://localhost/fail.html');
						exit();
					}	
				}
				if( strcmp ( $oldage , $age ) != 0 )
				{
					$sql="UPDATE user SET age = '".$age."' WHERE name = '".$uname."'";
					if (!mysql_query($sql,$con))
					{
						header('Location: http://localhost/fail.html');
						exit();
					}	
				}
				if( strcmp ( $oldwt , $wt ) != 0 )
				{
					$sql="UPDATE user SET weight = '".$wt."' WHERE name = '".$uname."'";
					if (!mysql_query($sql,$con))
					{
						header('Location: http://localhost/fail.html');
						exit();
					}	
				}
				if( strcmp ( $oldht , $ht ) != 0 )
				{
					$sql="UPDATE user SET height = '".$ht."' WHERE name = '".$uname."'";
					if (!mysql_query($sql,$con))
					{
						header('Location: http://localhost/fail.html');
						exit();
					}	
				}
				header('Location: http://localhost/login.php');
				exit();
				mysql_close($con);
			}
		}
		
		function test_input($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>
	<form method="post" action=<?php echo $url;?> >
      
        <h1>Sign Up</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
          <label for="mail">Email:</label>
          <input type="email" id="mail" name="email" value="<?php echo $email;?>" />
		  <span class="error"><?php echo $emailErr;?> </span>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" value="<?php echo $pass;?>" /> 
		  <span class="error"><?php echo $passErr;?> </span>
        </fieldset>
        
        <fieldset>
          <legend><span class="number">2</span>Your profile</legend>
          <label>Age:</label>
          <input type="text" name="age" value="<?php echo $age;?>" />
		  <span class="error"><?php echo $ageErr;?> </span>
		  <label>Weight (in kg):</label>
          <input type="text" name="weight" value="<?php echo $wt;?>" />
		  <span class="error"><?php echo $wtErr;?> </span>
		  <label>Height (in cm):</label>
          <input type="text" name="height" value="<?php echo $ht;?>" />
		  <span class="error"><?php echo $htErr;?> </span>
		  </label> 
        </fieldset>
		
        <button type="submit">Change</button>
      </form>
			