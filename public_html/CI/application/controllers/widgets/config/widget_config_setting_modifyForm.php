<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_config_setting_modifyForm extends Widget {


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

		////////////////////////////// 체크박스 처리
		///  enum_field_checked - db에서 enum 타입 필드의 설정값을 가져와서 checked 값 만듬 /// table , field , 값
		$tmp_enum_field_checked = null;
		$tmp_enum_field_checked = $this->CI->zest_common->enum_field_checked("config_10_default","config_10_input",$arr_VARIABLE_DATA['config_10_input']);
		$arr_VARIABLE_DATA = array_merge($arr_VARIABLE_DATA,$tmp_enum_field_checked);


		//////// 디스플레이 처리
		$arr_VARIABLE_DATA['display_config_10_input'] = "hide";
		if($arr_config_100['config_10_input']=="radio")
		{
			$arr_VARIABLE_DATA['display_config_10_input'] = "";
		}

		//////// config_10_default
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//	@	게시물 데이타 가져오기
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ 링크

		$arr_VARIABLE_DATA['url_go_submit']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit']   .=  "index.php/config_default/dbProc_config_setting_update";

		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/config_default/config_setting_list";

		$arr_VARIABLE_DATA['url_go_view'] =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_view'] .=   "index.php/config_default/config_setting_detail";
		$arr_VARIABLE_DATA['url_go_view'] .=   "?config_10_pk=".$arr_VARIABLE_DATA['config_10_pk'];

		// @ 링크
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		return $this->CI->parser->parse('widgets/config/widget_config_setting_modifyForm.html', $arr_VARIABLE_DATA, true);

	}//	end function


}

?>















