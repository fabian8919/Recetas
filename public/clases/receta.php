<?php 
require '../vendor/autoload.php';
use Kreait\Firebase\Factory;

/**
 * 
 */
class receta
{
	
	public function __construct()
	{
		$factory = (new Factory)->withServiceAccount('../secret/rece-1cdd9-286e30f6cee0.json')->create();

		$this->database = $factory->getDatabase();
	}

	public function setMetodo($metodo)
	{
		$this->metodo = $metodo;
	}

	public function setParametros($parametros)
	{
		$this->parametros = $parametros;
	}

	/**
	 * [insertar insertar datos en firebase recetas]
	 * 
	 * @author [Fabian Zabala] - [2020-03-28]
	 * 
	 * @version [1.0] [@author] - [2020-03-28] - [Description]
	 * @return [type] [description]
	 */
	private function insertar()
	{	
		// $idReceta = uniqid();
		$idReceta = rand(1, 1000000000);;
		$name = $this->parametros["inputNameRece"];
		$urlVideo = $this->parametros["inputUrlVideo"];
		$preparacion = $this->parametros["inputPreparacion"];
		$bytes = file_get_contents($_FILES["input_subirFoto"]["tmp_name"]);
		$code64 = base64_encode($bytes);
		$extension = explode(".", $_FILES["input_subirFoto"]["name"]); 
		
		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->getChild("nombre")->set($name);
		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->getChild("video")->set($urlVideo);
		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->getChild("foto")->set("data:image/".$extension[1].";base64,".$code64);
		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->getChild("preparacion")->set($preparacion);

		echo json_encode(true);
	}

	/**
	 * [listar extrae las recetas]
	 * 
	 * @author [Fabian Zabala] - [2020-03-28]
	 * 
	 * @version [1.0] [@author] - [2020-03-28]
	 * @return [array] [datos]
	 */
	private function listar()
	{
		$datos = $this->database->getReference()->getChild("recetas")->getvalue();
		$i=0;
		if ($datos != NULL){
			foreach ($datos as $idReceta => $value) {
				$all[$i]["idReceta"] = $idReceta;
				$all[$i]["nombre"] = $value["nombre"];
				$all[$i]["video"] = $value["video"];
				$all[$i]["foto"] = $value["foto"];
				$all[$i]["preparacion"] = $value["preparacion"];
				$i++;
			}
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}
	}

	private function listarId()
	{
		$datos = $this->database->getReference()->getChild("recetas")->getChild($this->parametros["id"])->getvalue();

		echo json_encode($datos);
	}

	private function edit()
	{

		$idReceta = $this->parametros["idReceta"];
		$nombre = $this->parametros["nombre"];
		$video = $this->parametros["video"];
		$preparacion = $this->parametros["preparacion"];

		$update = array("nombre" => $nombre, "video" => $video, "preparacion" => $preparacion);

		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->update($update);

		if ($_FILES["input_EditarFoto"]["tmp_name"] != ''){//actualizar foto si cargaron una
			$bytes = file_get_contents($_FILES["input_EditarFoto"]["tmp_name"]);
			$code64 = base64_encode($bytes);
			$extension = explode(".", $_FILES["input_EditarFoto"]["name"]);
			$fotoup = "data:image/".$extension[1].";base64,".$code64;

			$update2 = array("foto" => $fotoup);
			$this->database->getReference()->getChild("recetas")->getChild($idReceta)->update($update2);
		}

		echo json_encode(true);
	}

	private function delete()
	{	
		$idReceta = $this->parametros["id"];

		$this->database->getReference()->getChild("recetas")->getChild($idReceta)->remove();

		echo json_encode(true);
	}

	private function listarOnlyRecetas()
	{
		$datos = $this->database->getReference()->getChild("recetas")->getvalue();
		$i=0;
		if ($datos != NULL){
			foreach ($datos as $idReceta => $value) {
				$all[$i]["idReceta"] = $idReceta;
				$all[$i]["nombre"] = $value["nombre"];
				$i++;
			}
			echo json_encode($all);
		}else{
			echo json_encode(false);
		}
	}

	public function Main()
	{
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

			case 'listarOnlyRecetas':
				$this->listarOnlyRecetas();
		break;

			default:
				# code...
				break;
		}
	}
}

$metodo = base64_decode($_POST["Metodo"]);

$receta = new receta();
$receta->setMetodo($metodo);
$receta->setParametros($_POST);
$receta->Main();