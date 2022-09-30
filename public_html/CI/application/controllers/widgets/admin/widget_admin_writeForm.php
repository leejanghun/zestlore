<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_admin_writeForm extends Widget {


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

		$arr_VARIABLE_DATA['admin_00_id']		= "";
		$arr_VARIABLE_DATA['admin_00_pw1']		= "";
		$arr_VARIABLE_DATA['admin_00_pw2']		= "";
		$arr_VARIABLE_DATA['admin_00_name']		= "";
		$arr_VARIABLE_DATA['admin_00_email']		= "";
		$arr_VARIABLE_DATA['admin_00_mobile']		= "";
		$arr_VARIABLE_DATA['admin_00_ip']       =   $this->CI->input->ip_address();

		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/Admin_default/admin_list";

		$arr_VARIABLE_DATA['url_go_submit']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit']   .=  "index.php/Admin_default/dbProc_admin_insert";

		$arr_VARIABLE_DATA['url_go_view']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_view']   .=  "index.php/Admin_default/admin_view";


		//return $this->CI->parser->parse('test.html', $arr_VARIABLE_DATA, true);
		return $this->CI->parser->parse('widgets/admin/widget_admin_writeForm.html', $arr_VARIABLE_DATA, true);
	}//	end function


}

?>















