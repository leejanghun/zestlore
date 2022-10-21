<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_config_modifyForm extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{

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
		$arr_VARIABLE_DATA['config_10_value'] = $arr_config_100['config_10_value'] ;
		$arr_VARIABLE_DATA['config_10_input'] = $arr_config_100['config_10_input'] ;
		$arr_VARIABLE_DATA['config_10_opt'] = $arr_config_100['config_10_opt'] ;
		$arr_VARIABLE_DATA['config_10_desc'] = $arr_config_100['config_10_desc'] ;

		$arr_VARIABLE_DATA['config_10_desc2'] = nl2br($arr_config_100['config_10_desc']) ;
		//////// config_10_default
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		////////////////////////////////////////////////////
		/// 라디오 타입인경우 select box 생성
		switch ($arr_config_100['config_10_input'])
		{
			case "radio":

				$tmp_opt = explode("|",$arr_config_100['config_10_opt']);
				$cnt_tmp_opt = count($tmp_opt);

				$selectBox = array();

				for($i=0;$i<$cnt_tmp_opt;$i++)
				{
					$selectBox[$i]['value']=$tmp_opt[$i];
					$selectBox[$i]['print']=$tmp_opt[$i];
				}

				$selectElement['id']= "config_10_value";
				$selectElement['name']= "config_10_value";
				$selectElement['class']= "config_10_value";

				$selectSelected = $arr_config_100['config_10_value'];


 				$arr_VARIABLE_DATA['select_config_10_value'] = $this->CI->html_produce->selectBox($selectBox,$selectElement,$selectSelected);
			break;
		}
		/// 라디오 타입인경우 select box 생성
		////////////////////////////////////////////////////

		//	@	게시물 데이타 가져오기
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ 링크
		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/config_default/config_list";

		$arr_VARIABLE_DATA['url_go_view']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_view']   .=  "index.php/config_default/config_detail";
		$arr_VARIABLE_DATA['url_go_view'] .=   "?config_10_pk=".$arr_VARIABLE_DATA['config_10_pk'];

		$arr_VARIABLE_DATA['url_go_submit']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit']   .=  "index.php/config_default/dbProc_config_update";

		// @ 링크
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		switch ($arr_config_100['config_10_input'])
		{
			case "number":
			case "text":
				$parser_html = "widgets/config/widget_config_modifyForm.html";
				break;
			case "editor":
				$parser_html = "widgets/config/widget_config_modifyForm_editor.html";
				break;
			case "radio":
				$parser_html = "widgets/config/widget_config_modifyForm_radio.html";
				break;
		}

		return $this->CI->parser->parse( $parser_html , $arr_VARIABLE_DATA, true);


	}//	end function


}

?>















