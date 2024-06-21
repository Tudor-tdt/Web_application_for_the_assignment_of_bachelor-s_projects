<?php

include("student_auth.php");
require('db.php');

$query = "SELECT nume_profesor FROM `profesori`";
$result = mysqli_query($con, $query) or die(mysql_error());

$query1 = "SELECT * FROM studenti WHERE nume_student = '" . $_SESSION['username'] . "'";
$result1 = mysqli_query($con, $query1);
$rows1 = mysqli_fetch_array($result1);

$id_prev = $rows1['id'] - 1;

$query2 = "SELECT * FROM studenti WHERE id = " . $id_prev;
$result2 = mysqli_query($con, $query2);
$rows2 = mysqli_fetch_array($result2);

$query3 = "SELECT * FROM studenti WHERE id = ( SELECT MAX(id) FROM studenti )";
$result3 = mysqli_query($con, $query3);
$rows3 = mysqli_fetch_array($result3);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<title>Projects</title>
</head>
<body>
<style type="text/css">
body {
  font-family:Arial, Sans-Serif;
  background: url(electronics_3.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
.logout{
  color:#cccc00;
  text-decoration:none;
}
.logout:hover{
  text-decoration:underline;
}
.linkk{
	color: black;
	text-decoration: none;
}
h1, h2{
	color: white;
}
.form{
	display: block;
  width: 40%;
  margin: 0 auto;
  text-align: center;
}
.prof{
	background:#4d94ff;
	border-top-left-radius:30px;
	border-bottom-right-radius:30px;
	border-bottom-left-radius:30px;
	border-top-right-radius:30px;

	text-align: center;
	margin: auto;
  width: 40%;
  border: 3px solid #999900;
  padding: 10px;
 	cursor: pointer;
}
.prof:hover {
	background-color: #0066ff;
}
</style>

<?php

if($rows1['id'] > 1 && $rows2['aplicat'] == 1 && $rows3['aplicat'] == 0 || $rows1['id'] == 1 && $rows3['aplicat'] == 0){
	echo "<div class='form'><h1>Bine ai venit " . $_SESSION['username'] . "!</h1>
	<h2>Alege îndrumătorul de licență.</h2></div>";
} else{
	echo "<div class='form'><h1>Bine ai venit " . $_SESSION['username'] . "!</h1>
	<h2>Trebuie să aștepți până când aplică studenții dinaintea ta.</h2>
	</div>";
}

?>

<br><br>

<?php if($rows1['id'] > 1 && $rows2['aplicat'] == 1 && $rows3['aplicat'] == 0 || $rows1['id'] == 1 && $rows3['aplicat'] == 0){ ?>

	<?php while($row=mysqli_fetch_array($result)): ?>

		<div class='prof' onclick="teacher_name('<?= $row[0] ?>')">
			<a class='linkk' href="alege_proiect.php">
				<?= $row[0] ?>
		</div>
		<br>
		
	<?php endwhile ?>

<?php } ?>

<p style="text-align: right; display: block;"><a class="logout" href="students_logout.php">Logout</a></p>

<script type="text/javascript">

function teacher_name(name){
	document.cookie = "username="+ name;
}

</script>

</body>
</html>