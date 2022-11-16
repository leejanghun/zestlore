<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_tour_detail extends Widget {


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

		$arr_VARIABLE_DATA['tour_200_pk']				=	$this->CI->input->get_post("tour_200_pk");
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
		$arrData['sqlWhere']  =   array('tour_200_pk' =>  $arr_VARIABLE_DATA['tour_200_pk']);

		$arr_SQL_Result	=   null;
		$arr_SQL_Result       =   $this->CI->Tour_model->getTour_RecordList($arrData);


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////@@ 데이터정리

//        $arrKeys              =   array_keys($arr_SQL_Result[0]);
//        for($loopCnt1=0; count($arrKeys)>$loopCnt1; $loopCnt1++ )
//        {
//            $arr_VARIABLE_DATA[ $arrKeys[$loopCnt1] ] =   $arr_SQL_Result[0][ $arrKeys[$loopCnt1] ];
//
//        }//   end for


		$arr_tour_200 = $arr_SQL_Result[0];
		$arr_VARIABLE_DATA['tour_200_pk'] = $arr_tour_200['tour_200_pk'] ;
		$arr_VARIABLE_DATA['tour_200_addr1'] = $arr_tour_200['tour_200_addr1'] ;
		$arr_VARIABLE_DATA['tour_200_addr2'] = $arr_tour_200['tour_200_addr2'] ;
		$arr_VARIABLE_DATA['tour_200_areacode'] = $arr_tour_200['tour_200_areacode'] ;
		$arr_VARIABLE_DATA['tour_200_booktour'] = $arr_tour_200['tour_200_booktour'] ;
		$arr_VARIABLE_DATA['tour_200_cat1'] = $arr_tour_200['tour_200_cat1'] ;
		$arr_VARIABLE_DATA['tour_200_cat2'] = $arr_tour_200['tour_200_cat2'] ;
		$arr_VARIABLE_DATA['tour_200_cat3'] = $arr_tour_200['tour_200_cat3'] ;
		$arr_VARIABLE_DATA['tour_200_contentid'] = $arr_tour_200['tour_200_contentid'] ;
		$arr_VARIABLE_DATA['tour_200_contenttypeid'] = $arr_tour_200['tour_200_contenttypeid'] ;
		$arr_VARIABLE_DATA['tour_200_createdtime'] = $arr_tour_200['tour_200_createdtime'] ;
		$arr_VARIABLE_DATA['tour_200_firstimage'] = $arr_tour_200['tour_200_firstimage'] ;
		$arr_VARIABLE_DATA['tour_200_firstimage2'] = $arr_tour_200['tour_200_firstimage2'] ;
		$arr_VARIABLE_DATA['tour_200_mapx'] = $arr_tour_200['tour_200_mapx'] ;
		$arr_VARIABLE_DATA['tour_200_mapy'] = $arr_tour_200['tour_200_mapy'] ;
		$arr_VARIABLE_DATA['tour_200_mlevel'] = $arr_tour_200['tour_200_mlevel'] ;
		$arr_VARIABLE_DATA['tour_200_modifiedtime'] = $arr_tour_200['tour_200_modifiedtime'] ;
		$arr_VARIABLE_DATA['tour_200_readcount'] = $arr_tour_200['tour_200_readcount'] ;
		$arr_VARIABLE_DATA['tour_200_sigungucode'] = $arr_tour_200['tour_200_sigungucode'] ;
		$arr_VARIABLE_DATA['tour_200_tel'] = $arr_tour_200['tour_200_tel'] ;
		$arr_VARIABLE_DATA['tour_200_title'] = $arr_tour_200['tour_200_title'] ;
		$arr_VARIABLE_DATA['tour_200_zipcode'] = $arr_tour_200['tour_200_zipcode'] ;
		$arr_VARIABLE_DATA['tour_200_moddt'] = $arr_tour_200['tour_200_moddt'] ;
		$arr_VARIABLE_DATA['tour_200_detailCommon_overview'] = $arr_tour_200['tour_200_detailCommon_overview'] ;



		$arr_VARIABLE_DATA['tour_image'] = "images/avatar.jpg";
		if($arr_VARIABLE_DATA['tour_200_firstimage'])
		{
			$arr_VARIABLE_DATA['tour_image'] = $arr_VARIABLE_DATA['tour_200_firstimage'];
		}


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 공통정보조회

		if(!$arr_VARIABLE_DATA['tour_200_detailCommon_overview'])
		{
			$arr_VARIABLE_DATA['tour_200_detailCommon_overview'] = $this->getDetailCommon($arr_tour_200);/// api 호출
		}

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
		$arr_VARIABLE_DATA['url_go_list']   .=   "/tour_default/tour_list";
		$arr_VARIABLE_DATA['url_go_list']   .=   "?per_page=".$arr_VARIABLE_DATA['per_page'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_NAME=".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_VALUE=".$arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];


		// 네이버 지도
		// 'http://map.naver.com/index.nhn?enc=utf8&level=2&lng='+ position.lng() +'&lat='+ position.lat() +'&pinTitle=야탑중학교&pinType=SITE';
		$arr_VARIABLE_DATA['go_url_naver_map']   =   "";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "http://map.naver.com/index.nhn";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "?enc=utf8&level=1&pinType=SITE";
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lng=".$arr_VARIABLE_DATA['tour_200_mapx'];
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lat=".$arr_VARIABLE_DATA['tour_200_mapy'];
		$arr_VARIABLE_DATA['go_url_naver_map']   .=   "&pinTitle=".$arr_VARIABLE_DATA['tour_200_title'];

		/// @이동 url
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$arr_VARIABLE_DATA['html_tpl_path']		=	'widgets/tour/widget_tour_view.html';	    //	디자인 파일 경로

		return $this->CI->parser->parse( $arr_VARIABLE_DATA['html_tpl_path'] , $arr_VARIABLE_DATA, true );

	}//	end function





	private function getDetailCommon($arr_tour_200)
	{

		$exe_datetime =  date("Y-m-d H:i:s");

		$rtnString = 0;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 설정값
		$config_getEqpInfo = $this->CI->Config_model->get_config_10_default_code("tn_pubr_public_trrsrt_api");
		$service_key = $config_getEqpInfo['config_10_value'];
		/// @ api 설정값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 호출
		$url = 'https://apis.data.go.kr/B551011/KorService/detailCommon'; //  공통정보

		$ch = curl_init();
		$queryParams = '?' . urlencode('serviceKey')  . '=' . urlencode($service_key); /*Service Key*/
		$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
		$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode(1); /**/
		$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode(1); /*  한번에 가져오는 갯수 */
		$queryParams .= '&' . urlencode('MobileOS') . '=' . urlencode('ETC'); /*  한번에 가져오는 갯수 */
		$queryParams .= '&' . urlencode('MobileApp') . '=' . urlencode('AppTest'); /*  한번에 가져오는 갯수 */

		$queryParams .= '&' . urlencode('defaultYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('firstImageYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('areacodeYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('catcodeYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('addrinfoYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('mapinfoYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('overviewYN') . '=' . urlencode('Y');
		$queryParams .= '&' . urlencode('contentId') . '=' . urlencode($arr_tour_200['tour_200_contentid']);
		$queryParams .= '&' . urlencode('contentTypeId') . '=' . urlencode($arr_tour_200['tour_200_contenttypeid']);


		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https 호출일때
		$response = curl_exec($ch);
		curl_close($ch);
		$response_arr = json_decode($response,true);
		//debug_var($response);
		$response_arr = json_decode($response,true);
		//debug_var($response_arr['response']['body']['items']['item'][0]['overview']);

		$arrData['tbl_name1']    =   'tour_200_default';

		$arrData['arr_data1']['tour_200_pk'] = $arr_tour_200['tour_200_pk'];
		$arrData['arr_data1']['tour_200_detailCommon_overview'] = $response_arr['response']['body']['items']['item'][0]['overview'];

		$this->CI->Tour_model->update_tour_200_default( $arrData ); // 데이터 입력


		/// @ api 호출
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////

		return $response_arr['response']['body']['items']['item'][0]['overview'];

	}// end - fun



}// end - class

?>















