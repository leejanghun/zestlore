<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///////////////////////////////////////////////////////////////////////////////
/// @brief 관리자 정보관리 컨트롤러
/// - class : Administrators
/// - function : enclosing_method
/// @author yym
///////////////////////////////////////////////////////////////////////////////
class Datagokr_api_default extends CI_Controller {

	/// @brief 전송 세그먼트 값 연관배열 저장 변수 선언
	private $arr_segment			=	array();

	/// @brief 기본사용 페이지 레이아웃 템플릿 HTML 경로 저장 변수
	private $cfg_pageLayout 		=	"";

	/// @brief 클래스 내부 사용 전역 변수 선언
	public $arr_class_common   	    =	array();

	/// @brief 로그인 및 권한정보 저장 변수
	public $arr_Auth_info			=	null;


	///////////////////////////////////////////////////////////////////////////////////////////////////
	///
	/// @brief 생성자
	/// - class : Administrators
	/// - function : __construct
	///
	/// - 전달받은 세그먼테이션 1차 처리
	/// - 클래스 내부 전역뱐수값 할당
	/// - DBMS 접속 처리
	///   동적다중 DBMS 접속 및 GIT PUSH 과정에서 DB 접속정보분리를 위하여 database.php정의를 사용하지 않고 처리함
	///
	/// @author Yuk.Young.Min
	///
	///////////////////////////////////////////////////////////////////////////////////////////////////
	public function __construct()
	{
		parent::__construct();

		// - URL 세그먼테이션 전달값 할당
		$this->arr_segment	=	$this->uri->uri_to_assoc(3);

		// - 클래스 내부 전역 변수값 설정
		$this->arr_class_common	=	array(
			"siteURL"						=>	base_url() //base_url은 config파일에 설정되어 있다.
		);


		////////////////////////////////////////////////////////////////////////////
		//	@	DB 접속 & Model 호출
		////////////////////////////////////////////////////////////////////////////

		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$dbconfig_file;


		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);

		// @   관리자 정보 관리 모델 호출
		//$this->load->model('Admin_model');


		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 시작
		////////////////////////////////////////////////////////////////////////////

		$this->cfg_pageLayout		=	'layout_default.html';

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 끝
		////////////////////////////////////////////////////////////////////////////


	}//	end function


	private function get_auth_info()
	{
		// @ 회원 기본정보
		$this->arr_Auth_info                =   json_decode( base64_decode( $this->input->cookie('json_auth_info_admin') ) , true );
		$this->arr_class_common['admin_00_name'] =   $this->arr_Auth_info['admin_00_name'];
	}// end - fun


	// 로그인 체크 - 일반 접근
	private function check_auth_info()
	{
		if( strlen( trim( $this->input->cookie('json_auth_info_admin') ) ) == 0 )
		{

//			//	@	로그인 값 쿠키가 없을 경우 로그인 창 페이지 출력
//			$targetUrl  =   $this->arr_class_common['siteURL'];
//			$targetUrl  .=   "index.php/Admin_login/login_write";
//
//			$js =   "<script>";
//			$js .=  "window.location.href='".$targetUrl."';";
//			$js .=  "</script>";
//			exit($js);

			debug_var("로그인이 필요합니다.");
			exit;
		}//	end if
	}// end - fun


	// 로그인 체크 - ajax 접근
	private function check_auth_info_ajax()
	{
		if( strlen( trim( $this->input->cookie('json_auth_info_admin') ) ) == 0 )
		{
			$rtnString['SQL_Result'] = "FAIL";
			$rtnString['error_type'] = "no_login";
			$rtnString['msg'] = "Please log in";
			exit( json_encode($rtnString) );
		}//	end if
	}// end - fun



	/////////////////////////////////////////////////////////////////////////////////////////////////
	///
	/// @brief 별도의 실행 함수가 정의되지 않았을 경우 기본 실힝 함수
	/// - class : Administrators
	/// - function : index
	/// @author yym
	///
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function index()
	{
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";

		//	@	로그인 값 쿠키가 있을 경우
		$targetUrl  =   $this->arr_class_common['siteURL'];
		$targetUrl  .=   "index.php/Admin_default/admin_list";

		$js =   "<script>";
		$js .=  "window.location.href='".$targetUrl."';";
		$js .=  "</script>";
		exit($js);

	}//	end function



	public function dbproc_hospInfoService1()
	{


		debug_var("실행금지"); exit;// 실행금지
		debug_var("두번 실행금지"); exit;// 두번 실행금지

		//print_r($this->is_cli_request());exit;
//		debug_var($this->is_cli());exit;
//		debug_var($this->is_cli_request());exit;

		// debug_var(simple_debug_backtrace());exit;

//		$this->check_auth_info();
//		$this->get_auth_info();

		$this->load->model('Hospital_model');

		$config_getHospBasisList1 = $this->Config_model->get_config_10_default_code("getHospBasisList1");

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 설정값
		$url = 'http://apis.data.go.kr/B551182/hospInfoService1/getHospBasisList1'; /*URL*/
		$service_key = $config_getHospBasisList1['config_10_value'];

		/// @ api 설정값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 데이터를 한개만 가져와서 카운트를 구한다.


		$api_tot_cnt = 0;// 처리할 데이터 총카운트
		
//		$ch = curl_init();
//		$queryParams = '?' . urlencode('serviceKey') . $service_key; /*Service Key*/
//		$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
//		$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
//		$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1'); /*  한번에 가져오는 갯수 */
////		$queryParams .= '&' . urlencode('sidoCd') . '=' . urlencode('110000'); /**/
////		$queryParams .= '&' . urlencode('sgguCd') . '=' . urlencode('110019'); /**/
////		$queryParams .= '&' . urlencode('emdongNm') . '=' . urlencode('신내동'); /**/
////		$queryParams .= '&' . urlencode('yadmNm') . '=' . urlencode('서울의료원'); /**/
////		$queryParams .= '&' . urlencode('zipCd') . '=' . urlencode('2010'); /**/
////		$queryParams .= '&' . urlencode('clCd') . '=' . urlencode('11'); /**/
////		$queryParams .= '&' . urlencode('dgsbjtCd') . '=' . urlencode('01'); /**/
////		$queryParams .= '&' . urlencode('xPos') . '=' . urlencode('127.09854004628151'); /**/
////		$queryParams .= '&' . urlencode('yPos') . '=' . urlencode('37.6132113197367'); /**/
////		$queryParams .= '&' . urlencode('radius') . '=' . urlencode('3000'); /**/
//
//		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		curl_setopt($ch, CURLOPT_HEADER, FALSE);
//		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//		$response = curl_exec($ch);
//		curl_close($ch);
//
////		$response_object = simplexml_load_string($response);
////		$totalCount = (array)$response_object->body->totalCount;
////		debug_var($response_object->body->totalCount);
//
//		$response_arr = json_decode($response,true);


//		$api_tot_cnt = ($response_arr['response']['body']['totalCount']);

		$api_tot_cnt = 76067; // 데이터 총카운트
		$api_tot_cnt = 1; // 데이터 총카운트

		/////////////////////////////////////////////////////////////////////////////////////
		/// 반복횟수 구하기

		$one_time_cnt = 1000; // 한번에 처리할 데이터수
		$one_time_cnt = 1; // 한번에 처리할 데이터수
		$exe_cnt = (int)($api_tot_cnt/$one_time_cnt)+1; // 반복횟수

		/// 반복횟수 구하기
		/////////////////////////////////////////////////////////////////////////////////////

		//$exe_cnt=1; $one_time_cnt = 1000; // test


		/////////////////////////////////////////////////////////////////////////////////////
		/// 데이터 가져오기

		$insert_i = 0; // 입력 데이터

		for($i=1;$i<=$exe_cnt;$i++) // $i=1
		{


			unset($ch,$queryParams,$response,$response_arr);
			$ch = curl_init();
			$queryParams = '?' . urlencode('serviceKey') . $service_key; /*Service Key*/
			$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
			$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($i); /**/
			$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($one_time_cnt); /*  한번에 가져오는 갯수 */

			curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			$response = curl_exec($ch);
			curl_close($ch);

			$response_arr = json_decode($response,true);


			debug_var($response_arr);exit;

			$item_list = $response_arr['response']['body']['items']['item'];
			$numOfRows = count($response_arr['response']['body']['items']['item']);

			///// @ 데이터 입력
			for($item_i=0;$item_i<$numOfRows;$item_i++)
			{

				unset($check_data);
				$check_data = $this->hospInfoService1_data_check($item_list[$item_i]);

				$arrData['tbl_name']    =   'hospital_100_default';

				$arrData['arr_data']['hosp_100_addr'] = $check_data['addr'];
				$arrData['arr_data']['hosp_100_clCd'] = $check_data['clCd'];
				$arrData['arr_data']['hosp_100_clCdNm'] = $check_data['clCdNm'];
				$arrData['arr_data']['hosp_100_cmdcGdrCnt'] = $check_data['cmdcGdrCnt'];
				$arrData['arr_data']['hosp_100_cmdcIntnCnt'] = $check_data['cmdcIntnCnt'];
				$arrData['arr_data']['hosp_100_cmdcResdntCnt'] = $check_data['cmdcResdntCnt'];
				$arrData['arr_data']['hosp_100_cmdcSdrCnt'] = $check_data['cmdcSdrCnt'];
				$arrData['arr_data']['hosp_100_detyGdrCnt'] = $check_data['detyGdrCnt'];
				$arrData['arr_data']['hosp_100_detyIntnCnt'] = $check_data['detyIntnCnt'];
				$arrData['arr_data']['hosp_100_detyResdntCnt'] = $check_data['detyResdntCnt'];
				$arrData['arr_data']['hosp_100_detySdrCnt'] = $check_data['detySdrCnt'];
				$arrData['arr_data']['hosp_100_drTotCnt'] = $check_data['drTotCnt'];
				$arrData['arr_data']['hosp_100_estbDd'] = $check_data['estbDd'];
				$arrData['arr_data']['hosp_100_mdeptGdrCnt'] = $check_data['mdeptGdrCnt'];
				$arrData['arr_data']['hosp_100_mdeptIntnCnt'] = $check_data['mdeptIntnCnt'];
				$arrData['arr_data']['hosp_100_mdeptResdntCnt'] = $check_data['mdeptResdntCnt'];
				$arrData['arr_data']['hosp_100_mdeptSdrCnt'] = $check_data['mdeptSdrCnt'];
				$arrData['arr_data']['hosp_100_postNo'] = $check_data['postNo'];
				$arrData['arr_data']['hosp_100_sgguCd'] = $check_data['sgguCd'];
				$arrData['arr_data']['hosp_100_sgguCdNm'] = $check_data['sgguCdNm'];
				$arrData['arr_data']['hosp_100_sidoCd'] = $check_data['sidoCd'];
				$arrData['arr_data']['hosp_100_sidoCdNm'] = $check_data['sidoCdNm'];
				$arrData['arr_data']['hosp_100_telno'] = $check_data['telno'];
				$arrData['arr_data']['hosp_100_XPos'] = $check_data['XPos'];
				$arrData['arr_data']['hosp_100_YPos'] = $check_data['YPos'];
				$arrData['arr_data']['hosp_100_yadmNm'] = $check_data['yadmNm'];
				$arrData['arr_data']['hosp_100_ykiho'] = $check_data['ykiho'];

				//$rtnString =  $this->Hospital_model->insert_hospital_100_default( $arrData ); // 데이터 입력

				$insert_i++;

			}// end - for


			debug_var($insert_i);

		}// end - for

		/// 데이터 가져오기
		/////////////////////////////////////////////////////////////////////////////////////



		debug_var("call end");





		/// @ 데이터를 한개만 가져와서 카운트를 구한다.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


	}// end - fun


	private function hospInfoService1_data_check($api_data):array
	{

		$a = array_keys($api_data);

		$check_array = array (
			 'addr',
			 'clCd',
			 'clCdNm',
			 'cmdcGdrCnt',
			 'cmdcIntnCnt',
			 'cmdcResdntCnt',
			 'cmdcSdrCnt',
			 'detyGdrCnt',
			 'detyIntnCnt',
			 'detyResdntCnt',
			 'detySdrCnt',
			 'drTotCnt',
			 'estbDd',
			 'hospUrl',
			 'mdeptGdrCnt',
			 'mdeptIntnCnt',
			 'mdeptResdntCnt',
			 'mdeptSdrCnt',
			 'postNo',
			 'sgguCd',
			 'sgguCdNm',
			 'sidoCd',
			 'sidoCdNm',
			 'telno',
			 'XPos',
			 'YPos',
			 'yadmNm',
			 'ykiho',
		);

		$max_i = count($check_array);

		for($i=0;$i<$max_i;$i++)
		{
			if(isset($api_data[$check_array[$i]]) === true)
			{

			}
			else
			{
				$api_data[$check_array[$i]] = "";
			}
		}

		return $api_data;

	}// end - fun



	private function displayPage( $chk_execParser )
	{
		//	@	페이지 파서 적용여부 확인
		switch($chk_execParser)
		{
			case "execParser_YES":
				//	@	페이지 파서 적용
				$this->parser->parse(
					$this->cfg_pageLayout
					, $this->arr_class_common
					, false
				);
				break;
			case "execParser_NO":
				//	@	페이지 파서 적용 안함
				$this->load->view($this->cfg_pageLayout);
				break;
		}//	end switch
	}//	end function


}//	end class



?>
