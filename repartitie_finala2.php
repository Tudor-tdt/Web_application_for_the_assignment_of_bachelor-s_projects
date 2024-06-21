<?php

require('db.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Repartiție finală pe grupe</title>
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

<h1 style="text-align: center; color: #ffffcc;">Rezultatele finale ale repartizării pe grupe</h1>
<br>


<?php

	$query = "SELECT * FROM studenti";
	$result = mysqli_query($con, $query);

	$n=0;
	while($row = mysqli_fetch_array($result)){
		$v[$n] = $row['grupa'];
		$n++;
	}

	for($i=0; $i<$n-1; $i++){
		for($j=$i+1; $j<$n; $j++){
			if($v[$i] > $v[$j]){
				$aux=$v[$i];
				$v[$i]=$v[$j];
				$v[$j]=$aux;
			}
		}
	}

	$m=0;

	for($i=0; $i<$n; $i++){
		if($v[$i] != $v[$i+1]){
			$w[$m] = $v[$i]; //vectorul w contine grupele in ordine crescatoare
			$m++;
		}
	}

	$i = 0;

?>

<?php while($i < $m): ?>

	<div class="form">
		<?php

			echo "<h1>" . $w[$i] . "</h1><br>";

			$query1 = "SELECT * FROM studenti WHERE grupa = " . $w[$i];
			$result1 = mysqli_query($con, $query1);
			while($row1 = mysqli_fetch_array($result1)){
				$query2 = "SELECT * FROM aplicari WHERE nume_student = " . $row1['id'];
				$result2 = mysqli_query($con, $query2);
				$row2 = mysqli_fetch_array($result2);
				$query3 = "SELECT * FROM profesori WHERE id = " . $row2['nume_profesor'];
				$result3 = mysqli_query($con, $query3);
				$row3 = mysqli_fetch_array($result3); // nume profesor
				$query4 = "SELECT * FROM teme WHERE id = " . $row2['tema_proiect'];
				$result4 = mysqli_query($con, $query4);
				$row4 = mysqli_fetch_array($result4);
				echo "<strong>" . $row1['nume_student'] . "</strong> (Nr. matricol: " . $row1['nr_matricol'] . " - Media: " . $row1['media'] . ") A aplicat la: <strong>" . $row3['nume_profesor'] . "</strong> pentru proiectul <u>" . $row4['titlu_proiect'] . "</u><br><br>";
			}

		?>
	</div>
	<br>

	<?php $i++; ?>

<?php endwhile ?>


<br>
<p style="text-align: right;"><a style="color: white;" href='repartitie_finala.php'>Repartiție finală pe cadre didactice</a></p>

</body>
</html>