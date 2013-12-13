<?php
class LZGenerateTables
{
    private
	$host,$dbname,$user,$pass;
	
	static $_self;
	
	public function __construct()
	{
	   return $this;
	}
	
	public function set($host,$dbname,$user,$pass)
	{
	    $this->host=$host;
	    $this->dbname=$dbname;
	    $this->user=$user;
	    $this->pass=$pass;
	    return $this;
	}
	
    public function init()
	{
	    $dbh = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
		self::$_self=$dbh;
		return $this;
	}
	
	public function creat_table($xml)
	{
	    $xml_object = simplexml_load_file($xml);
	    $sql="CREATE TABLE ";
		$sql.= $xml_object->model->table;
		$sql.= ' ( ';
		
		for($i=0;$i<count($xml_object->model->properties->prop);++$i):
		    $attr[]=$xml_object->model->properties->prop[$i]->attributes();
		endfor;
		
		foreach($xml_object->model->properties as $k=>$props):
		    $propsList[]=$props;
		endforeach;
		
		$id=$propsList[0][0]->prop[0][0];

		for($k=0;$k<count($propsList[0][0]->prop);++$k):
			
			$sql.= ' ' . $propsList[0][0]->prop[$k] . ' ';
		    $sql.= ' ';
				
			if($attr[$k]['type'] == 'int' AND $attr[$k]['prescedence'] == 'primary'):
				$sql.= $attr[$k]['type'] . ' NOT NULL ' .  ' AUTO_INCREMENT,';
			endif;
				
			if($attr[$k]['type'] == 'varchar'):
				$sql .= $attr[$k]['type'] . ' (' . $attr[$k]['size'] . ') '  . ' NOT NULL,';
			endif;		
		endfor;
		
		$sql.= "PRIMARY KEY   ({$id}))";
		echo $sql;
	}
}

    $o=new LZGenerateTables;
	
    $o->set($host='localhost',$database='blog',$user='root',$pass='')
	->init()
	->creat_table('autors.xml');
	
?>
