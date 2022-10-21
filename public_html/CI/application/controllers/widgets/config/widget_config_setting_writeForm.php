<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class widget_config_setting_writeForm extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{

		// debug_var(simple_debug_backtrace());exit;

		$arr_VARIABLE_DATA						=	null;
		$arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
		$arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
		$arr_VARIABLE_DATA['function']			=	$arrayData['function'];

		$arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/index.php";
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['controller'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['function'];

		$arr_Keys	=	array_keys( $arrayData['sendData'] );
		for($loopCnt=0; count($arr_Keys)>$loopCnt; $loopCnt++)
		{
			if( isset( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] ) == true )
			{
				$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]		=	urldecode( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] );
			}else{
				switch( $arr_Keys[$loopCnt] )
				{
					case "nowPage":	$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]	=	0;	break;
					default:
						exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
				}//	end switch
			}//	end if
		}//	end for

		// $arr_VARIABLE_DATA['config_10_pk'] = "";
		$arr_VARIABLE_DATA['config_10_code'] = "";
		$arr_VARIABLE_DATA['config_10_input'] = "";
		$arr_VARIABLE_DATA['config_10_value'] = "";
		$arr_VARIABLE_DATA['config_10_desc'] = "";
		$arr_VARIABLE_DATA['config_10_opt'] = "";
		$arr_VARIABLE_DATA['config_10_title'] = "";


		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/config_default/config_setting_list";

		$arr_VARIABLE_DATA['url_go_view']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_view']   .=  "index.php/config_default/config_setting_detail";

		$arr_VARIABLE_DATA['url_go_submit']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit']   .=  "index.php/config_default/dbProc_config_setting_insert";


		//return $this->CI->parser->parse('test.html', $arr_VARIABLE_DATA, true);
		return $this->CI->parser->parse('widgets/config/widget_config_setting_writeForm.html', $arr_VARIABLE_DATA, true);
	}//	end function


}

?>















