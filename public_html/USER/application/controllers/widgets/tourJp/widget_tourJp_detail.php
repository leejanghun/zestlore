<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_tourJp_detail extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{
		// debug_var(simple_debug_backtrace());exit;

		$arr_searchValue        =   null;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$arr_VARIABLE_DATA	    =	null;
		$arr_VARIABLE_DATA		=	array();
		$arr_VARIABLE_DATA		=	$arrayData;

		$arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
		$arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
		$arr_VARIABLE_DATA['function']			=	$arrayData['function'];

		$arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['controller'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['function'];

		$arr_Keys	=	array_keys( $arrayData['sendData'] );
		for($loopCnt=0; count($arr_Keys)>$loopCnt; $loopCnt++)
		{
			if( isset( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] ) == true )
			{
				$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]		=	urldecode( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] );
			}else{

				switch($arr_Keys[$loopCnt])
				{
					case "nowPage":	$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]	=	0;	break;
					default:
						exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
				}//	end switch

			}//	end if
		}//	end for



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @필수값

		$arr_VARIABLE_DATA['tourJp_400_pk']				=	$this->CI->input->get_post("tourJp_400_pk");
		$arr_VARIABLE_DATA['per_page']				=	$this->CI->input->get_post("per_page");
		$arr_VARIABLE_DATA['FILTER_FIELD_NAME']				=	$this->CI->input->get_post("FILTER_FIELD_NAME");
		$arr_VARIABLE_DATA['FILTER_FIELD_VALUE']				=	$this->CI->input->get_post("FILTER_FIELD_VALUE");

		/// @필수값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @데이터 가져오기

		$arrData              =   null;
		$arrData['sqlWhere']  =   array('tourJp_400_pk' =>  $arr_VARIABLE_DATA['tourJp_400_pk']);

		$arr_SQL_Result	=   null;
		$arr_SQL_Result       =   $this->CI->TourJp_model->gettourJp_RecordList($arrData);


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////@@ 데이터정리

//        $arrKeys              =   array_keys($arr_SQL_Result[0]);
//        for($loopCnt1=0; count($arrKeys)>$loopCnt1; $loopCnt1++ )
//        {
//            $arr_VARIABLE_DATA[ $arrKeys[$loopCnt1] ] =   $arr_SQL_Result[0][ $arrKeys[$loopCnt1] ];
//
//        }//   end for


		$arr_tourJp_400 = $arr_SQL_Result[0];
		$arr_VARIABLE_DATA['tourJp_400_pk'] = $arr_tourJp_400['tourJp_400_pk'] ;
		$arr_VARIABLE_DATA['tourJp_400_addr1'] = $arr_tourJp_400['tourJp_400_addr1'] ;
		$arr_VARIABLE_DATA['tourJp_400_addr2'] = $arr_tourJp_400['tourJp_400_addr2'] ;
		$arr_VARIABLE_DATA['tourJp_400_areacode'] = $arr_tourJp_400['tourJp_400_areacode'] ;
		$arr_VARIABLE_DATA['tourJp_400_cat1'] = $arr_tourJp_400['tourJp_400_cat1'] ;
		$arr_VARIABLE_DATA['tourJp_400_cat2'] = $arr_tourJp_400['tourJp_400_cat2'] ;
		$arr_VARIABLE_DATA['tourJp_400_cat3'] = $arr_tourJp_400['tourJp_400_cat3'] ;
		$arr_VARIABLE_DATA['tourJp_400_contentid'] = $arr_tourJp_400['tourJp_400_contentid'] ;
		$arr_VARIABLE_DATA['tourJp_400_contenttypeid'] = $arr_tourJp_400['tourJp_400_contenttypeid'] ;
		$arr_VARIABLE_DATA['tourJp_400_createdtime'] = $arr_tourJp_400['tourJp_400_createdtime'] ;
		$arr_VARIABLE_DATA['tourJp_400_firstimage'] = $arr_tourJp_400['tourJp_400_firstimage'] ;
		$arr_VARIABLE_DATA['tourJp_400_firstimage2'] = $arr_tourJp_400['tourJp_400_firstimage2'] ;
		$arr_VARIABLE_DATA['tourJp_400_mapx'] = $arr_tourJp_400['tourJp_400_mapx'] ;
		$arr_VARIABLE_DATA['tourJp_400_mapy'] = $arr_tourJp_400['tourJp_400_mapy'] ;
		$arr_VARIABLE_DATA['tourJp_400_mlevel'] = $arr_tourJp_400['tourJp_400_mlevel'] ;
		$arr_VARIABLE_DATA['tourJp_400_modifiedtime'] = $arr_tourJp_400['tourJp_400_modifiedtime'] ;
		$arr_VARIABLE_DATA['tourJp_400_readcount'] = $arr_tourJp_400['tourJp_400_readcount'] ;
		$arr_VARIABLE_DATA['tourJp_400_sigungucode'] = $arr_tourJp_400['tourJp_400_sigungucode'] ;
		$arr_VARIABLE_DATA['tourJp_400_tel'] = $arr_tourJp_400['tourJp_400_tel'] ;
		$arr_VARIABLE_DATA['tourJp_400_title'] = $arr_tourJp_400['tourJp_400_title'] ;
		$arr_VARIABLE_DATA['tourJp_400_zipcode'] = $arr_tourJp_400['tourJp_400_zipcode'] ;
		$arr_VARIABLE_DATA['tourJp_400_moddt'] = $arr_tourJp_400['tourJp_400_moddt'] ;
		$arr_VARIABLE_DATA['tourJp_400_detailCommon_overview'] = $arr_tourJp_400['tourJp_400_detailCommon_overview'] ;



		$arr_VARIABLE_DATA['tour_image'] = "images/avatar.jpg";
		if($arr_VARIABLE_DATA['tourJp_400_firstimage'])
		{
			$arr_VARIABLE_DATA['tour_image'] = $arr_VARIABLE_DATA['tourJp_400_firstimage'];
		}


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 공통정보조회


		/// @ 공통정보조회
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////@@ 데이터정리
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		/// @데이터 가져오기
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @이동 url

		$arr_VARIABLE_DATA['url_go_list']   =   "";
		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_list']   .=   "/tourJp_default/tourJp_list";
		$arr_VARIABLE_DATA['url_go_list']   .=   "?per_page=".$arr_VARIABLE_DATA['per_page'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_NAME=".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_VALUE=".$arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];


		// 네이버 지도
		// 'http://map.naver.com/index.nhn?enc=utf8&level=2&lng='+ position.lng() +'&lat='+ position.lat() +'&pinTitle=야탑중학교&pinType=SITE';
		$arr_VARIABLE_DATA['go_url_naver_map']   =   "";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "http://map.naver.com/index.nhn";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "?enc=utf8&level=1&pinType=SITE";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lng=".$arr_VARIABLE_DATA['tourJp_400_mapx'];
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lat=".$arr_VARIABLE_DATA['tourJp_400_mapy'];
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&pinTitle=".$arr_VARIABLE_DATA['tourJp_400_title'];

		/// @이동 url
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$arr_VARIABLE_DATA['html_tpl_path']		=	'widgets/tourJp/widget_tourJp_view.html';	    //	디자인 파일 경로

		return $this->CI->parser->parse( $arr_VARIABLE_DATA['html_tpl_path'] , $arr_VARIABLE_DATA, true );

	}//	end function





}// end - class

?>















