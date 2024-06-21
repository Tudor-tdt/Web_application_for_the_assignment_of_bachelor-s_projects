<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Students Login</title>
</head>
<body>

<style type="text/css">
body {
  font-family:Arial, Sans-Serif;
  background: url(electronics.jfif) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
a{
     color:#0067ab;
     text-decoration:none;
}
a:hover{
     text-decoration:underline;
}
.form{
	position: fixed;
  	top: 50%;
  	left: 50%;
  	transform: translate(-50%, -50%);
  	-webkit-transform: translate(-50%, -50%);
 	-moz-transform: translate(-50%, -50%);
  	-o-transform: translate(-50%, -50%);
  	-ms-transform: translate(-50%, -50%);
     background:#4d94ff;
	border-top-left-radius:30px;
	border-bottom-right-radius:30px;
	border-bottom-left-radius:30px;
	border-top-right-radius:30px;
	text-align: center;
	margin: auto;
	width: 300px;
	border: 3px solid #0067ab;
	padding: 10px;
}
input[type='text'], input[type='email'],
input[type='password'] {
     width: 200px;
     border-radius: 2px;
     border: 1px solid #CCC;
     padding: 10px;
     color: #333;
     font-size: 14px;
     margin-top: 10px;
}
input[type='submit']{
     padding: 10px 25px 8px;
     color: #fff;
     background-color: #0067ab;
     text-shadow: rgba(0,0,0,0.24) 0 1px 0;
     font-size: 16px;
     box-shadow: rgba(255,255,255,0.24) 0 2px 0 0 inset,#fff 0 1px 0 0;
     border: 1px solid #0164a5;
     border-radius: 2px;
     margin-top: 10px;
     cursor:pointer;
}
input[type='submit']:hover {
     background-color: #024978;
}
</style>

<?php
require('db.php');
session_start();

$query3 = "SELECT * FROM studenti WHERE id = (SELECT MAX(id) FROM studenti)";
$result3 = mysqli_query($con, $query3);
$rows3 = mysqli_fetch_array($result3);

// Daca apasam pe 'Login', inseram datele in baza de date.
if (isset($_POST['username'])){
        // stergem backslashes-urile
	$username = stripslashes($_REQUEST['username']);
        // stergem caracterele speciale dintr-un string
	$username = mysqli_real_escape_string($con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
	//verificam daca user-ul exista sau nu in baza de date
     $query = "SELECT * FROM `studenti` WHERE nume_student ='$username' and parola='".$password."'";
	$result = mysqli_query($con, $query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	$rows_fetch = mysqli_fetch_array($result);
	$query2 = "SELECT * FROM aplicari WHERE nume_student = " . $rows_fetch['id'];
	$result2 = mysqli_query($con, $query2);
	$rows2 = mysqli_fetch_array($result2);
	
	if($rows==0){
		echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='index.php'>Login</a></div>";
	} elseif($rows2>=1 && $rows3['aplicat'] == 0){
		echo "<div class='form'>
<h3>Ati aplicat pentru proiectul de licenta.</h3>
<br/>Click here to <a href='index.php'>Login</a></div>";
	} elseif($rows2>=1 && $rows3['aplicat'] == 1){
		header("Location: repartitie_finala.php");
	}elseif($rows==1 && $rows2==0 && $rows3['aplicat'] == 0) {
	    $_SESSION['username'] = $username;
	    header("Location: alege_indrumator.php");
	}
    }else{
?>
<div class="form">
<h1>Students Login</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p>Are you a teacher? <a href='Teachers Login_prof.php'>Login Here</a></p>
</div>
<?php } ?>
</body>
</html>