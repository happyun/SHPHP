<?php  

/**
 * [p 自定义打印函数]
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
function p($var){
	if(is_null($var)){
		var_dump($var);
	}elseif(is_bool($var)){
		var_dump($var);
	}else{
		echo '<pre style="padding:10px;border-radius:5px;background:#f5f5f5;border:1px solid #ccc;font-size:14px;">'.print_r($var,true).'</pre>';
	}
}

function go($url,$time=0,$msg=''){

	if(!headers_sent()){
		$time=0?header('Location:'.$url):header("Location:{$time};url={$url}");
		die($msg);

	}else{
		echo "<meta http-equiv='Refresh'content='{$time};URL={$url}'>";
		if($time) die($msg);
	}
}

/**
 * [C 操作配置项]
 * @param [type] $var   [description]
 * @param [type] $value [description]
 */
function C($var=null,$value=null){
	static $config = array();
	if(is_array($var)){
		$config = array_merge($config,array_change_key_case($var,CASE_UPPER));
		return;
	}

	if(is_string($var)){
		$var = strtoupper($var);
		if(!is_null($value)){
			$config[$var] = $value;
			return;
		}
		return isset($config[$var])?$config[$var]:null;
	}

	if(is_null($var) && is_null($value)){
		return $config;
	}

}

function M($table){
	return new Model($table);
}

function K($table){
	$ModelName = $table.'Model';
	return new $ModelName($table);
}





?>