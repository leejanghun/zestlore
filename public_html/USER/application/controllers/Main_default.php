<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/// @brief 메인 페이지 접속시 기본 접속처리 컨트롤러 클래스
class Main_default extends CI_Controller {

	/// @brief 전송 세그먼트 값 연관배열 저장 변수 선언
	private $arr_segment			=	array();

	/// @brief 기본사용 페이지 레이아웃 템플릿 HTML 경로 저장 변수
	private $cfg_pageLayout 		=	"";

	/// @brief 클래스 내부 사용 전역 변수 선언
	public $arr_class_common   	    =	array();

	/// @brief 로그인 및 권한정보 저장 변수
	public $arr_Auth_info			=	null;

	/// @brief 생성자
	/// - 변수값 할당
	/// - 모델 , 라이브러리, 헬퍼 로딩 처리
	public function __construct()
	{

		parent::__construct();

		/// @brief URL 세그먼테이션 전달값 할당
		$this->arr_segment	=	$this->uri->uri_to_assoc(3);

		/// @brief 클래스 내부 전역 변수값 설정
		$this->arr_class_common['siteURL']	=	base_url(); //base_url은 config파일에 설정되어 있다.


		////////////////////////////////////////////////////////////////////////////
		//	@	DB 접속 & Model 호출
		////////////////////////////////////////////////////////////////////////////

		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$dbconfig_file;


		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);


		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 시작
		////////////////////////////////////////////////////////////////////////////

		$this->cfg_pageLayout		=	'layout_default.html';
		//$this->cfg_pageLayout		=	'layout_main.html'; // 추후에 다른 구조로 사용할경우를 위해 생성

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 끝
		////////////////////////////////////////////////////////////////////////////

	}//	end function





	/// @brief 지정된 실행 함수가 없을 경우 기본실행 함수
	/// - class : Admin_default
	/// - function : index
	public function index()
	{

//		echo "<h1>Welcome To TheBom-S Project : Hello Real Estate</h1>";exit;
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";

		
		$targetUrl  =   $this->arr_class_common['siteURL'];
		//$targetUrl  .=   "index.php/Main_default/default_main_page"; // 메인페이지 이동
		$targetUrl  .=   "index.php/Hospital_default/hospital_list"; // hospital

		$js =   "<script>";
		$js .=  "window.location.href='".$targetUrl."';";
		$js .=  "</script>";
		exit($js);


	}//	end function


	//	@	메인 페이지 출력 처리
	public function default_main_page()
	{
//		debug_var(__CLASS__);
//		debug_var(__FILE__);
//		debug_var(__LINE__);

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_top"]	   =	$this->widget->run(
			'widgets/widget_top'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/main/widget_main'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
			)
		);

		$this->arr_class_common["widget_bottom"]	   =	$this->widget->run(
			'widgets/widget_bottom'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
			)
		);

		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );


	}//	end function


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
