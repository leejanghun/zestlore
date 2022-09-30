<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_leftMenu extends Widget
{

    public function __construct()
    {
        $this->CI = & get_instance();

    }//	end function


    public function run( $arrayData )
    {

		$arr_searchValue        =   null;
		$arr_searchValue        =   array();

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$arr_VARIABLE_DATA	    =	null;
		$arr_VARIABLE_DATA		=	array();
		$arr_VARIABLE_DATA		=	$arrayData;

		$arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
		$arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
		$arr_VARIABLE_DATA['function']			=	$arrayData['function'];

		$arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/index.php";
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['controller'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['function'];



        switch( strtoupper( $arr_VARIABLE_DATA['controller'] ) )
        {
			// 관리자 관리
            case "ADMIN_DEFAULT":
                $arr_VARIABLE_DATA['MEMBER_INFO_ACTIVE']   =   "active";
                break;


			/*	예제
			
						// 게시판
						case "BOARD_DEFAULT":
			
							switch( strtoupper( $arr_VARIABLE_DATA['function'] ) )
							{
								case "RECORD_LIST":
			
									if( isset($this->CI->arr_segment['bbs_flag']) == false )
									{
										$arr_VARIABLE_DATA['BOARD_ALL_RECORD_ACTIVE']    =   "active";
									}else{
			
										switch( strtoupper( $this->CI->arr_segment['bbs_flag'] ) )
										{
											case "NOTICE":          $arr_VARIABLE_DATA['BOARD_NOTICE_INFO_ACTIVE']          =   "active";   break;
											case "JAVASCRIPT":      $arr_VARIABLE_DATA['BOARD_JAVASCRIPT_INFO_ACTIVE']      =   "active";   break;
											case "PHP":             $arr_VARIABLE_DATA['BOARD_PHP_INFO_ACTIVE']             =   "active";   break;
											case "LINUX_CENTOS":    $arr_VARIABLE_DATA['BOARD_LINUX_CENTOS_INFO_ACTIVE']    =   "active";   break;
											case "LINUX_UBUNTU":    $arr_VARIABLE_DATA['BOARD_LINUX_UBUNTU_INFO_ACTIVE']    =   "active";   break;
											case "ETC":             $arr_VARIABLE_DATA['BOARD_ETC_ACTIVE']                  =   "active";   break;
										}// end switch
									}// end if
			
									break;
							}// end switch( strtoupper( $arr_VARIABLE_DATA['function'] ) )
							break;
			
							// 모름
						case "JOB_MANAGEMENT":
							$arr_VARIABLE_DATA['JOB_MANAGEMENT_ACTIVE']   =   "active";
							break;
							*/



            default:
                echo "Undefine Active Node"."<BR>";
                echo strtoupper( $arr_VARIABLE_DATA['controller'] )."<BR>";
                echo strtoupper( $arr_VARIABLE_DATA['function'] )."<BR>";
        }// end switch



		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// 개발자용 메뉴 숨기기 - 운영서버 ,개발서버

		$server_uname = $this->CI->zest_common->get_server_uname();

		$arr_VARIABLE_DATA['left_menu_hide'] = "hide";

		//debug_var($server_uname['server_nick']);

		switch ($server_uname['server_nick'])
		{
			case "ljh_vbox":
				$arr_VARIABLE_DATA['left_menu_hide'] = "";
				break;
		}


		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		$arr_VARIABLE_DATA['url_go_login']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_login']   .=  "index.php/Admin_login/login_write";


        $htmlFilePath   =   "widget_leftMenu.html";

        $rtnValue	    =	$this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);


        return $rtnValue;

    }//	end function

}//	class


?>
