<?php
require '../vendor/autoload.php';
use Kreait\Firebase\Factory;
/**
 * 
 */
class recetasIngredientes
{
	
	public function __construct()
	{
		$this->db = new SQLite3('appEasyCook.db');
		$factory = (new Factory)->withServiceAccount('../secret/rece-1cdd9-286e30f6cee0.json')->create();
		$this->database = $factory->getDatabase();
	}

	public function setMetodo($metodo){
		$this->metodo = $metodo;
	}

	public function setParametros($parametros){
		$this->parametros = $parametros;
	}

	/**
	 * [insertar relacionar ingredientes a una receta]
	 * 
	 * @author [Fabian Zabala] - [2020-04-13]
	 * 
	 * @version [1.0] [@author] - [2020-04-13]
	 * @version [2.0] [@author] - [2020-04-18] - [validar que el ingrediente ya exista en la receta]

	 */
	private function insertar()
	{
		// exit(var_dump($this->db));
		foreach ($this->parametros['relations'] as $key => $value) {
			$opcional = $value[6] == 'Si' ? 'true' : 'false';

			$this->db->query("INSERT INTO recetaIngrediente(recetas_idReceta, ingredientes_idIngrediente, porcion, opcional) 
			VALUES ({$value[0]}, {$value[2]}, '{$value[5]}', '{$opcional}');");	

		}
		
		echo json_encode(true);
	}

	/**
	 * [listar obtener los ingredientes de una receta]
	 * 
	 * @author [Fabian Zabala] - [2020-04-18]
	 * 
	 * @version [1.0] [@author] - [2020-04-18]
	 */
	private function listar()
	{
		$all = array();
		$idReceta = $this->parametros["receta"];

		$result = $this->db->query("SELECT rel.idRecetaIngrediente AS idRelacion, rel.recetas_idReceta AS idReceta,
		rel.ingredientes_idIngrediente AS idIngrediente, ing.descripcion AS ingrediente, rel.porcion AS porcion, rel.opcional AS opcional
		FROM recetaIngrediente AS rel
		INNER JOIN ingredientes AS ing ON ing.idIngrediente = rel.ingredientes_idIngrediente
		WHERE rel.recetas_idReceta = {$idReceta}");
		
		$datos = $this->database->getReference()->getChild("recetas")->getvalue();
		
		$i=0;
		if ($datos != NULL){
			foreach ($datos as $idReceta => $value) {
				$recetas[$i]["idReceta"] = $idReceta;
				$recetas[$i]["nombre"] = $value["nombre"];
				$i++;
			}
		}
		
		$j=0;
		while ($row = $result->fetchArray()) {
			$porcion = explode("|", $row["porcion"]);
			$all[$j]["idRelacion"] = $row["idRelacion"];
			$all[$j]["idReceta"] = $row["idReceta"];
			foreach ($recetas as $key => $value) {
				if ($value["idReceta"] == $all[$j]["idReceta"]){
					$all[$j]["receta"] = $value["nombre"];
				}
			}
			$all[$j]["idIngrediente"] = $row["idIngrediente"];
			$all[$j]["ingrediente"] = $row["ingrediente"];
			$all[$j]["porcion"] = $porcion[0] . " " . $porcion[1];
			$all[$j]["opcional"] = $row["opcional"];

			$j++;
		}

		if (!empty($all)){
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}
	}

	/**
	 * [listarId listar los datos de una relacion]
	 * 
	 * @author [Fabian Zabala] - [2020-04-22]
	 * 
	 * @version [1.0] [@author] - [2020-04-22]
	 * @return [type] [description]
	 */
	private function listarId()
	{
		$result = $this->db->query("SELECT idRecetaIngrediente AS idRelacion, porcion, opcional 
		FROM recetaIngrediente WHERE idRecetaIngrediente = {$this->parametros["id"]}");

		while ($row = $result->fetchArray()) {
			$porcion = explode("|", $row["porcion"]);
			$all["idRelacion"] = $row["idRelacion"];
			$all["porcion1"] = $porcion[0];
			$all["porcion2"] = $porcion[1];
			$all["opcional"] = $row["opcional"];
		}

		echo json_encode($all);
	}

	/**
	 * [edit editar los datos del ingrediente]
	 * 
	 * @author [Fabian Zabala] - [2020-04-24]
	 * 
	 * @version [1.0] [@author] - [2020-04-24]
	 */
	private function edit()
	{
		$this->db->query("UPDATE recetaIngrediente SET porcion = '{$this->parametros["porcion"]}', opcional = '{$this->parametros["opcional"]}'
		WHERE idRecetaIngrediente = {$this->parametros["id"]}");
		echo json_encode(true);
	}

	/**
	 * [delete eliminar una relacion]
	 * 
	 * @author [Fabian Zabala] - [2020-04-24]
	 * 
	 * @version [1.0] [@author] - [2020-04-24]
	 */
	private function delete(){
		$this->db->query("DELETE FROM recetaIngrediente WHERE idRecetaIngrediente = {$this->parametros["id"]}");

		echo json_encode(true);
	}

	public function Main(){
		switch ($this->metodo) {
			case 'insertar':
				$this->insertar();
			break;
			
			case 'listar':
				$this->listar();
			break;

			case 'delete':
				$this->delete();
			break;

			case 'listarId':
				$this->listarId();
			break;

			case 'edit':
				$this->edit();
			break;

			default:
				# code...
				break;
		}
	}
}


$recetasIngredientes = new recetasIngredientes();
$recetasIngredientes->setMetodo(base64_decode($_POST["Metodo"]));
$recetasIngredientes->setParametros($_POST["Parametros"]);
$recetasIngredientes->Main();