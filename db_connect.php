<?php
 
class DB_Connect {
  public  $con1;
    // constructor
    function __construct() {
	 $this->connect();
    }
 
    // destructor
    function __destruct() {
        // $this->close();
    }
 
    // Connecting to database
    public function connect() {
        require_once 'config.php';
        // connecting to mysql
        $con = mysql_connect(DB_HOST, DB_USER,DB_PASSWORD);
        // selecting database
        mysql_select_db(DB_DATABASE);
		$this->con1=$con;
 
        // return database handler
        return $con;
    }
 
    // Closing database connection
    public function insert($query) {
        $query1=str_replace('','',mysql_real_escape_string($query));

		$res=mysql_query($query,$this->con1);
		return $res;
    }
	 public function insert_id($query) {
        $query1=str_replace('','',mysql_real_escape_string($query));

		$res=mysql_query($query,$this->con1);
		$id=mysql_insert_id();
		return $id;
    }
	 public function update_id($query) {
        $query1=str_replace('','',mysql_real_escape_string($query));

		$res=mysql_query($query,$this->con1);
		$id=mysql_insert_id();
		return $id;
    }
	 public function update($query) {
        $query1=str_replace('','',mysql_real_escape_string($query));

		$res=mysql_query($query,$this->con1);
		return $res;
    }
	
	 public function delete($query) {
        $query1=str_replace('','',mysql_real_escape_string($query));

		$res=mysql_query($query,$this->con1);
		return $res;
    }
	
	 public function select($query) {
        $query1=str_replace('','',mysql_fetch_array($query));

		$res=mysql_query($query,$this->con1);
		return $res;
    }
	

} 
?>