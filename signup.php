<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up Form</title>

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
<?php
// define variables and set to empty values
$nameErr = $passErr = $emailErr = $genderErr = $ageErr = $wtErr = $htErr = "";
$name = $pass = $email = $gender = $age = $wt = $ht = $plan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   $nextPage=true;
   if (empty($_POST["uname"]))
   {
     $nameErr = "Name is required";
	 $nextPage=false;
   } 
   else
   {
     $name = test_input($_POST["uname"]);
     // check if name only contains letters and numbers
     if (!preg_match("/^[a-z0-9]*$/",$name))
	 {
       $nameErr = "Only small letters and numbers allowed";
	   $nextPage=false;
     }
	 else
	 {
		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
	
		else
		{
			mysql_select_db("fitness", $con);
	
			$sql="SELECT name FROM user";
			$result=mysql_query($sql,$con);

			while($row=mysql_fetch_array($result))
			{
				if( strcasecmp( $row["name"] , $name ) == 0 )
				{
					$nextPage = false;
					$nameErr = "This user name already exists, please select another name!";
					break;
				}
			}
		}
	 }
   }
   
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
		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
		mysql_select_db("fitness", $con);
	
			$sql="SELECT email FROM user";
			$result=mysql_query($sql,$con);

			while($row=mysql_fetch_array($result))
			{
				if( strcasecmp( $row["email"] , $email ) == 0 )
				{
					$nextPage = false;
					$emailErr = "This email id already exists, please use another email id!";
					break;
				}
			}
	 }
   }

   if (empty($_POST["gender"]))
   {
     $genderErr = "Gender is required";
	 $nextPage=false;
   } 
   else
   {
     $gender = test_input($_POST["gender"]);
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
   
   $plan = test_input($_POST["plan"]);
   
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
			mysql_select_db("fitness", $con);
	
			$sql="INSERT INTO user (name, password, email, age, weight, height, gender, plan) VALUES ('$_POST[uname]','$_POST[password]','$_POST[email]','$_POST[age]','$_POST[weight]','$_POST[height]','$_POST[gender]','$_POST[plan]')";
			if (!mysql_query($sql,$con))
			{
				header('Location: http://localhost/fail.html');
				exit();
			}
			else
			{
				header('Location: http://localhost/success.html');
				exit();
			}	

			mysql_close($con);
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
	<body>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      
        <h1>Sign Up</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
          <label>Username:</label>
          <input type="text" name="uname" value="<?php echo $name;?>" />
		  <span class="error"><?php echo $nameErr;?> </span>
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
		  <label>Gender:
          <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
		  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male" >Male
		  <span class="error"><?php echo $genderErr;?> </span>
		  </label> 
        </fieldset>
		
        <fieldset>
        <label for="plan">Select a plan:</label>
        <select id="plan" name="plan">
          <optgroup label="Fitness Plans">
            <option value="Fat Burn">Fat Burn</option>
            <option value="Weight Gain">Weight Gain</option>
            <option value="Muscle Building">Muscle Building</option>
            <option value="General Fitness">General Fitness</option>
          </optgroup>
        </select>  
        </fieldset>
		
        <button type="submit">Sign Up</button>
      </form>
      
    </body>
</html>