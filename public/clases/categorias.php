<?php

/**
 * 
 */
class categorias
{
	
	public function __construct()
	{
		$this->db = new SQLite3('appEasyCook.db');
		// $this->db = new PDO('sqlite:appEasyCook.db');
	}

	public function setMetodo($metodo){
		$this->metodo = $metodo;
	}

	public function setParametros($parametros){
		$this->parametros = $parametros;
	}

	/**
	 * [insertar insertar una categoria, validando que no exista]
	 * 
	 * @author [Fabian Zabala] - [2020-03-22]
	 * 
	 * @version [1.0] [@author] - [2020-03-22]
	 */
	private function insertar(){
		$bytes = file_get_contents($_FILES["input_subirIconoCate"]["tmp_name"]);
		$code64 = base64_encode($bytes);
		$extension = explode(".", $_FILES["input_subirIconoCate"]["name"]);
		$icon = "data:image/".$extension[1].";base64,".$code64; 

		$validar = false;
		$result = $this->db->query('SELECT descripcion FROM categorias');
		while ($row = $result->fetchArray()) {
			if (strtolower($row["descripcion"]) == strtolower($this->parametros["inputCategoria"])){
				$validar = true;
			}
		}

		if($validar){
			echo json_encode("existe");
		}else{
			$result = $this->db->query("INSERT INTO categorias(descripcion, icono) VALUES ('{$this->parametros["inputCategoria"]}', '{$icon}');");
			echo json_encode("insertado");
		}
	}

	/**
	 * [listar extraer los categorias para listar el table]
	 * 
	 * @author [Fabian Zabala] - [2020-03-22]
	 * 
	 * @version [1.0] [@author] - [2020-03-22]
	 */
	private function listar(){
		$result = $this->db->query('SELECT * FROM categorias ORDER BY descripcion ASC');
		$all = array();

		$i=0;
		while ($row = $result->fetchArray()) {
			$all[$i]["id"] = $row["id"];
			$all[$i]["descripcion"] = $row["descripcion"];
			$all[$i]["icono"] = $row["icono"];
			$i++;
		}

		if ($all != ''){
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}
	}

	/**
	 * [delete eliminar una categoria]
	 * 
	 * @author [Fabian Zabala] - [2020-03-22]
	 * 
	 * @version [1.0] [@author] - [2020-03-22]
	 */
	private function delete(){
		$this->db->query("DELETE FROM categorias WHERE id = {$this->parametros["id"]}");

		echo json_encode(true);
	}

	/**
	 * [listarId extraer descripcion de un id]
	 * 
	 * @author [Fabian Zabala] - [2020-03-22]
	 * 
	 * @version [1.0] [@author] - [2020-03-22] - [Description]
	 * @return [type] [description]
	 */
	private function listarId(){
		$select = $this->db->query("SELECT descripcion FROM categorias WHERE id = {$this->parametros["id"]}");
		$row = $select->fetchArray();
		echo json_encode($row);
	}

	/**
	 * [edit editar una categoria]
	 * 
	 * @author [Fabian Zabala] - [2020-03-22]
	 * 
	 * @version [1.0] [@author] - [2020-03-22]
	 */
	private function edit(){
		$validar = false;
		$result = $this->db->query('SELECT descripcion FROM categorias');
		while ($row = $result->fetchArray()) {
			if (strtolower($row["descripcion"]) == strtolower($this->parametros["inputEditCategoria"])){
				$validar = true;
			}
		}
		if($validar && $_FILES["input_EditarIcono"]["tmp_name"] == ''){
			echo json_encode("existe");
		}else{
			$edit = $this->db->query("UPDATE categorias SET descripcion = '{$this->parametros["inputEditCategoria"]}' WHERE id = {$this->parametros["idEditCategoria"]}");

			if ($_FILES["input_EditarIcono"]["tmp_name"] != ''){//actualizar foto si cargaron una
				
				$bytes = file_get_contents($_FILES["input_EditarIcono"]["tmp_name"]);
				$code64 = base64_encode($bytes);
				$extension = explode(".", $_FILES["input_EditarIcono"]["name"]);
				$icon = "data:image/".$extension[1].";base64,".$code64; 

				$edit = $this->db->query("UPDATE categorias SET icono = '{$icon}' WHERE id = {$this->parametros["idEditCategoria"]}");
			}

			echo json_encode("actualiza");
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

			default:
				# code...
				break;
		}
	}
}

$categorias = new categorias();
$categorias->setMetodo(base64_decode($_POST["Metodo"]));
$categorias->setParametros($_POST);
$categorias->Main();