<?php  
class Model{
	protected $table = null;
	public static $link = null;
	private $opt = array();
	public static $sqls = array();

	function __construct($table){
		$this->table = is_null($table)?C('DB_PREFIX').$this->table:C('DB_PREFIX').$table;
		$this->connect();
		$this->_opt();
	}

	/**
	 * [connect 数据库连接]
	 * @return [type] [description]
	 */
	private function connect(){
		if(is_null(self::$link)){
			$db = C('DB_DATABASE');
			if(empty($db))echo "请先配置数据库";
			$link = new Mysqli(C('DB_HOST'),C('DB_USER'),C('DB_PASSWORD'),C('DB_DATABASE'));
			if($link->connect_error){
				echo "数据库连接错误，请检查配置项";
			}
			$link->set_charset(C('DB_CHARSET'));
			self::$link = $link;
			
		}
	}

	public function field($fields){
		$this->opt['field'] = $fields;
		return $this;
	}

	public function where($where){
		$this->opt['where'] = " WHERE ".$where;
		return $this;
	}

	public function limit($limit){
		$this->opt['limit'] = " LIMIT ".$limit;
		return $this;
	}

	public function order($order){
		$this->opt['order'] = " ORDER BY ".$order;
		return $this;
	}

	public function group($group){
		$this->opt['limit'] = " GROUP BY ".$group;
		return $this;
	}

	public function have($have){
		$this->opt['having'] = " having ".$have;
		return $this;
	}

	public function all(){
		$sql = "SELECT ".$this->opt['field']." FROM ".$this->table.$this->opt['where'].$this->opt['group'].$this->opt['having'].$this->opt['order'].$this->opt['limit'];
		return $this->query($sql);

	}

	public function find(){
		$data =$this->limit(1)->all();
		$data = current($data);
		return $data;
	}

	public function query($sql){
		self::$sqls[] = $sql;
		$link = self::$link;
		$result = $link->query($sql);
		if($link->errno)echo "mysql错误".$link->error.'<br>	SQL:'.$sql;
		else{$rows = array();
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		$result->free();
		$this->_opt();
		return $rows;
	}
	}

	public function update($data=null){
		if(empty($this->opt['where'])){
			echo "必须有where条件";
		}else{
			foreach($data as $k=>$v){
				$value .= $k."=".'"'.$v.'"'.',';
			}
			$value = trim($value,',');
			$sql = "UPDATE ".$this->table." SET ".$value.$this->opt['where'];
			$res = $this->exe($sql);
			return $res;
		}
		
	}

	public function add($data){
		$coloum = '';
		$value = '';
		foreach($data as $k=>$v){
			$coloum .= $k.",";
			$value .= "'".$v."',";
		}
		$coloum = trim($coloum,',');
		$value = trim($value,',');
		$sql = "INSERT INTO ".$this->table. "(".$coloum.")"." VALUES "."(".$value.")";
		$res = $this->exe($sql);
		return $res;
	}

	public function del(){
		if(empty($this->opt['where'])){
			echo "必须有where条件";
		}else{
			$sql = "DELETE FROM ".$this->table.$this->opt['where'];
			$res = $this->exe($sql);
			return $res;
		}
	}

	private function exe($sql){
		self::$sqls[] = $sql;
		$link = self::$link;
		$res = $link->query($sql);
		$this->_opt();
		if($res){
			return $link->insert_id?$link->insert_id:$link->affected_rows;
		}else{
			echo "mysql错误：".$link->error.'<br> SQL:'.$sql;
		}
	}

	private function _opt(){
		$this->opt = array(
			'field' => '*',
			'where' => '',
			'group' => '',
			'having' => '',
			'order' => '',
			'limit' => '',
			);
	}




}


















?>