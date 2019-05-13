<?php

class DBConnector{
	public $conn;
	function _construct(){
		$this->conn = mysql_connect("localhost", "root","") or die("Error: " .mysql_error());
		mysql_select_db("btc3205",$this->conn);
		}
		
		public function closeDatabase(){
			mysql_close($this->conn);
			}
	}
?>