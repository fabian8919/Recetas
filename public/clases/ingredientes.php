<?php

/**
 * 
 */
class ingredientes
{
	
	public function __construct()
	{
		$this->db = new SQLite3('appEasyCook.db');
	}

	public function setMetodo($metodo){
		$this->metodo = $metodo;
	}

	public function setParametros($parametros){
		$this->parametros = $parametros;
	}

	private function insertar(){
		$bytes = file_get_contents($_FILES["input_subirIconoIngrediente"]["tmp_name"]);
		$code64 = base64_encode($bytes);
		$extension = explode(".", $_FILES["input_subirIconoIngrediente"]["name"]);
		$icon = "data:image/".$extension[1].";base64,".$code64; 

		$validar = false;
		$result = $this->db->query('SELECT idCategoria, descripcion FROM ingredientes');
		while ($row = $result->fetchArray()) {
			if (strtolower($row["descripcion"]) == strtolower($this->parametros["inputIngrediente"]) && $row["idCategoria"] == $this->parametros["selectCategoria"]){
				$validar = true;
			}
		}

		if($validar){
			echo json_encode("existe");
		}else{
			$result = $this->db->query("INSERT INTO ingredientes(descripcion, idCategoria, icono) 
			VALUES ('{$this->parametros["inputIngrediente"]}', {$this->parametros["selectCategoria"]}, '{$icon}');");
			echo json_encode("insertado");
		}
	}

	private function listar(){
		$result = $this->db->query("SELECT ing.idIngrediente,ing.descripcion AS ingrediente, cat.descripcion AS categoria, ing.icono
		FROM ingredientes AS ing
		INNER JOIN categorias AS cat ON cat.id = ing.idCategoria 
		WHERE ing.idCategoria = {$this->parametros["idCat"]}
		ORDER BY ing.descripcion ASC");
	
		$all = array();

		$i=0;
		while ($row = $result->fetchArray()) {
			$all[$i]["idIngrediente"] = $row["idIngrediente"];
			$all[$i]["ingrediente"] = $row["ingrediente"];
			$all[$i]["categoria"] = $row["categoria"];
			$all[$i]["icono"] = $row["icono"];
			$i++;		
		}

		if ($all != ''){
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}

	}

	private function listarId(){
		$result = $this->db->query('SELECT * FROM categorias ORDER BY descripcion');
		$i=0;
		while ($row = $result->fetchArray()) {
			$all[$i]["id"] = $row["id"];
			$all[$i]["descripcion"] = $row["descripcion"];
			$i++;
		}

		$select = $this->db->query("SELECT descripcion,idCategoria FROM ingredientes WHERE idIngrediente = {$this->parametros["id"]}");
		$row = $select->fetchArray();

		$data = array("cate" => $all, "ing" => $row);
		echo json_encode($data);
	}

	private function edit(){
		
		$validar = false;
		$result = $this->db->query('SELECT idCategoria, descripcion FROM ingredientes');
		while ($row = $result->fetchArray()) {
			if (strtolower($row["descripcion"]) == strtolower($this->parametros["inputEditIngrediente"]) && $row["idCategoria"] == $this->parametros["selectEditCategoria"]){
				$validar = true;
			}
		}

		if($validar && $_FILES["input_EditarIconoIngre"]["tmp_name"] == ''){
			echo json_encode("existe");
		}else{
			$edit = $this->db->query("UPDATE ingredientes SET descripcion = '{$this->parametros["inputEditIngrediente"]}', 
			idCategoria = {$this->parametros["selectEditCategoria"]}
			WHERE idIngrediente = {$this->parametros["idEditIngrediente"]}");

			if ($_FILES["input_EditarIconoIngre"]["tmp_name"] != ''){//actualizar foto si cargaron una
				$bytes = file_get_contents($_FILES["input_EditarIconoIngre"]["tmp_name"]);
				$code64 = base64_encode($bytes);
				$extension = explode(".", $_FILES["input_EditarIconoIngre"]["name"]);
				$icon = "data:image/".$extension[1].";base64,".$code64; 

				$edit = $this->db->query("UPDATE ingredientes SET icono = '{$icon}' WHERE idIngrediente = {$this->parametros["idEditIngrediente"]}");
			
			}

			echo json_encode("actualiza");
		}
	}

	private function delete(){
		$this->db->query("DELETE FROM ingredientes WHERE idIngrediente = {$this->parametros["id"]}");

		echo json_encode(true);
	}

	private function listarXcategoria()
	{
		$result = $this->db->query("SELECT idIngrediente, descripcion AS ingrediente
		FROM ingredientes 
		WHERE idCategoria = {$this->parametros["categoria"]} 
		AND idIngrediente NOT IN (SELECT ingredientes_idIngrediente FROM recetaIngrediente WHERE recetas_idReceta = {$this->parametros["idReceta"]})");

		$i=0;
		while ($row = $result->fetchArray()) {
			$all[$i]["idIngrediente"] = $row["idIngrediente"];
			$all[$i]["ingrediente"] = $row["ingrediente"];
			$i++;		
		}

		if (!empty($all)){
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}
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

			case 'listarXcategoria':
				$this->listarXcategoria();
			break;

			default:
				# code...
				break;
		}
	}
}

$ingredientes = new ingredientes();
$ingredientes->setMetodo(base64_decode($_POST["Metodo"]));
$ingredientes->setParametros($_POST);
$ingredientes->Main();