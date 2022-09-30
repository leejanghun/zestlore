<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/// @brief 관리자 페이지 접속시 기본 접속처리 컨트롤러 클래스
class Admin_login extends CI_Controller {

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
		//	@	DB 접속
		////////////////////////////////////////////////////////////////////////////


		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$_SERVER["DOCUMENT_ROOT"];
		$cfg_server_db1_connect_info	.=	$dbconfig_file;


		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 시작
		////////////////////////////////////////////////////////////////////////////

		$this->cfg_pageLayout		=	'layout_default.html';

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 끝
		////////////////////////////////////////////////////////////////////////////

	}//	end function





	/// @brief 지정된 실행 함수가 없을 경우 기본실행 함수
	/// - class : Admin_default
	/// - function : index
	public function index()
	{
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";



		//	@	로그인 쿠키 존재 여부 검사
		if( strlen( trim( $this->input->cookie('json_auth_info_admin') ) ) == 0 )
		{
			//	@	로그인 값 쿠키가 없을 경우 로그인 창 페이지 출력
			$targetUrl  =   $this->arr_class_common['siteURL'];
			$targetUrl  .=   "index.php/Admin_login/login_write";

			$js =   "<script>";
			$js .=  "window.location.href='".$targetUrl."';";
			$js .=  "</script>";
			exit($js);

		}
		else
		{
			//	@	로그인 값 쿠키가 있을 경우
			$targetUrl  =   $this->arr_class_common['siteURL'];
			//  $targetUrl  .=   "index.php/Admin_login/default_main_page";
			//$targetUrl  .=   "index.php/Board_default/record_list/bbs_flag/notice";
			$targetUrl  .=   "index.php/Admin_default/admin_list";


			$js =   "<script>";
			$js .=  "window.location.href='".$targetUrl."';";
			$js .=  "</script>";
			exit($js);

		}//	end if

	}//	end function


	//	@	관리자 메인 페이지 출력 처리
	public function default_main_page()
	{
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";




		/*
		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
				,'function'			=>	__FUNCTION__
			)
			);

		/*
		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_globalTop"]	=	$this->widget->run( 'widget_globalTop', array());

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widget_dashBoard'
			, array(
				'controller'	 	=>	$this->uri->segment(1)
				,'function'			=>	$this->uri->segment(2)
				,'sendData'			=>	$this->arr_segment
			)
			);

		*/
		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );


	}//	end function


	/// @brief 로그인 정보 입력페이지 출력 처리
	/// - class : Admin_default
	/// - function : login_write
	/// @author yym
	public function login_write()
	{
//         echo "controllers name : ".get_class($this)."</br>";
//         echo "function name : ".__FUNCTION__."</br >";

		//	@	페이지 레이아웃
		$this->cfg_pageLayout		=	'layout_login.html';

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/login/widget_loginForm'
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


	/// @brief 로그인 처리 수행
	/// - class : Admin_default
	/// - function : login_proc
	public function login_proc()
	{
		//debug_var(simple_debug_backtrace());exit;
		// debug_var($_POST);exit;



		$arrData    =   null;
		$rtnString  =   null;
		$rtnString['SQL_Result'] = "FAIL";

		if(1) {

			/////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////
			// @ 유효성 검사

			$rtnString['error_type'] = "validation";


			if (strlen(trim($this->input->get_post('werite_id'))) < 1) {
				$rtnString['error_focus'] = "werite_id";
				$rtnString['msg'] = "[ID] Please enter a value";
				exit(json_encode($rtnString));
			}

			if (
				strlen(trim($this->input->get_post('werite_id'))) < 4
				|| strlen(trim($this->input->get_post('werite_id'))) > 100
			) {
				$rtnString['error_focus'] = "werite_id";
				$rtnString['msg'] = "[ID] 4 characters or more and 100 characters or less";
				exit(json_encode($rtnString));
			}

			if (strlen(trim($this->input->get_post('werite_pw'))) < 1) {
				$rtnString['error_focus'] = "werite_pw";
				$rtnString['msg'] = "[password] Please enter a value";
				exit(json_encode($rtnString));
			}

			if (
				strlen(trim($this->input->get_post('werite_pw'))) < 4
				|| strlen(trim($this->input->get_post('werite_pw'))) > 20
			) {
				$rtnString['error_focus'] = "werite_pw";
				$rtnString['msg'] = "[password] 4 characters or more and 20 characters or less";
				exit(json_encode($rtnString));
			}


			// @ 유효성 검사
			/////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////
		}


		$werite_id     =   $this->input->post( 'werite_id' );
		$werite_pw     =   $this->input->post( 'werite_pw' );


		// @   관리자 정보 관리 모델 호출
		$this->load->model('Admin_model');


		$arrData              =   null;
		$arrData['sqlWhere']  =   array('admin_00_id' =>  $werite_id);

		$arr_SQL_Result       =   null;
		$arr_SQL_Result       =   $this->Admin_model->getAdmin_RecordList($arrData);

		//debug_var($arr_SQL_Result);exit;

		if( count( $arr_SQL_Result ) < 1  )
		{
			$rtnString['error_type'] = "validation";
			$rtnString['error_focus'] = "werite_id";
			$rtnString['msg'] = "아이디가 틀렸습니다.";
			exit(json_encode($rtnString));
		}
		else if( count( $arr_SQL_Result ) > 1 )
		{
			$rtnString['error_type'] = "validation";
			$rtnString['error_focus'] = "werite_id";
			$rtnString['msg'] = "중복 아이디 입니다.";
			exit(json_encode($rtnString));
		}

		if( $werite_id  != $arr_SQL_Result[0]['admin_00_id'] )
		{
			$rtnString['error_type'] = "validation";
			$rtnString['error_focus'] = "werite_id";
			$rtnString['msg'] = "비정상 접근.";
			exit(json_encode($rtnString));
		}

		
		if( hash("sha256", $werite_pw )  != $arr_SQL_Result[0]['admin_00_pw'] )
		{
			$rtnString['error_type'] = "validation";
			$rtnString['error_focus'] = "werite_pw";
			$rtnString['msg'] = "비밀번호 틀렸습니다.";
			exit(json_encode($rtnString));
		}


		if(  $werite_id  == $arr_SQL_Result[0]['admin_00_id']  && hash("sha256", $werite_pw )  == $arr_SQL_Result[0]['admin_00_pw'] )
		{

			$json_arr = array(
				'admin_00_pk'		=>	$arr_SQL_Result[0]['admin_00_pk']
				,'admin_00_id'		=>	$arr_SQL_Result[0]['admin_00_id']
				,'admin_00_name'	=>	$arr_SQL_Result[0]['admin_00_name']
				,'admin_00_email'	=>	$arr_SQL_Result[0]['admin_00_email']
			);

			$cookie = array(
				'name'		=> 'json_auth_info_admin'
			,'value'  	=> base64_encode( json_encode($json_arr) ) //base64_encode는 데이터를 암호화하여 안전하게 전송하도록 한다.
			,'expire'	=> '0'
			,'path'   	=> '/'
				// ,'domain' => '.some-domain.com'
				// ,'prefix' => 'myprefix_'
				// ,'secure' => TRUE
			);

			//echo "<pre>";var_export( $cookie );echo "</pre>";

			$this->input->set_cookie( $cookie );

			$rtnString['SQL_Result'] = "SUCCESS";
			exit(json_encode($rtnString));
		}
		else
		{
			$rtnString['error_type'] = "validation";
			$rtnString['error_focus'] = "werite_id";
			$rtnString['msg'] = "알수 없는 에러 개발자에게 문의 하세요.";
			exit(json_encode($rtnString));
		}


	}//	end function


	public function logout_proc()
	{
		delete_cookie('json_auth_info_admin');

		$goUrl =   $this->arr_class_common['siteURL'];
		// echo $goUrl."<BR>";
		$js   =   "<script>";
		$js   .=   "window.location.href='".$goUrl."';";
		$js   .=   "</script>";
		exit($js);

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
