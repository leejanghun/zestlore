<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class widget_top extends Widget
{

    public function __construct()
    {
        $this->CI = & get_instance();

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


//        switch( strtoupper( $arr_VARIABLE_DATA['controller'] ) )
//        {
//            default:
//                echo "Undefine Active Node"."<BR>";
//                echo strtoupper( $arr_VARIABLE_DATA['controller'] )."<BR>";
//                echo strtoupper( $arr_VARIABLE_DATA['function'] )."<BR>";
//        }// end switch


		//debug_var($_COOKIE);




		switch( strtoupper( $arr_VARIABLE_DATA['controller'] ) )
		{
			// 병원
			case "HOSPITAL_DEFAULT":
				$arr_VARIABLE_DATA['HOSPITAL_INFO_ACTIVE']   =   "active";
				break;


			// 관광 - 한국어
			case "TOUR_DEFAULT":
				$arr_VARIABLE_DATA['TOUR_INFO_ACTIVE']   =   "active";
				break;

			// 관광 - 영어
			case "TOUREN_DEFAULT":
				$arr_VARIABLE_DATA['TOUREN_INFO_ACTIVE']   =   "active";
				break;

			// 관광 - 일어
			case "TOURJP_DEFAULT":
				$arr_VARIABLE_DATA['TOURJP_INFO_ACTIVE']   =   "active";
				break;

			// 관광 - 스페인
			case "TOURSP_DEFAULT":
				$arr_VARIABLE_DATA['TOURSP_INFO_ACTIVE']   =   "active";
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



		////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////
		/// @ 버튼 링크

		// 메인
		$arr_VARIABLE_DATA['url_go_top_home']   =   $arr_VARIABLE_DATA['siteURL'];

		// 병원목록
		$arr_VARIABLE_DATA['url_go_top_hospital']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_top_hospital']   .=  "index.php/hospital_default/hospital_list";

		// 관광 목록
		$arr_VARIABLE_DATA['url_go_top_tour']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_top_tour']   .=  "index.php/tour_default/tour_list";


		// 관광 영문 목록
		$arr_VARIABLE_DATA['url_go_top_tourEn']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_top_tourEn']   .=  "index.php/tourEn_default/tourEn_list";


		// 관광 일어 목록
		$arr_VARIABLE_DATA['url_go_top_tourJp']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_top_tourJp']   .=  "index.php/tourJp_default/tourJp_list";

		// 관광 스페인 목록
		$arr_VARIABLE_DATA['url_go_top_tourSp']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_top_tourSp']   .=  "index.php/tourSp_default/tourSp_list";


		/// @ 버튼 링크
		////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////





		$htmlFilePath   =   "widget_top.html"; //

        $rtnValue	    =	$this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);


        return $rtnValue;

    }//	end function

}//	class


?>
