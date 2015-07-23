<?php 
/**
 * 首页分馆模块编辑
 **@copyright Copyrights (c) 2015 EMall Inc. */
defined('InShopNC') or exit('Access Invalid!');
class web_homeviewControl extends SystemControl {
	public function __construct() {
		parent::__construct();
		if (strtoupper(CHARSET) == 'GBK') {
			$_GET = Language::getGBK($_GET);
			$_POST = Language::getGBK($_POST);
		}
		Language::read('web_config,control');
		Tpl::setLayout('homeview_layout');
	}
	
	/* homeview TESTING DATA begin */
	private function _homeview_genData(){
		$this->homeview_template_list = array (
			0 => array('homeview_template_id' => 0, 'homeview_template_name' => '易购达_默认', 'homeview_template_code' => 'ebd_default'),
			1 => array('homeview_template_id' => 1, 'homeview_template_name' => '易购达_澳洲模板', 'homeview_template_code' => 'ebd_au'),
		);
		
		$this->homeview_list = array(
			1 => array('homeview_id' => 1, 'homeview_sort' => 0, 'sale_area_id' => 2, 'homeview_template_id' => '0', 'homeview_name' => '默认', 'update_time' => 1435345678, 'homeview_show' => 1),
			2 => array('homeview_id' => 2, 'homeview_sort' => 1, 'sale_area_id' => 3, 'homeview_template_id' => '1', 'homeview_name' => '澳洲商城', 'update_time' => 1435645678, 'homeview_show' => 1),
			3 => array('homeview_id' => 3, 'homeview_sort' => 2, 'sale_area_id' => 2, 'homeview_template_id' => '0', 'homeview_name' => '中国商城', 'update_time' => 1435645678, 'homeview_show' => 0),
			4 => array('homeview_id' => 4, 'homeview_sort' => 3, 'sale_area_id' => 2, 'homeview_template_id' => '1', 'homeview_name' => '美国商城', 'update_time' => 1435645678, 'homeview_show' => 1)
		);
		Tpl::output('homeview_list', $this->homeview_list);
	}
	/* homeview TESTING DATA end*/
	
	/**
	 * 分馆列表
	 */
	public function indexOp() {
		$model_homeview = Model('web_homeview');
		$model_homeview_template = Model('web_homeview_template');
		$model_sale_area = Model('sale_area');
		
		$sampleRows = $model_homeview->limit(1)->select();
		$data = $sampleRows[0];
		
		switch ($_REQUEST['rest']) {
			case 'post':
				$result['msg'] = 'insert-failed';

				foreach($data as $key => $val){
					if (isset($_POST[$key])) {
						$data[$key] = $_POST[$key];
					}
				}
				unset($data['homeview_id']);
				$model_homeview->insert($data);
				
				$result['msg'] = 'insert-success';
				
				Tpl::output('result', $result);
				break;
			case 'put':
				$result['msg'] = 'update-failed';
				
				$data['sale_area_id'] 		= $_POST['sale_area_id'];
				$data['sale_area_name'] 	= $_POST['sale_area_name'];
				$data['iso_id'] 				= $_POST['iso_id'];
				$data['iso_code'] 			= $_POST['iso_code'];
				$data['sale_area_show'] 	= $_POST['sale_area_show'];
				
				$model_homeview->update($data);
				
				$result['msg'] = 'update-success';
				Tpl::output('result', $result);
				break;
			case 'delete':
				$result['msg'] = 'delete-failed';
				
				$model_homeview->delete($_REQUEST['id']);
				
				$result['msg'] = 'delete-success';
				Tpl::output('result', $result);
				break;
		}
		
		// 搜索
		if (isset($_GET['keyword'])) {
			$keyword = $_GET['keyword'];
			$condition_homeview['homeview_name'] = array('like', '%'.$keyword.'%');
		}
		$condition_homeview['ifTrash'] = 0;
		
		$homeview_list = $model_homeview->where($condition_homeview)->page(10)->order('homeview_sort asc')->select();
		$homeview_template_list = $model_homeview_template->select();
		$sale_area_list = $model_sale_area->where(Array('sale_area_show'=>1))->order('sale_area_name')->select();
		
		
		Tpl::output('homeview_list', $homeview_list);
		Tpl::output('homeview_template_list', $homeview_template_list);
		Tpl::output('salearea_list', $sale_area_list);
		Tpl::output('page', $model_sale_area->showpage(2));
		
		Tpl::showpage('web_homeview.index');
	}
	
	/**
	 * 模板操作
	 */
	public function homeview_templateOp() {
		$table = 'web_homeview_template';
		$title = '分馆模板';
		$fields = array();
		$model = Model($table);
		$result = array(
			'msg' => ''
		);
		
		// 搭建数据结构
		$sql = 'DESCRIBE '.DBPRE.$table;
		$rgColumn = Model()->query($sql);
		
		foreach($rgColumn as $val){
			$data[$val['Field']] = '';
			array_push($fields, $val['Field']);
		}
		
		// RESTfull 数据处理
		switch ($_REQUEST['rest']) {
			case 'post':
				$result['msg'] = 'insert-failed';

				foreach($data as $key => $val){
					if (isset($_POST[$key])) {
						$data[$key] = $_POST[$key];
					}
				}
				
				unset($data['homeview_template_id']);
				unset($data['id']);
				$model->insert($data);
				
				$result['msg'] = 'insert-success';
				
				Tpl::output('result', $result);
				break;
			case 'put':
				$result['msg'] = 'update-fail';
				
				$data['sale_area_id'] 		= $_POST['sale_area_id'];
				$data['sale_area_name'] 	= $_POST['sale_area_name'];
				$data['iso_id'] 				= $_POST['iso_id'];
				$data['iso_code'] 			= $_POST['iso_code'];
				$data['sale_area_show'] 	= $_POST['sale_area_show'];
				
				$model->update($data);
				
				$result['msg'] = 'update-success';
				Tpl::output('result', $result);
				break;
			case 'delete':
				$result['msg'] = 'delete-fail';
				
				if($_REQUEST['id'] == 0){
					$result['reason'] = 'can\'t remove default';
				} else {
					$model->delete($_REQUEST['id']);
					$result['msg'] = 'delete-success';
				}
				
				Tpl::output('result', $result);
				break;
			default:
				$result['msg'] = 'list item';
				Tpl::output('result', $result);
		}
		
		// 搜索
		/*
		if (isset($_GET['keyword'])) {
			$keyword = $_GET['keyword'];
			$condition_homeview['homeview_name'] = array('like', '%'.$keyword.'%');
		}
		$condition_homeview['ifTrash'] = 0;
		
		$homeview_list = $model_homeview->where($condition_homeview)->page(10)->order('homeview_sort asc')->select();
		$homeview_template_list = $model_homeview_template->select();
		
		
		
		
		
		Tpl::output('homeview_template_list', $homeview_template_list);
		Tpl::output('salearea_list', $sale_area_list);
		Tpl::output('page', $model_sale_area->showpage(2));
		*/
		
		$datalist = $model->select();
		foreach($datalist as $index => $row){
			$datalist[$index]['id'] = $row['homeview_template_id'];
		}
		Tpl::output('fields', $fields);
		Tpl::output('title', $title);
		Tpl::output('datalist', $datalist);
		
		Tpl::showpage('web_homeview_template.index');
		//var_dump($datalist);
		var_dump($fields);
	}
	
	
	/**
	 * 分馆页面编辑
	 */
	public function homeview_editOp() {
		$this->_homeview_genData();
		$model_web_homeview = Model('web_homeview');
		$model_web_homeview_template = Model('web_homevew_template');
		
		$homeview_id = 0;
		$homeview_template_id = 0;
		
		$homeview_id = $this->_homeview_getHomeviewId();
		$homeviewInfo = $model_web_homeview->find($homeview_id);
		
		// 判断获得 $homeview_template_id 
		$homeview_template_id = $this->homeview_list[$homeview_id]['homeview_template_id'];
		if(isset($_GET['homeview_template_id'])){
			$homeview_template_id = $_GET['homeview_template_id'];
		}
		Tpl::output('homeviewInfo', $homeviewInfo);
		Tpl::output('homeview_id', $homeview_id);
		Tpl::output('homeview_name', $this->homeview_list[$homeview_id]['homeview_name']);
		
		Tpl::output('homeview_template_name', $this->homeview_template_list[$homeview_template_id]['homeview_template_name']);
		Tpl::output('homeview_template_code', $this->homeview_template_list[$homeview_template_id]['homeview_template_code']);
		Tpl::output('homeview_template_id', $homeview_template_id);
		Tpl::output('homeview_template_list', $this->homeview_template_list);
		
		Tpl::showpage('web_homeview.edit', 'homeview_layout');
		var_dump($homeview_id);
		var_dump($rowHomeview);
	}
		// 分馆基本信息编辑
	public function homeview_basicOp() {
		$this->homeview_genData();
		$homeview_id = 0;
		$homeview_id = $this->homeview_getHomeviewId();
		
		Tpl::output('homeview_id', $homeview_id);
		Tpl::output('homeview', $this->homeview_list[$homeview_id]);
		
		// 获取销售区域表数据
		$model_sale_area = Model('sale_area');
		Tpl::output('salearea_list', $model_sale_area->getArray_resetKeys());
		
		Tpl::showpage('web_homeview.basic');
	}
	public function homeview_basicUpdateOp() {
		
	}
	

	private function _homeview_getHomeviewId() {
		$homeview_id = 0; // 默认的 homview_id;
		
		// 判断 homeview_id 设置
		if(!is_int(filter_input(INPUT_GET, 'homeview_id', FILTER_VALIDATE_INT))){
			showMessage('首页编号未设置，进入默认列表页面','index.php?act=web_homeview&op=homeview_index');
		}
		
		if(isset($_GET['homeview_id'])){
			$homeview_id = $_GET['homeview_id'];
		}
		return $homeview_id;
	}
	/**
	 * 销售区域编辑
	 */
	public function homeview_saleareaOp() {
		$model_sale_area = Model('sale_area');
		$condition = '';
		// 增删改
		switch ($_REQUEST['rest']) {
			case 'post':
				$result['msg'] = 'insert-failed';
				$data = array();
				$data['sale_area_name'] 	= '';
				$data['iso_id'] 				= 0;
				$data['iso_code'] 			= '';
				$data['sale_area_show']	= 0;
				
				foreach($data as $key => $val){
					if (isset($_POST[$key])) {
						$data[$key] = $_POST[$key];
					}
				}
				$model_sale_area->insert($data);
				
				$result['msg'] = 'insert-success';
				
				Tpl::output('result', $result);
				break;
			case 'put':
				$result['msg'] = 'update-failed';
				
				$data['sale_area_id'] 		= $_POST['sale_area_id'];
				$data['sale_area_name'] 	= $_POST['sale_area_name'];
				$data['iso_id'] 				= $_POST['iso_id'];
				$data['iso_code'] 			= $_POST['iso_code'];
				$data['sale_area_show'] 	= $_POST['sale_area_show'];
				
				$model_sale_area->update($data);
				
				$result['msg'] = 'update-success';
				Tpl::output('result', $result);
				break;
			case 'delete':
				$result['msg'] = 'delete-failed';
				$model_sale_area->delete($_REQUEST['id']);
				$result['msg'] = 'delete-success';
				Tpl::output('result', $result);
				break;
		}
		
		// 搜索
		if (isset($_GET['keyword'])) {
			$keyword = $_GET['keyword'];
			
			//$condition['iso_code'] = array(array('like', '%'.$keyword.'%'));
			$condition['sale_area_id|sale_area_name|iso_code|iso_id'] = array('like', '%'.$keyword.'%');
		}
		
		$salearea_list = $model_sale_area->where($condition)->order('sale_area_id desc')->page(10)->select();
		Tpl::output('salearea_list', $salearea_list);
		Tpl::output('page', $model_sale_area->showpage(2));
		Tpl::showpage('web_homeview_salearea.index');
	}
	/**
	 * 头部切换图设置
	 */
	public function focus_editOp() {
		$homeview_id = $_GET['homeview_id'];
	    $model_web_config = Model('web_config');
	    $web_id = '101';
	    $code_list = $model_web_config->getCodeList(array('web_id'=> $web_id));
		
	    if(is_array($code_list) && !empty($code_list)) {
			foreach ($code_list as $key => $val) {//将变量输出到页面
				$var_name = $val['var_name'];
				$code_info = $val['code_info'];
				$code_type = $val['code_type'];
				$val['code_info'] = $model_web_config->get_array($code_info,$code_type);
				Tpl::output('code_'.$var_name,$val);
			}
		}
		$screen_adv_list = $model_web_config->getAdvList("screen");//焦点大图广告数据
		Tpl::output('screen_adv_list',$screen_adv_list);
		
		
		Tpl::showpage('web_homeview/ebd_default/web_focus.edit');
	}
	
	/**
	 * 保存焦点区切换大图
	 */
	public function screen_picOp() {
		$code_id = intval($_POST['code_id']);
		$web_id = intval($_POST['web_id']);
		$homeview_id = intval($_POST['homeview_id']);
		
		$model_web_config = Model('web_config');
		$code = $model_web_config->getCodeRow($code_id,$web_id);
		
		// insert
		
		
		// update
		if (!empty($code)) {
			$code_type = $code['code_type'];
			$var_name = $code['var_name'];
			$code_info = $_POST[$var_name];

			$key = intval($_POST['key']);
			$ap_pic_id = intval($_POST['ap_pic_id']);
			if ($ap_pic_id > 0 && $ap_pic_id == $key) {
			    $ap_color = $_POST['ap_color'];
			    $code_info[$ap_pic_id]['color'] = $ap_color;
			    Tpl::output('ap_pic_id',$ap_pic_id);
			    Tpl::output('ap_color',$ap_color);
			}
			$pic_id = intval($_POST['screen_id']);
			if ($pic_id > 0 && $pic_id == $key) {
    			$var_name = "screen_pic";
    			$pic_info = $_POST[$var_name];
    			$pic_info['pic_id'] = $pic_id;
    			if (!empty($code_info[$pic_id]['pic_img'])) {//原图片
    			    $pic_info['pic_img'] = $code_info[$pic_id]['pic_img'];
    			}
    			$file_name = 'web-'.$web_id.'-'.$code_id.'-'.$pic_id;
    			$pic_name = $this->_upload_pic($file_name);//上传图片
    			if (!empty($pic_name)) {
    				$pic_info['pic_img'] = $pic_name;
    			}

			    $code_info[$pic_id] = $pic_info;
			    Tpl::output('pic',$pic_info);
			}
			$code_info = $model_web_config->get_str($code_info,$code_type);
			$model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));

    		Tpl::showpage('web_upload_screen','null_layout');
		}
	}
	/**
	 * 上传图片
	 */
	private function _upload_pic($file_name) {
	    $pic_name = '';
	    if (!empty($file_name)) {
			if (!empty($_FILES['pic']['name'])) {//上传图片
				$upload = new UploadFile();
				$filename_tmparr = explode('.', $_FILES['pic']['name']);
				$ext = end($filename_tmparr);
    			$upload->set('default_dir',ATTACH_EDITOR);
    			$upload->set('file_name',$file_name.".".$ext);
				$result = $upload->upfile('pic');
				if ($result) {
					$pic_name = ATTACH_EDITOR."/".$upload->file_name.'?'.mt_rand(100,999);//加随机数防止浏览器缓存图片
				}
			}
	    }
	    return $pic_name;
	}
}