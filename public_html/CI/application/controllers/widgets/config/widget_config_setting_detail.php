<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_config_setting_detail extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{
		//debug_var(simple_debug_backtrace());

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



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 전달값

		$arr_VARIABLE_DATA['config_10_pk']	=	$this->CI->input->get_post("config_10_pk");

		/// @ 전달값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	게시물 데이타 가져오기


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////// config_10_default
		$tmp_config_100	=	$this->CI->Config_model->get_config_10_pk( $arr_VARIABLE_DATA['config_10_pk'] );
		$arr_config_100	=	$tmp_config_100[0];

		$arr_VARIABLE_DATA['config_10_pk'] = $arr_config_100['config_10_pk'] ;
		$arr_VARIABLE_DATA['config_10_code'] = $arr_config_100['config_10_code'] ;
		$arr_VARIABLE_DATA['config_10_input'] = $arr_config_100['config_10_input'] ;
		$arr_VARIABLE_DATA['config_10_opt'] = $arr_config_100['config_10_opt'] ;
		$arr_VARIABLE_DATA['config_10_value'] = $arr_config_100['config_10_value'] ;
		$arr_VARIABLE_DATA['config_10_desc'] = $arr_config_100['config_10_desc'] ;
		$arr_VARIABLE_DATA['config_10_title'] = $arr_config_100['config_10_title'] ;

		$arr_VARIABLE_DATA['config_10_desc2'] = nl2br($arr_config_100['config_10_desc']) ;

		//////// config_10_default
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//	@	게시물 데이타 가져오기
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/config_default/config_setting_list";

		$arr_VARIABLE_DATA['url_go_modify'] =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_modify'] .=   "index.php/config_default/config_setting_modifyForm";
		$arr_VARIABLE_DATA['url_go_modify'] .=   "?config_10_pk=".$arr_VARIABLE_DATA['config_10_pk'];


		$arr_VARIABLE_DATA['url_go_delete'] =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_delete'] .=   "index.php/config_default/dbProc_config_setting_delete";


		return $this->CI->parser->parse('widgets/config/widget_config_setting_view.html', $arr_VARIABLE_DATA, true);


	}//	end function


}

?>















