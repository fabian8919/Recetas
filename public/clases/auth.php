<?php
session_start();
require '../vendor/autoload.php';
use Kreait\Firebase\Factory;

/**
 * 
 */
class auth
{
	
	public function __construct()
	{
		$factory = (new Factory)->withServiceAccount('../secret/rece-1cdd9-286e30f6cee0.json')->create();

		$this->database = $factory->getDatabase();
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setPass($pass){
		$this->pass = $pass;
	}

	public function autenticar(){
		$data = $this->database->getReference("users")->getValue();
		$authExito = false;
		foreach ($data as $key => $value) {
			if ($value == null)continue;
			foreach ($value as $key2 => $value2) {
				if ($key2 == "email"){
					$emailDB = $value2;
				}

				if ($key2 == "password"){
					$passDB = $value2;
				}
			}
		}

		if ($emailDB == $this->email && base64_decode($passDB) == $this->pass){
			$_SESSION["authExito"] = true;
			$authExito = true;
		}

		echo json_encode($authExito);
	}
}

$email = base64_decode($_POST["email"]);
$pass = base64_decode($_POST["pass"]);
$auth = new auth();
$auth->setEmail($email);
$auth->setPass($pass);
$auth->autenticar();