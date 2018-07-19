<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Fitness Plan</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
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

table {
  max-width: 960px;
  margin: 10px auto;
}

caption {
  font-size: 1.6em;
  font-weight: 400;
  padding: 10px 0;
}

thead th {
  font-weight: 400;
  background: #8a97a0;
  color: #FFF;
}

tr {
  background: #f4f7f8;
  border-bottom: 1px solid #FFF;
  margin-bottom: 5px;
}

tr:nth-child(even) {
  background: #e8eeef;
}

th, td {
  text-align: left;
  padding: 20px;
  font-weight: 300;
}

tfoot tr {
  background: none;
}

tfoot td {
  padding: 10px 2px;
  font-size: 0.8em;
  font-style: italic;
  color: #8a97a0;
}
nav p{
	display:inline:block;
	float:right;
	padding:10px;
}
button {
  padding: 12px 12px 12px 12px;
  background: #8a97a0;
  color: #FFF;
  font-size: 16px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  
  
  border-width: 1px 1px 3px;
  
  margin-bottom: 10px;
  margin-left:500px;
}
fieldset {
  margin-left:400px;
  border: none;
}	

	
	</style>
  </head>
  <body>
  <?php 
  $uname=$_GET['uname']; ?>
  <?php
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$uname= test_input($_POST["uname"]);
		$plan = test_input($_POST["plan"]);
		
		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
	
		else
		{
			mysql_select_db("fitness", $con);
	
			$sql="UPDATE user SET plan = '".$plan."' WHERE name = '".$uname."'";
			if (!mysql_query($sql,$con))
			{
				header('Location: http://localhost/fail.html');
				exit();
			}
			mysql_close($con);
		}
		
		if(strcasecmp ($plan, "Weight Gain") == 0 )
			$str="Location: http://localhost/weightgain.php?uname=".$uname;
		else
		if(strcasecmp ($plan, "Muscle Building") == 0 )
			$str="Location: http://localhost/musclebuild.php?uname=".$uname;	
		else
			$str="Location: http://localhost/fatburn.php?uname=".$uname;
					
		header($str);
		exit();
	}	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
  ?>
    <?php
		$str="";
		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
			header('Location: http://localhost/fail.html');
			exit();
		}
	
		else
		{
			mysql_select_db("fitness", $con);
	
			$sql="SELECT weight, height FROM user WHERE name = '".$uname."'";
			$result=mysql_query($sql,$con);
			if(!$result)
			{
				header('Location: http://localhost/fail.html');
				exit();
			}
			$row=mysql_fetch_array($result);
			$wt=$row["weight"];
			$ht=$row["height"];
			mysql_close($con);
		}
		
		if($wt>0 && $ht>0)
		{
			$finalBMI=$wt/($ht/100*$ht/100);
			if($finalBMI<18.5)
				$str="Your BMI is: ".$finalBMI."\nYou are too thin. Recommended weight gain";
			else
			if($finalBMI>18.5 && $finalBMI<25)
				$str="Your BMI is: ".$finalBMI."\nYou are healthy. Recommended Muscle Build / General Fitness";
			else
				$str="Your BMI is: ".$finalBMI."\nYou are overweight. Recommended Fat Burn";
		}
	?>
	<nav>
		<p><a href="index.html" class="current">Logout</a></p>
		<?php $url = "http://localhost/settings.php?uname=".$uname; ?>
		<p><a href=<?php echo $url ?> class="current"><?php echo $uname ?></a></p>
	</nav>


    <table>
      <caption>General Fitness<br><i>(5-Day Split)</i></caption>
	  
      <thead>
        <tr>
          <th scope="col">Day </th>
          <th scope="col">Workout 1</th>
		  <th scope="col">Workout 2</th>
		  <th scope="col">Workout 3</th>
		  <th scope="col">Workout 4</th>
		  <th scope="col">Workout 5</th>
          
        </tr>
      </thead>
      
      <tbody>
        <tr>
          <th scope="row">Day 1</th>
          <td>Jogging</td>
          <td>Plank</td>
		  <td>Streching</td>
		  <td>Dead Lift</td>
		  <td>Bent Over</td>
        </tr>
        <tr>
          <th scope="row">Day 2</th>
          <td>Jogging</td>
          <td>Cycling</td>
		  <td>Butterfly Curl</td>
		  <td>Side Lateral Bent</td>
		  <td>Squats</td>
        </tr>
        <tr>
          <th scope="row">Day 3</th>
          <td>Jogging</td>
          <td>Cross Trainer</td>
		  <td>Dumbell Front Raise</td>
		  <td>Lateral Raise</td>
		  <td>Ab Roller</td>
        </tr>
        <tr>
          <th scope="row">Day 4</th>
          <td>Jogging</td>
          <td>Cycling</td>
		  <td>Tricep Kickback</td>
		  <td>Leg Press</td>
		  <td>Cross Over</td>
        </tr>
		<tr>
		  <th scope="row">Day 5</th>
          <td>Squats</td>
          <td>Jogging</td>
		  <td>Leg Press</td>
		  <td>Triceps Pulldown</td>
		  <td>Bench Dips</td>
		</tr>
      </tbody>
    </table>
	
	<p style="margin-left:200px;"><?php echo $str ?><br></p>
	
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<fieldset>
        <label for="plan">Change Plan</label>    
        <select id="plan" name="plan">
            <option value="Weight Gain">Weight Gain</option>
            <option value="Muscle Building">Muscle Building</option>
            <option value="Fat Burn">Fat Burn</option>
        </select>
	</fieldset>
	<input type="hidden" name="uname" value= <?php echo $uname; ?> />
	<button type="submit">Change</button>
      </form>
    
  </body>
</html>
