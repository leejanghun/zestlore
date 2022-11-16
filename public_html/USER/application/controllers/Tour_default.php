<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///////////////////////////////////////////////////////////////////////////////
/// @brief 관리자 정보관리 컨트롤러
/// - class : Company
/// - function : enclosing_method
/// @author yym
///////////////////////////////////////////////////////////////////////////////



class Tour_default extends CI_Controller {

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
	/// - class : Company
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

		/// @brief 클래스 내부 전역 변수값 설정
		$this->arr_class_common['siteURL']	=	base_url(); //base_url은 config파일에 설정되어 있다.

		////////////////////////////////////////////////////////////////////////////
		//	@	DB 접속
		////////////////////////////////////////////////////////////////////////////


		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$_SERVER["DOCUMENT_ROOT"];
		$cfg_server_db1_connect_info	.=	$dbconfig_file;


		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);



		// @   관리자 정보 관리 모델 호출
		$this->load->model('Tour_model');

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 시작
		////////////////////////////////////////////////////////////////////////////

		$this->cfg_pageLayout		=	'layout_default.html';
		// $this->cfg_pageLayout		=	'layout_main.html';

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 끝
		////////////////////////////////////////////////////////////////////////////



	}//	end function




	private function default_error_url()
	{
		$targetUrl  =   $this->arr_class_common['siteURL'];
		$targetUrl  .=   "index.php";

		$js =   "<script>";
		$js .=  "window.location.href='".$targetUrl."';";
		$js .=  "</script>";
		exit($js);
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////
	///
	/// @brief 별도의 실행 함수가 정의되지 않았을 경우 기본 실힝 함수
	/// - class : Company
	/// - function : index
	/// @author yym
	///
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function index()
	{
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";

		$targetUrl  =   $this->arr_class_common['siteURL'];
		$targetUrl  .=   "index.php";

		$js =   "<script>";
		$js .=  "window.location.href='".$targetUrl."';";
		$js .=  "</script>";
		exit($js);

	}//	end function




	public function tour_list()
	{
		//debug_var(simple_debug_backtrace());exit;

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_top"]	   =	$this->widget->run(
			'widgets/widget_top'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
			)
		);


		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/tour/widget_tour_list'
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

	}// end - fun




	public function tour_detail()
	{
		// debug_var(simple_debug_backtrace());exit;

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_top"]	   =	$this->widget->run(
			'widgets/widget_top'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/tour/widget_tour_detail'
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

	}// end - fun




	public function tour_detail_dev()
	{
		// debug_var(simple_debug_backtrace());exit;

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_top"]	   =	$this->widget->run(
			'widgets/widget_top'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/tour/widget_tour_detail_dev'
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
