<?php  
class Controller {
	public $data = array();


	public function __construct(){
		if(method_exists($this,'__init')){
			$this->__init();
		}
		if(method_exists($this,'__auto')){
			$this->__auto();
		}
	}

	protected function get_tpl($tpl=null){
		if(is_null($tpl)){
			$path = APP_TPL_PATH.'/'.CONTROLLER.'/'.ACTION.'.html';

		}else{
			$suffix = strrchr($tpl,'.');
			$tpl = empty($suffix)?$tpl.'.html':$tpl;
			$path = APP_TPL_PATH.'/'.CONTROLLER.'/'.$tpl;
		}
		return $path;
	}

	protected function display($tpl = null){
		$path = $this->get_tpl($tpl);
		if(!is_file($path)) {
			echo "{$path}模板文件不存在";
		}
			else{
				extract($this->data);
				include $path;
			}
	}

	protected function assign($var,$value){
		$this->data[$var] = $value;
	}

	protected function success($msg,$url=null,$time=3){
		$url = $url?"window.location.href='".$url."' ":'window.history.back(-1)';
		include APP_TPL_PATH.'/success.html';
		die;
	}	

	protected function error($msg,$url=null,$time=3){
		$url = $url?"window.location.href='".$url."'":'window.history.back(-1)';
		include APP_TPL_PATH.'/error.html';
		die;
	}
}



?>