<?php

require('db.php');
include("student_auth.php");

$tch_nm = $_COOKIE["username"];

$sql_titular = "SELECT * FROM profesori WHERE nume_profesor = '$tch_nm'";
$result_titular = mysqli_query($con, $sql_titular);
$row_id = mysqli_fetch_array($result_titular);

$query = "SELECT * FROM teme WHERE titular = " . $row_id['id'];
$result = mysqli_query($con, $query);

$nr_pr = 0;

$query2 = "SELECT locuri_ramase FROM profesori WHERE nume_profesor = '" .$_COOKIE["username"]. "'";
$result2 = mysqli_query($con, $query2);
$row = mysqli_fetch_assoc($result2);

echo "<br><br><br><h1 id='msj' style='text-align: center; margin: auto; display: none; color: white;'>Ati aplicat cu succes!!</h1>";

echo "<br><br><br><h1 id='lc_rms' style='text-align: center; margin: auto; display: none; color: white;'>". $_COOKIE["username"] ." nu mai are locuri disponibile.</h1>";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Projects Manager</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
.prof{
	display: block;
	background:#4d94ff;
	border-top-left-radius:30px;
	border-bottom-right-radius:30px;
	border-bottom-left-radius:30px;
	border-top-right-radius:30px;
	text-align: center;
	margin: auto;
	width: 80%;
	min-height: 500px;
	border: 3px solid #999900;
	padding: 10px;
}
.widnow{
	display: block;
    width: 80%;
    margin: auto;
    border: 2px solid black;
    background: whitesmoke;
    border-top-left-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border-top-right-radius:10px;
}
.title_bar{
	cursor: pointer;
    background: whitesmoke;
    height: 60px;
    width: 100%;
    border-top-left-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border-top-right-radius:10px;
}
.box{
    height: auto;
    background: whitesmoke;
    display: none;
    margin-left: auto;
    margin-right: auto;
    border-top-left-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border-top-right-radius:10px;
}
.aplica {
  padding: 10px 25px 8px;
  color: #fff;
  background-color: #00e600;
  text-shadow: rgba(0,0,0,0.24) 0 1px 0;
  font-size: 16px;
  box-shadow: rgba(255,255,255,0.24) 0 2px 0 0 inset,#fff 0 1px 0 0;
  border: 1px solid #0164a5;
  border-radius: 2px;
  margin-top: 10px;
  cursor:pointer;
}
.aplica:hover {
  background-color: #009900;
}
</style>

<div class="prof">
<?php

echo "<h1>Alegeti un proiect de la " .$_COOKIE["username"]. ".</h1><br>";

echo "<div style='width: 80%; margin: auto; text-align: left; display: block;'><h2 id='dispare'>Locuri disponibile: " .$row["locuri_ramase"]. "</h2></div>";

$nr_loc = $row["locuri_ramase"];
if($nr_loc <= 0){
	echo "<script type='text/javascript'>$('.prof').css('display', 'none');</script>";
	echo "<script type='text/javascript'>$('#lc_rms').css('display', 'block');</script>";
}

?>
<br>

<?php while($row1=mysqli_fetch_array($result)): ?>

	<?php

	if(isset($_POST["submit" . $nr_pr])){
		$nr_loc --;
		$query3 = "UPDATE profesori SET locuri_ramase = '$nr_loc' WHERE nume_profesor = '" .$_COOKIE["username"]. "'";
		mysqli_query($con, $query3);
		echo "<script type='text/javascript'>$('.prof').css('display', 'none');</script>";
		echo "<script type='text/javascript'>$('#msj').css('display', 'block');</script>";
		$query6 = "SELECT * FROM teme WHERE titlu_proiect = '" .$row1['titlu_proiect']. "'";
		$result6 = mysqli_query($con, $query6);
		$row6 = mysqli_fetch_array($result6);
		$query7 = "SELECT * FROM studenti WHERE nume_student = '" .$_SESSION['username']. "'";
		$result7 = mysqli_query($con, $query7);
		$row7 = mysqli_fetch_array($result7);
		$query4 = "INSERT INTO aplicari (nume_student, nume_profesor, tema_proiect) VALUES ('" .$row7['id']. "', '" .$row6['titular']. "', '" .$row6['id']. "')";
		mysqli_query($con, $query4);
		$query5 = "UPDATE studenti SET aplicat = 1 WHERE nume_student = '" .$_SESSION['username']. "'";
		mysqli_query($con, $query5);
		header('Refresh: 2; URL=index.php');
	}

	?>

	<div class="widnow">
    <div id="btn<?=$nr_pr?>" class="title_bar">
    	<br>
    	<?= $row1['titlu_proiect'] ?>
    </div>
    <div id="bx<?=$nr_pr?>" class="box">
    	<?= $row1['detalii_proiect'] ?>
    	<div style="text-align: right; padding: 10px;">
    		<form method="post">
    			<input class="aplica" name="submit<?=$nr_pr?>" type="submit" value="Aplica" />
    		</form>
    	</div>
    </div>
	</div>
	<br><br>

	<script type="text/javascript">
		
		$("#btn<?=$nr_pr?>").click(function(){
    		$("#bx<?=$nr_pr?>").slideToggle();
		});

	</script>

	<?php $nr_pr++; ?>

<?php endwhile ?>

</div>

<p style="text-align: right; display: block;"><a class="logout" href="students_logout.php">Logout</a></p>

</script>
</body>
</html>