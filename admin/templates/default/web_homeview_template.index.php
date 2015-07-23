<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- homeview 列表编辑默认模板 -->
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/homeview.css"/>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_web_index'];?></h3>
      <?php require_once template('web_homeview_tab')?>
    </div>
  </div>
  <div class="fixed-empty"></div>
		<table class="table">
			<tr>
				<form id="formAdd" method="post">
					<input type="hidden" name="act" value="web_homeview">
					<input type="hidden" name="op" value="homeview_template">
					<input type="hidden" name="rest" value="post">
					
					<?php foreach ($output['fields'] as $key => $val) { if ($key == 0) {continue;}?>
					<td><input type="text" class="txt" name="<?php echo $val;?>" placeholder="<?php echo $lang[$val]; ?>"></td>
					<?php } ?>
					<td class="align-center"><input type="submit" value="<?php echo $lang["nc_add"]; ?>"></td>
				</form>
			<td class="tr">
				<form method="get" name="formSearch" id="formSearch">
					<input type="hidden" name="act" value="web_homeview">
					<input type="hidden" name="op" value="homeview_salearea_index">
					<input name="keyword" class="txt" type="text" placeholder="搜索<?php echo $output['title']?> ">
					<a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
				</form>
			</td>
			</tr>
		</table>
  
    <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
			<ul>
				<li>{帮助信息}</li>
			</ul>
		</td>
      </tr>
    </tbody>
  </table>
	<div ng-app="saleareaApp" ng-controller="saleareaCtrl">
		<table class="table tb-type2">
			<thead>
				<tr class="space">
					<th colspan="15">
						<?php echo $output['title']?> 列表
					</th>
				</tr>
				<tr class="thead">
					<?php foreach ($output['fields'] as $key => $val) { ?>
					<th><?php echo $lang[$val]; ?></th>
					<?php } ?>
					<th class="align-center"><?php echo $lang['nc_handle'];?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($output['datalist']) && is_array($output['datalist'])){ ?>
				<?php foreach($output['datalist'] as $key => $val) { ?>
					<tr>
						<form id="formUpdate_<?php echo $val['id']?>" method="post">
							<input type="hidden" name="act" value="web_homeview">
							<input type="hidden" name="op" value="homeview_salearea_index">
							<input type="hidden" name="rest" value="put">
							<input type="hidden" name="time" value="<?php echo time();?>">
							<input type="hidden" name="id" value="<?php echo $val['id']?>">
							<td><?php echo $val['id']?></td>
							<td><input type="text" name='sale_area_name' value="<?php echo $val['homeview_template_name']?>"></td>
							<td><input type="text" name='iso_id' value="<?php echo $val['homeview_template_code']?>"></td>
						</form>
						<td class="align-center">
							<input type="button" onclick="formSubmit('formUpdate_<?php echo $val['id']?>')" value="<?php echo $lang['nc_update'];?>">
							<input type="button" onclick="formSubmit('formDelete_<?php echo $val['id']?>')" value="<?php echo $lang["nc_delete"]; ?>">
							<form id="formDelete_<?php echo $val['id']?>" method="post">
								<input type="hidden" name="act" value="web_homeview">
								<input type="hidden" name="op" value="homeview_salearea_index">
								<input type="hidden" name="rest" value="delete">
								<input type="hidden" name="curpage" value="<?php echo $_GET['curpage']?>">
								<input type="hidden" name="id" value="<?php echo $val['id'];?>">
							</form>
						</td>
					</tr>
				<?php } ?>
				<?php }else { ?>
					<tr class="no_data">
					  <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="15">
						<div class="pagination"> <?php echo $output['page'];?></div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<form id="hiddenForm" method="get">
	<input type="hidden" value="<?php echo time()?>">
	<input type="hidden" name="act" value="web_homeview">
	<input type="hidden" name="op" value="homeview_salearea_index">
</form>
<script>
var feedback = '<?php echo $output['result']['msg'] ?>';
var reason = '<?php echo $output['result']['reason'] ?>';
switch (feedback) {
	case 'update-success':
		alert("更新成功!");
		break;
	case 'update-fail':
		alert("更新失败!");
		break;
	case 'delete-success':
		alert("删除成功!");
		break;
	case 'delete-fail':
		alert(reason);
		break;
	case 'insert-success':
		alert("添加成功!");
		break;
	case 'failed':
		alert(reason);
	default:
		// nothing...
}
function formSubmit(formId){
	$("#"+formId).submit();
	//$("#hiddenForm").submit();
}
/*
var saleareaApp = angular.module('saleareaApp', []);
saleareaApp.controller('saleareaCtrl', function($scope, $http) {
	$http.get("index.php?act=web_api&op=salearea")
	.success(function (response) {
		$scope.salearea = response.records;
	});
	$scope.removeRow = function(id){
		url = 'index.php?act=web_api&op=salearea&rest=delete&id=' + id;
		$http.get(url)
		.success(function(response){
			angular.copy(response.records, $scope.salearea);
		});
	}
	$scope.addRow = function(){
		//window.console ? console.log('addRow') : '';
		var inputs = new Array();
		inputs['sale_area_name'] = $scope.sale_area_name || '';
		inputs['iso_id'] = $scope.iso_id || '';
		inputs['iso_code'] = $scope.is_code || '';
		
		var data = {
			'sale_area_name' : inputs['sale_area_name'],
			'iso_id' : inputs['iso_id'],
			'iso_code' : inputs['iso_code']
		};
		url = 'index.php?act=web_api&op=salearea&rest=post';
		
		$http.post(url, data)
		.success(function(response){
			window.console ? console.log(response) : '';
			$scope.salearea = response.records;
		})
		// clear up
		$scope.sale_area_name = '';
		$scope.iso_id = '';
		$scope.iso_code = '';
	}
});
*/
function salearea_delete(obj){
	// window.console ? console.log('delete') : '';
	var id = $(obj).attr('data-id');
	window.console ? console.log(id) : '';
	
	url = 'index.php?act=web_api&op=salearea&rest=delete&id=' + id;
	window.console ? console.log(url) : '';
	$.post(url, function(data){
		window.console ? console.log(data) : '';
		
	});
	
	//window.location.reload();
}

function salearea_add(obj) {
	var url = 'index.php?act=web_api&op=salearea&rest=post';
	var inputsContainers = $(obj).parents('tr').find('[class^=input-]');
	var inputs = {};
	for (i = 0; i < inputsContainers.length; i++){
		field = $(inputsContainers[i]).attr('class').replace('input-', '');
		inputs[field] = $(inputsContainers[i]).val();
	}
	//window.console ? console.log(inputs) : '';
	$.ajaxSetup({async: false});
	$.post(url, inputs, function(data) {
		window.console ? console.log(data) : '';
	});
	saleareaApp.controller('saleareaCtrl', function($scope, $http) {
		url = 'index.php?act=web_api&op=salearea&rest=get'
		var salearea = '';
		
		$.get(url, function(response){
			window.console ? console.log(response) : '';
			$scope.salearea = response.records;
		});
		window.console ? console.log('sa' + salearea) : '';
		$.ajaxSetup({async: true});
	});
}

function angularInit(modelName){
	//eval("var app = " + modelName + "App;");
	window.console ? console.log(modelName) : '';
	/*
	app.controller(modelName + 'Ctrl', function($scope, $http) {
		
		$http.get("index.php?act=web_api&op=" + modelName)
		.success(function (response) {
			eval("$scope."+modelName+" = response.records;");
		});
		
	});
	*/
}

/*
var app = angular.module('saleareaApp', []);
app.controller('saleareaCtrl', function($scope, $http) {
	$http.get("index.php?act=web_api&op=sale_area")
	.success(function(respond) { $scope.saleareas = response.data; });
});
*/
</script>