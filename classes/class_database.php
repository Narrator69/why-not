<?
	class DataBase {

		private $dataBase;
		//private $className = 'stdClass';

		public function __construct(){
			$this->dataBase = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8', DBUSER, DBPASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		}

		public function execute($sql) {
			$sth = $this->dataBase->prepare($sql);
			return $sth->execute();
		}

		public function executeReturn($sql) {
			$sth = $this->dataBase->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
			//return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);
		}

		public function getLastInsertID() {
			return $this->dataBase->lastInsertId();
		}
	}
?>