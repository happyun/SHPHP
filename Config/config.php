<?php  
return array(
	//时区
	'DEFALUT_TIME_ZONE' => 'PRC',
	//默认session开启
	'SESSION_AUTO_START' => TRUE,
	//默认控制器和方法的get参名称
	'VAR_ACTION'         => 'a',
	'VAR_CONTROLLER'     => 'c',
	//是否开启日志
	'SAVE_LOG'           => TRUE,
	//错误跳转地址
	'ERROR_URL'          =>'',
	//错误提示信息
	'ERROR_MSG'          => '网站出错了，请稍后再试...',
	//自动加载Common/Lib目录下的文件，可以加载多个
	'AUTO_LOAD_FILE'     =>  array(),

	//数据库配置
	'DB_CHARSET'        =>'utf8',
	'DB_HOST'           =>'127.0.0.1',
	'BD_PORT'           =>'3306',
	'DB_USER'           =>'root',
	'DB_PASSWORD'       =>'',
	'DB_DATABASE'       =>'',
	'DB_PREFIX'         =>'',

	//SMARTY模板左右边界的定义
	'SMARTY_ON'         =>true,
	'LEFT_DELIMITER'    =>'{sh',
	'RIGHT_DELIMITER'   =>'}',
	'CACHE_ON'          =>TRUE,
	'CACHE_TIME'		=>7,




	)






?>