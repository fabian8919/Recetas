<?php

// $db = new SQLite3('appEasyCook.db');

// $results = $db->query('SELECT descripcion FROM categorias');
// while ($row = $results->fetchArray()) {
//     var_dump($row);
// }

// exit();
try {
// $db = new PDO('sqlite:prueba.sqlite');
$db = new PDO('sqlite:appEasyCook.db');
// $db->exec("INSERT INTO categorias(id) VALUES (1);");
$resul =$db->query("SELECT * FROM categorias");

foreach ($resul as $key => $value) {
	var_dump($value);
}
	
} catch (Exception $e) {
	var_dump($e->getMessage());
}