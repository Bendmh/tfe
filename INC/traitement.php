<?php

$sql = 'select * from Questions';
try {
	$dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
	$pdo = new PDO($dsn, 'dev','dev');
	echo "Connected to database<br>";

	/*$req = $pdo->prepare("INSERT INTO books (nom, prenom) VALUES (?, ?)");

	$req->bindParam(1, $name);
	$req->bindParam(2, $value);

	$name = $_POST['nom'];
	$value = $_POST['prenom'];

	$req->execute();*/

	foreach($pdo->query($sql, PDO::FETCH_ASSOC) as $row) {
		echo "<pre>".print_r($row,true)."</pre>";
	}

	$pdo = null;

} catch(PDOException $e) {echo $e->getMessage();}

?>
