<?php

require('db.php');

$query = "SELECT * FROM profesori WHERE id = ( SELECT MAX(id) FROM profesori )";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

$nr_prof = 1;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Repartiție finală pe cadre didactice</title>
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
		.form{
		  	display: block;
		    width: 80%;
		    margin: auto;
		    border: 2px solid black;
		    background: #ffffcc;
		    border-top-left-radius:10px;
			border-bottom-right-radius:10px;
			border-bottom-left-radius:10px;
			border-top-right-radius:10px;
			padding: 10px;
		}
	</style>

<h1 style="text-align: center; color: #ffffcc;">Rezultatele finale ale repartizării pe cadre didactice</h1>
<br>

<?php while($nr_prof <= $row['id']): ?>

	<div class="form">
		<?php
			$query1 = "SELECT * FROM profesori WHERE id = " . $nr_prof;
			$result1 = mysqli_query($con, $query1);
			$row1 = mysqli_fetch_array($result1);
			echo "<h2>" . $row1['nume_profesor'] . "</h2><br>";
			$query2 = "SELECT * FROM aplicari WHERE nume_profesor = " . $nr_prof;
			$result2 = mysqli_query($con, $query2);
			$nr_aplic = mysqli_num_rows($result2);
			if($nr_aplic == 0){
				echo "Nici o aplicare.";
			} else {
				while($row2 = mysqli_fetch_array($result2)){
					$titlu_pr = $row2['tema_proiect'];
					$query3 = "SELECT * FROM teme WHERE id = " . $titlu_pr;
					$result3 = mysqli_query($con, $query3);
					$row3 = mysqli_fetch_array($result3);
					$query4 = "SELECT * FROM studenti WHERE id = '" . $row2['nume_student'] . "'";
					$result4 = mysqli_query($con, $query4);
					$row4 = mysqli_fetch_array($result4);
					echo "<strong>" . $row4['nume_student'] . "</strong> - Nr. matricol: " . $row4['nr_matricol'] . " - Media: " . $row4['media'] . " - " . $row3['titlu_proiect'] . "<br>";
				}
			}
		?>
	</div>
	<br>
	<?php
		$nr_prof++;
	?>

<?php endwhile ?>
<br>
<p style="text-align: right;color: white;"><a style="color: white;" href='repartitie_finala2.php'>Repartiție finală pe grupe</a></p>

</body>
</html>