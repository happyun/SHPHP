<?php  
final class Application{

	public static function run(){
		self::_init();
		self::_set_url();
		spl_autoload_register(array(__CLASS__,'_autoload'));
		self::_create_demo();
		self::_app_run();
	}

	private static function _app_run(){
		$c = isset($_GET['c'])?$_GET['c']:'Index';
		$a = isset($_GET['a'])?$_GET['a']:'index';
		define('CONTROLLER',$c);
		define('ACTION',$a);
		$c .='Controller';
		if(class_exists($c)){
			$obj = new $c();
			if(method_exists($obj,$a)){
				$obj->$a();
			}else{
				echo "<h2>".$c."中的".$a."方法不存在!";
			}
		}else{
			echo "<h2>".$c."控制器不存在!";
		}
	}
	/**
	 * [_create_demo description]
	 * @return [type] [description]
	 */
	private static function _create_demo(){
		$path = APP_CONTROLLER_PATH.'/IndexController.class.php';
		$str = <<<str
<?php
class IndexController extends Controller{
	public function index(){
		header('Content-type:text/html;charset=utf-8');
		echo '<h2>欢迎使用SHPHP框架(:!</h2>';
	}
}
?>
str;
		is_file($path) || file_put_contents($path,$str);
	}

	/**
	 * [_autoload 创建自动加载函数]
	 * @param  [type] $className [description]
	 * @return [type]            [description]
	 */
	private static function _autoload($className){
		switch(true){
			case strlen($className) > 10 && substr($className,-10) == 'Controller':
			$path = APP_CONTROLLER_PATH.'/'.$className.'.class.php';
			if(is_file($path)){
				include $path;
			}
			break;
	
			case strlen($className)>5 && substr($className,-5) == 'Model':
			$path = COMMON_MODEL_PATH.'/'.$className.'.class.php';
			if(is_file($path)){
				include $path;
			}
			break;

			default:
			$path = TOOL_PATH.'/'.$className.'.class.php';
			if(is_file($path)){
				include $path;
			}
			break;
		}
	}

	/**
	 * [_set_url 设置网站的外部路径]
	 */
	private static function _set_url(){
		$path = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
		$path = str_replace('\\','/',$path);
		define('__APP__',$path);
		define('__ROOT__',dirname(__APP__));
		define('__TPL__',__ROOT__.'/'.APP_NAME.'/Tpl');
		define('__PUBLIC__',__TPL__.'/Public');
	}

	/**
	 * [_init 初始化框架]
	 * @return [type] [description]
	 */
	private static function _init(){
		//加载配置项
		C(include CONFIG_PATH.'/config.php');

		$commonPath = COMMON_CONFIG_PATH.'/config.php';
		$commonConfig = <<<str
<?php
return array(
	//配置项=>配置值
	//用户设置自动加载的自定义文件
	'AUTO_LOAD_FILE' => array(),
	);
?>
str;
	is_file($commonPath) || file_put_contents($commonPath,$commonConfig);
	C(include $commonPath);

	$userPath = APP_CONFIG_PATH.'/config.php';
	$userConfig = <<<str
<?php
return array(
	//配置项=>配置值
	);
?>
str;
	is_file($userPath) || file_put_contents($userPath,$userConfig);
	C(include $userPath);

	//设置时区
	date_default_timezone_set(C('DEFAULT_TIME_ZONE'));

	//是否开启session
	C('SESSION_AUTO_START') && session_start();


	}

	private static function _user_import(){
		$fileArr = C('AUTO_LOAD_FILE');
		if(!empty($fileArr)){
			foreach($fileArr as $v){
				require_once COMMON_LIB_PATH.'/'.$v;
			}
		}
	}
}




?>