<?php
final class SHPHP{
	public static function run(){
		self::_set_const();
		defined('DEBUG') || define('DEBUG',false);
		if(DEBUG){
			self::_create_dir();
			self::_import_files();
		}else{
			error_reporting(0);
			require_once TEMP_PATH.'/~boot.php';
		}

		Application::run();
	}
	/**
	 * 设置常量
	*/

	private static function _set_const(){
		

		//框架根目录
		$path = str_replace('\\','/',__FILE__);
		define('SHPHP_PATH',dirname($path));
		
		//网站根目录
		define('ROOT_PATH',dirname(SHPHP_PATH));

		//核心文件夹Core
		define('LIB_PATH',SHPHP_PATH.'/Lib');
		define('CORE_PATH',LIB_PATH.'/Core');

		//框架工具函数文件夹
		define('FUNCTION_PATH',LIB_PATH.'/Function');
		
		//存放临时文件Temp文件夹
		define('TEMP_PATH',ROOT_PATH.'/Temp');
		define('LOG_PATH',TEMP_PATH.'/Log');
		//第三方工具包和外部工工具函数Extends
		define('EXTENDS_PATH',SHPHP_PATH.'/Extends');
		define('ORG_PATH',EXTENDS_PATH.'/Org');
		define('TOOL_PATH',EXTENDS_PATH.'/Tool');

		//存放其他数据的DATA
		define('DATA_PATH',SHPHP_PATH.'/Data');

		//系统配置项Config
		define('CONFIG_PATH',SHPHP_PATH.'/Config');

		//应用的物理目录
		define('APP_PATH',ROOT_PATH.'/'.APP_NAME);
		define('APP_CONFIG_PATH',APP_PATH.'/Config');
		define('APP_CONTROLLER_PATH',APP_PATH.'/Controller');
		define('APP_TPL_PATH',APP_PATH.'/Tpl');
		define('APP_PUBLIC_PATH',APP_TPL_PATH.'/Public');

		//应用外部的公共目录
		define('COMMON_PATH',ROOT_PATH.'/Common');
		define('COMMON_CONFIG_PATH',COMMON_PATH.'/Config');
		define('COMMON_LIB_PATH',COMMON_PATH.'/Lib');
		define('COMMON_MODEL_PATH',COMMON_PATH.'/Model');
	}

	/**
	 * [_create_dir 创建目录]
	 * @return [type] [description]
	 */
	private static function _create_dir(){
		$AppPath = array(
			TEMP_PATH,
			LOG_PATH,
			APP_PATH,
			APP_CONFIG_PATH,
			APP_CONTROLLER_PATH,
			APP_TPL_PATH,
			APP_PUBLIC_PATH,
			COMMON_PATH,
			COMMON_CONFIG_PATH,
			COMMON_LIB_PATH,
			COMMON_MODEL_PATH,
			CONFIG_PATH,
			);
		foreach($AppPath as $v){
			is_dir($v) || mkdir($v,0777,true);
		}
	}

	private static function _import_files(){
		$fileArr = array(
			FUNCTION_PATH.'/function.php',
			CORE_PATH.'/Controller.class.php',
			CORE_PATH.'/Application.class.php',
			);
		$str = '';
		foreach($fileArr as $v){
			//$str .= trim(substr(file_get_contents($v),5,-2));
			require_once $v;
		}
		//$str = "<?php/r/n".$str;
		//file_put_contents(TEMP_PATH.'/~boot.php',$str) || die('access not allow');
	}




	
}

SHPHP::run();










?>