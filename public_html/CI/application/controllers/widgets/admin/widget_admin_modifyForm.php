<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_admin_modifyForm extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{

		// debug_var(simple_debug_backtrace());exit;


		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 전달값

		$arr_VARIABLE_DATA['admin_00_pk']	=	$this->CI->input->get_post("admin_00_pk");

		/// @ 전달값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	게시물 데이타 가져오기

		$arrData              =   null;
		$arrData['sqlWhere']  =   array('admin_00_pk' =>  $arr_VARIABLE_DATA['admin_00_pk']);

		$arr_SQL_Result       =   null;
		$arr_SQL_Result       =   $this->CI->Admin_model->getAdmin_RecordList($arrData);

		$arr_admin_00 = $arr_SQL_Result[0];

		$arr_VARIABLE_DATA['admin_00_pk']				=	$arr_admin_00['admin_00_pk'];
		$arr_VARIABLE_DATA['admin_00_id']			=	$arr_admin_00['admin_00_id'];
		$arr_VARIABLE_DATA['admin_00_pw']			=	$arr_admin_00['admin_00_pw'];
		$arr_VARIABLE_DATA['admin_00_name']				=	$arr_admin_00['admin_00_name'];
		$arr_VARIABLE_DATA['admin_00_email']			=	$arr_admin_00['admin_00_email'];
		$arr_VARIABLE_DATA['admin_00_mobile']	=	$arr_admin_00['admin_00_mobile'];
		$arr_VARIABLE_DATA['admin_00_regdt']			=	$arr_admin_00['admin_00_regdt'];
		$arr_VARIABLE_DATA['admin_00_moddt']				=	$arr_admin_00['admin_00_moddt'];
		$arr_VARIABLE_DATA['admin_00_ip']		=	$arr_admin_00['admin_00_ip'];

		//	@	게시물 데이타 가져오기
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ 링크

		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/admin_default/admin_list";

		$arr_VARIABLE_DATA['url_go_view'] =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_view'] .=   "index.php/admin_default/admin_view";
		$arr_VARIABLE_DATA['url_go_view'] .=   "?admin_00_pk=".$arr_VARIABLE_DATA['admin_00_pk'];

		$arr_VARIABLE_DATA['url_go_submit'] =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit'] .=   "index.php/admin_default/dbProc_admin_update";

		// @ 링크
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		return $this->CI->parser->parse('widgets/admin/widget_admin_modifyForm.html', $arr_VARIABLE_DATA, true);
	}//	end function


}

?>















