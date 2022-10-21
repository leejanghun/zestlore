<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function js($content) {
	return "
	<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n
	<script type=\"text/javascript\" charset=\"utf-8\">".$content."</script>
	";
}


function alert($msg) {
	$msg = str_replace('<br />','\n',$msg);
	echo js("alert('$msg')");

}


function alert_focus($msg,$element_name='',$target='parent') {
	$msg = str_replace('<br />','\n',$msg);

	echo("<script type='text/javascript'>");
	echo("alert('{$msg}');");
	if($element_name){
		echo("{$target}.document.getElementsByName('{$element_name}')[0].focus()");
	}

	echo("</script>");

}

function pageRedirect($url, $msg = '', $target = 'self') {
	if ($msg) {
		alert($msg);
	}
	echo js($target . ".document.location.replace('$url')");
}

function pageLocation($url, $msg = '', $target = 'self') {
	if ($msg) {
		alert($msg);
	}
	echo js($target . ".document.location.href='$url'");
}

function pageBack($msg = '', $target = 'self', $allow_exit = true) {
	if ($msg) {
		alert($msg);
	}

	// 리퍼러 체크해서 없으면 메인으로 이동
	$CI			=& get_instance();
	$referer	= $CI->input->server('HTTP_REFERER');

	// 리퍼러 도메인이 현재 페이지의 도메인과 다르면 root 로 redirect
	if(!empty($referer)) {
		$refererInfo = parse_url($referer);
		$refererHost = $refererInfo['host'];
		$host = $CI->input->server('HTTP_HOST');
		if($host !== $refererHost) {
			unset($referer);
		}
	}

	if(empty($referer)){
		echo js($target . ".document.location.href='/';");
	}else{
		echo js("history.back();");
	}

	if($allow_exit){
		exit;
	}
}

function history_back($msg = '') {
	if ($msg) {
		alert($msg);
	}

	echo js("history.back();");
	exit;

}

function pageReload($msg = '', $target = 'self') {
	if ($msg) {
		alert($msg);
	}
	echo js($target . ".document.location.reload();");
	if($target=='parent' || $target=='top') echo js("document.location.href='about:blank';");
}

function pageClose($msg = '') {
	if ($msg) {
		alert($msg);
	}
	echo js("self.close();");
}

function openerRedirect($url, $msg = '') {
	if ($msg) {
		alert($msg);
	}
	echo js("opener.document.location.replace('$url')");
}

function openDialog($title, $layerId, $customOptions=array(), $target = 'self', $callback='') {
	$CI =& get_instance();

	if	(strpos($_SERVER['HTTP_USER_AGENT'], "Firefox") !== false) {
		if (strpos($callback, "location.reload()") !== false) $callback = str_replace("location.reload()","location.reload(true)",$callback);
	}

	echo("<script type='text/javascript'>");
	echo("{$target}.loadingStop('body',true);");
	echo("{$target}.loadingStop();");
	echo("{$target}.openDialog('{$title}', '{$layerId}', ".json_encode($customOptions).", function(){{$callback}});");
	echo("</script>");
}

function openDialogAlert($msg,$width,$height,$target = 'self',$callback='',$options=array(),$mobileMode=false) {

	if($mobileMode){
		$msg = str_replace(array("<br />","<br/>","<br>"),"",$msg);
		$msg = strip_tags($msg);
	}


	if (strpos($_SERVER['HTTP_USER_AGENT'], "Firefox") !== false) {
		if (strpos($callback, "location.reload()") !== false) $callback = str_replace("location.reload()","location.reload(true)",$callback);
	}

	echo("<script type='text/javascript'>");
	//echo("{$target}.loadingStop('body',true);");
	//echo("{$target}.loadingStop();");
	echo("{$target}.openDialogAlert('{$msg}','{$width}','{$height}',function(){{$callback}},".json_encode($options).");");
	echo("</script>");

}

function openDialogConfirm($msg,$width,$height,$target = 'self',$yesCallback='',$noCallback='',$mobileMode=false) {

	if($mobileMode){
		$msg = str_replace(array("<br />","<br/>","<br>"),"",$msg);
		$msg = strip_tags($msg);
	}

	echo("<script type='text/javascript'>");
	echo("{$target}.loadingStop();");
	echo("{$target}.openDialogConfirm('{$msg}','{$width}','{$height}',function(){{$yesCallback}},function(){{$noCallback}});");
	echo("</script>");
}

// 배열로 폼을 만들어서 submit해 주는 함수
function arrayToFormSubmit($formName, $formAction, $params, $formTarget = '', $noSubmit = ''){
	if	(is_array($params) && count($params) > 0){
		echo '<form name="' . $formName . '" method="post" action="' . $formAction . '"';
		if	($formTarget)	echo ' target="' . $formTarget . '"';
		echo '>';
		foreach($params as $name => $value){
			if	(strlen($value) > 255){
				echo '<textarea name="' . $name . '" style="display:none;">' . $value . '</textarea>';
			}else{
				echo '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
			}
		}
		echo '</form>';

		if	($noSubmit != 'y'){
			echo '<script>' . $formName . '.submit();</script>';
		}
	}
}


// END
/* End of file helper.php */
/* Location: ./app/helper/javascript.php */
