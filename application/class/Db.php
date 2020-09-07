<?php

namespace App;

class Db {
	private $login;
	private $password;
	private $connect;

	public function __construct(){
		$this->login = 'root';
		$this->password = '';
		$this->db = 'popy';
		$this->connection();
	}

	private function connection(){
		try
		{
	    	$bdd = new \PDO(
                'mysql:host=localhost;dbname='.$this->db.';charset=utf8mb4',
                $this->login,
                $this->password
            );
			$bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
			$bdd->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->connect = $bdd;
		}
		catch (\PDOException $e)
		{
			$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			die($msg);
		}
	}

	public function q($sql,Array $cond = null){
		$stmt = $this->connect->prepare($sql);

		if($cond){
			foreach ($cond as $v) {
				$stmt->bindParam($v[0],$v[1],$v[2]);
			}
		}
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->closeCursor();

	}

	public function qw($sql,Array $cond = null){
		$stmt = $this->connect->prepare($sql);

		if($cond){
			foreach ($cond as $v) {
				$stmt->bindParam($v[0],$v[1],$v[2]);
			}
		}

		$stmt->execute();
		$stmt->closeCursor();
		$stmt=NULL;
	}


}