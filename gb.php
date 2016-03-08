<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>G�stebuch</title>
</head>
<body>
<?php

 //Verbindung zur db

require 'Medoo-master/medoo.php';
$database = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'gbuch',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
]);


//Eintr�ge anzeigen

$texte = $database->select("gb", "*");
foreach($texte as $text){
	echo $text["name"]." hat am ".$text["datum"]." diesen Beitrag geschrieben:  ";
	echo $text["nachricht"];
	echo' <a href="?edit='.$text["id"].'">bearbeiten</a></br>';
}
echo '<a href="?new">neuer Beitrag</a>';



//Einf�gen
if(isset($_GET["new"])){

	echo '<form method="post" action="">';
	echo '<p>Nachricht<textarea name="nachricht"></textarea></p>';
	echo '<p>Name <input type="text" name="name"></p>';
	echo '<input type="submit" name="submit">';
	echo '</form>';


    if(isset($_POST["submit"])){
	       $database->insert("gb", array("name" => $_POST["name"],
								         "nachricht" => $_POST["nachricht"],
								        "datum" => date("Y.m.d")));
    }                                   
}



//Bearbeiten
else if(isset($_GET["edit"])){
	echo "<form action='' method='post'>";
	echo '<p>neuer Text<textarea name="nachricht"></textarea></p>';
	echo '<p>Name <input type="text" name="name"></p>';
	echo '<input type="submit" name="senden">';
	echo "</form>";
	if(isset($_POST["senden"])){
		$database->update("gb", array("nachricht" => $_POST['nachricht']), array("id" => $_GET["edit"]));
	}
}




  ?>

</body>
</html>
