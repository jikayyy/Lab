<?php

class MySql {
	private $mysqli;
	
	function __construct() {
		$this->connecter();
	}
	
	function connecter() {
		$serveur = 'localhost';
		$login = '####';
		$base = '####';
		$pass = '####';
		
		$this->mysqli = new mysqli($serveur, $login, $pass, $base);
		$this->mysqli->query("SET NAMES 'utf8'");
	}
	
	function deconnecter() {
		mysql_close( $this->connexion );
	}
	
	function query($req, $err='') {
		if(!($result = $this->mysqli->query($requete))) {
			
			$tab = array(
				'sql_request'	=> $req,
				'mysqli_error'	=> htmlentities($this->mysqli->error),
				'msg_error'		=> $err
			);
			
			$err = json_encode($tab);
		
			//Log::ajouter('sql_error', $err);
		}
		return $result;
	}
	
	function fetch_array($resultats) {
		return $resultats->fetch_array();
	}
	
	function num_rows($resultats) {
		return $resultats->num_rows;
	}

	function free_result($resultats) {
		mysql_free_result($resultats);
	}
	
	function real_escape_string($string){
		
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}  
		
		return "'".$this->mysqli->real_escape_string($string)."'";
	}
	
	function insert_id() {
		return $this->mysqli->insert_id;
	}
}

?>