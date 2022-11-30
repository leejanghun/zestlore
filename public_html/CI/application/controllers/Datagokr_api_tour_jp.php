<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///////////////////////////////////////////////////////////////////////////////
/// @brief 관리자 정보관리 컨트롤러
/// - class : Administrators
/// - function : enclosing_method
/// @author yym
///////////////////////////////////////////////////////////////////////////////
class Datagokr_api_tour_jp extends CI_Controller {

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

		echo 2;exit;
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



	public function dbproc_tourJp()
	{

		// debug_var(simple_debug_backtrace());exit;

		debug_var("실행금지"); exit;// 실행금지
		debug_var("두번 실행금지"); exit;// 두번 실행금지

//		print_r($this->is_cli_request());exit;
//		debug_var($this->is_cli());exit;
//		debug_var($this->is_cli_request());exit;

		$this->load->model('TourJp_model');


		$config_tour = $this->Config_model->get_config_10_default_code("tn_pubr_public_trrsrt_api");

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 설정값

		$url = 'https://apis.data.go.kr/B551011/JpnService/areaBasedList'; /*URL*/
		$service_key = $config_tour['config_10_value'];
		/// @ api 설정값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


//		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//		/// @ 입력할 데이터 카운트 구하기
//
//		$ch = curl_init();
//		$queryParams = '?' . urlencode('serviceKey') . '=' . urlencode($service_key); /*Service Key*/
//		$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
//		$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
//		$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1'); /*  한번에 가져오는 갯수 */
//		$queryParams .= '&' . urlencode('MobileOS') . '=' . urlencode('ETC'); /*  한번에 가져오는 갯수 */
//		$queryParams .= '&' . urlencode('MobileApp') . '=' . urlencode('AppTest'); /*  한번에 가져오는 갯수 */
//		$queryParams .= '&' . urlencode('listYN') . '=' . urlencode('Y'); /*  한번에 가져오는 갯수 */
//		$queryParams .= '&' . urlencode('arrange') . '=' . urlencode('C'); /*  한번에 가져오는 갯수 */
//
//		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		curl_setopt($ch, CURLOPT_HEADER, FALSE);
//		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https 호출일때
//		$response = curl_exec($ch);
//		curl_close($ch);
//
//		debug_var($response);
//
//		$response_arr = json_decode($response,true);
//
//		debug_var($response_arr);
//
//		// totalCount - 41980
//		exit;
//		exit;
//		exit;
//
//
//		/// @ 입력할 데이터 카운트 구하기
//		//////////////////////////////////////////////////////////////////////////////////////////////////////////////



		$api_tot_cnt = 0;// 처리할 데이터 총카운트
		$api_tot_cnt = 6497; // 데이터 총카운트
		debug_var("처리할 데이터 수 : ". $api_tot_cnt);
		/////////////////////////////////////////////////////////////////////////////////////
		/// 반복횟수 구하기

		$one_time_cnt = 1000; // 한번에 처리할 데이터수
		$exe_cnt = (int)($api_tot_cnt/$one_time_cnt)+1; // 반복횟수

//		$one_time_cnt = 1; // 한번에 처리할 데이터수 test
//		$exe_cnt = 1; // 반복횟수

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
			$queryParams = '?' . urlencode('serviceKey')  . '=' . urlencode($service_key); /*Service Key*/
			$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
			$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($i); /**/
			$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode($one_time_cnt); /*  한번에 가져오는 갯수 */
			$queryParams .= '&' . urlencode('MobileOS') . '=' . urlencode('ETC'); /*  한번에 가져오는 갯수 */
			$queryParams .= '&' . urlencode('MobileApp') . '=' . urlencode('AppTest'); /*  한번에 가져오는 갯수 */
			$queryParams .= '&' . urlencode('listYN') . '=' . urlencode('Y'); /*  한번에 가져오는 갯수 */
			$queryParams .= '&' . urlencode('arrange') . '=' . urlencode('C'); /*  한번에 가져오는 갯수 */


			curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https 호출일때
			$response = curl_exec($ch);
			curl_close($ch);

			$response_arr = json_decode($response,true);


			$item_list = $response_arr['response']['body']['items']['item'];
			$numOfRows = count($response_arr['response']['body']['items']['item']);

			///// @ 데이터 입력
			for($item_i=0;$item_i<$numOfRows;$item_i++)
			{

				unset($check_data);
				$check_data = $this->field_data_check($item_list[$item_i]);

				$arrData['tbl_name']    =   'tourJp_400_default';


				// $arrData['arr_data']['tourJp_400_pk'] = $check_data['tourJp_400_pk'];
				$arrData['arr_data']['tourJp_400_addr1'] = $check_data['addr1'];
				$arrData['arr_data']['tourJp_400_addr2'] = $check_data['addr2'];
				$arrData['arr_data']['tourJp_400_areacode'] = $check_data['areacode'];
				$arrData['arr_data']['tourJp_400_cat1'] = $check_data['cat1'];
				$arrData['arr_data']['tourJp_400_cat2'] = $check_data['cat2'];
				$arrData['arr_data']['tourJp_400_cat3'] = $check_data['cat3'];
				$arrData['arr_data']['tourJp_400_contentid'] = $check_data['contentid'];
				$arrData['arr_data']['tourJp_400_contenttypeid'] = $check_data['contenttypeid'];
				$arrData['arr_data']['tourJp_400_createdtime'] = $check_data['createdtime'];
				$arrData['arr_data']['tourJp_400_firstimage'] = $check_data['firstimage'];
				$arrData['arr_data']['tourJp_400_firstimage2'] = $check_data['firstimage2'];
				$arrData['arr_data']['tourJp_400_mapx'] = $check_data['mapx'];
				$arrData['arr_data']['tourJp_400_mapy'] = $check_data['mapy'];
				$arrData['arr_data']['tourJp_400_mlevel'] = $check_data['mlevel'];
				$arrData['arr_data']['tourJp_400_modifiedtime'] = $check_data['modifiedtime'];
				$arrData['arr_data']['tourJp_400_readcount'] = $check_data['readcount'];
				$arrData['arr_data']['tourJp_400_sigungucode'] = $check_data['sigungucode'];
				$arrData['arr_data']['tourJp_400_tel'] = $check_data['tel'];
				$arrData['arr_data']['tourJp_400_title'] = $check_data['title'];
				$arrData['arr_data']['tourJp_400_zipcode'] = $check_data['zipcode'];
				$arrData['arr_data']['tourJp_400_moddt'] =  date("Y-m-d H:i:s");


//				$rtnString =  $this->TourJp_model->insert_tourJp_400_default( $arrData ); // 데이터 입력

				$insert_i++;

			}// end - for


			debug_var($insert_i);

		}// end - for

		/// 데이터 가져오기
		/////////////////////////////////////////////////////////////////////////////////////



		debug_var("call end");





	}// end - fun





	private function field_data_check($api_data):array
	{

		$a = array_keys($api_data);

		$check_array = array (
			'addr1'
		,'addr2'
		,'areacode'
		,'cat1'
		,'cat2'
		,'cat3'
		,'contentid'
		,'contenttypeid'
		,'createdtime'
		,'firstimage'
		,'firstimage2'
		,'mapx'
		,'mapy'
		,'mlevel'
		,'modifiedtime'
		,'readcount'
		,'sigungucode'
		,'tel'
		,'title'
		,'zipcode'
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
