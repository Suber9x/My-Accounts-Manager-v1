<?php

class DB {
	private static $__instance = null;
	private $__pdo, 
			$__error=false, 
			$__query,
			$__results,
			$__count=0;

	private function __construct(){
		try{
			$this->__pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$__instance)) {
			self::$__instance = new DB();
		}
		return self::$__instance;
	}

	public function query($sql, $params = array()) {
		$this->__error = false;
		if($this->__query = $this->__pdo->prepare($sql)){
			$x = 1;
			if(count($params)) {
				foreach ($params as $param) {
					$this->__query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->__query->execute()){
				$this->__results = $this->__query->fetchAll(PDO::FETCH_OBJ);
				$this->__count = $this->__query->rowCount();
			} else {
				$this->__error = true;
			}
		}

		return $this;
	}

	public function error(){
		return $this->__error;
	}


	public function action($action, $table, $where = array()){
		$sql = '';
		if(count($where) === 3) {
			$operators = array('=', '>', '<', '<=', '>=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		} elseif($action === "UPDATE") {
			$sql = "UPDATE {$table} SET ";
			$fieldVal = array_slice($where, -2, 2);
			$updateVal = array_slice($where, 0, sizeof($where)-3);
			$field = $fieldVal[0];
			$value = $fieldVal[1];

			foreach ($updateVal as $val) {
				$sql .= "{$val} ";
			}
			$sql .= " WHERE {$field} = ?";

			if(!$this->query($sql, array($value))->error()){
				return $this;
			}
		} elseif($action === "INSERT") {
			$sql = "INSERT INTO {$table} ";
			$fields = array();
			$values = array();
			foreach ($where as $key => $value) {
				array_push($fields, $key);
				array_push($values, $value);
			}
			$strFLD = '';
			$strVAL = '';
			foreach ($fields as $fld) {
				$strFLD .= ",{$fld}";
			}
			foreach ($values as $val) {
				$strVAL .= ",?";
			}
			
			$strFLD = trim($strFLD, ",");
			$strVAL = trim($strVAL, ",");

			$sql .= "({$strFLD}) VALUES ({$strVAL})";

			if(!$this->query($sql, $values)->error()){
				return $this;
			}

		}
		return False;
	}

	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where){
		return $this->action("DELETE", $table, $where);
	}

	public function update($table, $where){
		return $this->action("UPDATE", $table, $where);
	}

	public function insert($table, $where){
		return $this->action("INSERT", $table, $where);
	}

	public function counts(){
		return $this->__count;
	}

	public function results(){
		return $this->__results;
	}

	public function first(){
		return $this->results()[0];
	}



}
