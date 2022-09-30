<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_loginForm extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{

//		debug_var(__FILE__);
//		debug_var(__LINE__);
//		exit;

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

//		$arr_VARIABLE_DATA['member_10_type']	= "";
//		$arr_VARIABLE_DATA['member_10_id']		= "";
//		$arr_VARIABLE_DATA['member_10_pw1']		= "";
//		$arr_VARIABLE_DATA['member_10_pw2']		= "";


		$arr_VARIABLE_DATA['url_go_submit']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_submit']   .=  "index.php/Admin_login/login_proc";

		$arr_VARIABLE_DATA['url_login_after']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_login_after']   .=  "index.php/Admin_default/admin_list";

		//return $this->CI->parser->parse('test.html', $arr_VARIABLE_DATA, true);
		return $this->CI->parser->parse('widgets/login/widget_loginForm.html', $arr_VARIABLE_DATA, true);
	}//	end function


}

?>















