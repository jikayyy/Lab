<?php

class Log {
	private $id;
	private $type;
	private $message;
	private $active;
	private $date_log;
	
	function get_type() {		return $this->type; }
	function get_message() {	return $this->message; }
	function get_active() {		return $this->active; }
	function get_date_log() {	return $this->date_log; }
	
	function set_id($id) { 				$this->id		= $id; }
	function set_type($type) { 			$this->type		= $type; }
	function set_message($message) { 	$this->message	= $message; }
	function set_active($active) { 		$this->active	= $active; }
	function set_date_log($date_log) { 	$this->date_log	= $date_log; }
	
	function __construct($id='') {
		if($id != '') {
			$this->set_id($id);
			$this->lire();
		}
	}
	
	/*
	* Fonction lire, appelée dans le constructeur
	* @author JK
	*/
	public function lire() {
		$bdd = new MySql();
		$sql = 'SELECT *
				FROM log
				WHERE id = ' . $this->id;
		$err = "Error: Log->lire()";
		
		$res = $bdd->query($sql, $err);
		$row = $res->fetch_array();
		
		$this->type		= $row['type'];
		$this->message	= $row['message'];
		$this->active	= $row['active'];
		$this->date_log	= $row['date_log'];
	}
	
	
	public static function ajouter($type, $message) {
		$bdd = new MySql();
		$sql = "INSERT INTO log (type, message, date_log)
				VALUES (" . $bdd->real_escape_string($type) . ", " . $bdd->real_escape_string($message) . ", NOW())";
			
		$err = "Error: Log->ajouter()<br />$sql";
		
		return($bdd->query($sql, $err));
	}
	
	/*
	* Backoffice - Affichage des logs
	* @author JK
	*/
	public static function lister() {
		$bdd = new MySql();
		$sql = "SELECT id, type, message, active, date_log
				FROM log
				ORDER BY date_log DESC";
		
		$err = "Error: Log->lister()<br />$sql";
		$res = $bdd->query($sql, $err);
?>	
		<table class="sortable" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Message</th>
					<th>Date</th>
					<th>Active</th>
				</tr>
			</thead>
			<tbody>

<?php
		while($row = $bdd->fetch_array($res)) {
			$message = json_decode($row['message']);
?>
				<tr>
					<td><?=$row['id']?></td>
					<td><?=$row['type']?></td>
					<td><?php echo '<pre>'; print_r($message); echo '</pre>';?></td>
					<td><?=$row['date_log']?></td>
					<td><?=$row['active']?></td>
				</tr>
<?php
		}
?>
			</tbody>
		</table>
<?php
	}
	
	
	
}

?>