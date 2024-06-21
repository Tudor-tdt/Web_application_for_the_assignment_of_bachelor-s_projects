<?php

require('db.php');
include("teacher_auth_prof.php");

$teacher_name = $_SESSION['username'];

$sql_titular = "SELECT * FROM profesori WHERE nume_profesor = '$teacher_name'";
$result_titular = mysqli_query($con, $sql_titular);
$row_id = mysqli_fetch_array($result_titular);

$query = "SELECT * FROM teme where titular = " . $row_id['id'];
$result = mysqli_query($con, $query);

$nr_pr = 0;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Projects Manager</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.tiny.cloud/1/s2syv3t81n7awnvget0t0v49ehrkqfillgfl9z6q7camt8fb/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector:'textarea',
    menubar: false,
    plugins: 'code',
    toolbar: 'bold italic code'
});
</script>
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
#proiect_nou{
	display: none;
	background: yellowgreen;
	text-align: center;
	margin: auto;
    width: 80%;
    border: 3px solid #999900;
}
#titlu{
	width: 300px;
    border-radius: 2px;
    border: 1px solid #CCC;
    padding: 10px;
    color: #333;
    font-size: 14px;
    margin-top: 10px;
}
#nr_loc{
	width: 40px;
    border-radius: 2px;
    border: 1px solid #CCC;
    padding: 10px;
    color: #333;
    font-size: 14px;
    margin-top: 10px;
}
#save{
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
#save:hover {
	background-color: #024978;
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
#bx{
	height: 450px;
    background: whitesmoke;
    display: none;
    margin-left: auto;
    margin-right: auto;
    border-top-left-radius:10px;
	border-bottom-right-radius:10px;
	border-bottom-left-radius:10px;
	border-top-right-radius:10px;
}
</style>
<div class="prof">
	<h2>Bine ai venit <?php echo $_SESSION['username']; ?>!</h2>
	<br><br>

	<div class="widnow" style="background: #80ff80;">
    <div id="btn" class="title_bar" style="background: #80ff80;">
    	<br>
    	<u>Actualizeaza datele</u>
    </div>
    <div id="bx" style="background: #80ff80;">
    	<form method="get">
    		<p>Numar locuri disponibile: <input id="nr_loc" name="locuri" type="number" min="0" required />   <input name="submit" type="submit" value="Save" /></p>
    	</form>
    	<form method="post">
    	<h2><u>Adauga un proiect nou:</u></h2>
		<p>Titlu proiect: <input id="titlu" name="title" type="text" placeholder="Titlu.." required /></p>
		<div style="width: 70%;margin: auto;">
        	<textarea name="content" placeholder="Detalii proiect.."></textarea>
        </div>
        <button id="save">Salveaza</button>
	</form>
    </div>
	</div>
	<br>

<?php

$query_1 = "SELECT locuri_disponibile FROM profesori WHERE nume_profesor = '$teacher_name'";
$result1 = mysqli_query($con, $query_1);
$row = mysqli_fetch_assoc($result1);
echo "<div id='dispare' style='width: 80%; margin: auto; text-align: left; display: block;'><h2>Numar locuri disponibile: " .$row["locuri_disponibile"]. "</h2></div>";

if(isset($_GET['locuri'])){
	$nr_loc = $_REQUEST['locuri'];
	
	$query4 = "SELECT locuri_disponibile FROM profesori WHERE nume_profesor = '$teacher_name'";
	$result4 = mysqli_query($con, $query4);
	$row4 = mysqli_fetch_assoc($result4);
	$loc_dsp_initial = $row4["locuri_disponibile"];

	$query2 = "SELECT locuri_ramase FROM profesori WHERE nume_profesor = '$teacher_name'";
	$result2 = mysqli_query($con, $query2);
	$row2 = mysqli_fetch_assoc($result2);
	$loc_rms_initial = $row2["locuri_ramase"];

	$loc_disp_ramase = $loc_rms_initial + ($nr_loc - $loc_dsp_initial);

	$query1 = "UPDATE profesori SET locuri_disponibile = '$nr_loc' WHERE nume_profesor = '$teacher_name'";
	mysqli_query($con, $query1);
	$query3 = "UPDATE profesori SET locuri_ramase = '$loc_disp_ramase' WHERE nume_profesor = '$teacher_name'";
	mysqli_query($con, $query3);

	echo "<script type='text/javascript'>$('#dispare').css('display', 'none');</script>";
	echo "<div style='width: 80%; margin: auto; text-align: left;'><h2>Numar locuri disponibile: $nr_loc</h2></div>";
}

?>

<div style="width: 80%; margin: auto; text-align: left;">
<h2>Proiecte adaugate:</h2>
</div>
<br>

<?php while($row=mysqli_fetch_array($result)): ?>

	<div class="widnow">
    <div id="btn<?=$nr_pr?>" class="title_bar">
    	<br>
    		<?= $row['titlu_proiect'] ?>
    </div>
    <div id="bx<?=$nr_pr?>" class="box">
    	<?= $row['detalii_proiect'] ?>
    	<div style="text-align: right; padding: 10px;">
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

<?php if($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

	<?php

	  $sql = "INSERT INTO teme (titlu_proiect, detalii_proiect, titular) VALUES ('".$_POST['title']."', '".$_POST['content']."', '".$row_id['id']."')";
		mysqli_query($con, $sql);

	?>

	<div class="widnow">
    	<div id="btn<?=$nr_pr?>" class="title_bar">
    		<br>
    		<?= $_POST['title'] ?>
    	</div>
    <div id="bx<?=$nr_pr?>" class="box">
    	<?= $_POST['content'] ?>
    	<div style="text-align: right; padding: 10px;">
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

<?php endif; ?>

<?php

$query5 = "SELECT * FROM aplicari WHERE nume_profesor = " . $row_id['id'];
$result5 = mysqli_query($con, $query5);

?>

<div style="width: 80%; margin: auto; text-align: left;">
	<h1>Aplicari:</h1>
</div>

<?php while($row5=mysqli_fetch_array($result5)): ?>

	<?php

		$query6 = "SELECT * FROM teme WHERE id = " . $row5['tema_proiect'];
		$result6 = mysqli_query($con, $query6);
		$row6 = mysqli_fetch_array($result6);
		$query7 = "SELECT * FROM studenti WHERE id = '" . $row5['nume_student'] . "'";
		$result7 = mysqli_query($con, $query7);
		$row7 = mysqli_fetch_array($result7);

	?>

	<div style="width: 80%; margin: auto; text-align: left;">
		<p><b><?= $row7["nume_student"] ?></b> (Nr. matricol: <?= $row7["nr_matricol"] ?>) a aplicat pentru proiectul: <?= $row6["titlu_proiect"] ?></p>
	</div>

<?php endwhile ?>

</div>
<p style="text-align: right;"><a class="logout" href="teachers_logout_prof.php">Logout</a></p>

<script type="text/javascript">

$("#btn").click(function(){
    $("#bx").slideToggle();
});

</script>

</body>
</html>