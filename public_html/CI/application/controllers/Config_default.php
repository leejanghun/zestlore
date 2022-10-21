<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///////////////////////////////////////////////////////////////////////////////
/// @brief 관리자 정보관리 컨트롤러
/// - class : Company
/// - function : enclosing_method
/// @author yym
///////////////////////////////////////////////////////////////////////////////



class Config_default extends CI_Controller
{

	/// @brief 전송 세그먼트 값 연관배열 저장 변수 선언
	private $arr_segment = array();

	/// @brief 기본사용 페이지 레이아웃 템플릿 HTML 경로 저장 변수
	private $cfg_pageLayout = "";

	/// @brief 클래스 내부 사용 전역 변수 선언
	public $arr_class_common = array();

	/// @brief 로그인 및 권한정보 저장 변수
	public $arr_Auth_info = null;


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
		$this->arr_segment = $this->uri->uri_to_assoc(3);

		/// @brief 클래스 내부 전역 변수값 설정
		$this->arr_class_common['siteURL'] = base_url(); //base_url은 config파일에 설정되어 있다.

		////////////////////////////////////////////////////////////////////////////
		//	@	DB 접속
		////////////////////////////////////////////////////////////////////////////

		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$dbconfig_file;

		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);


		////////////////////////////////////////////////////////////////////////////
		//	@	Model 호출
		////////////////////////////////////////////////////////////////////////////
		$this->load->model('Config_model');



		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 레이아웃 정의 시작
		////////////////////////////////////////////////////////////////////////////

		$this->cfg_pageLayout = 'layout_default.html';

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
			//	@	로그인 값 쿠키가 없을 경우 로그인 창 페이지 출력
			$targetUrl  =   $this->arr_class_common['siteURL'];
			$targetUrl  .=   "index.php/Admin_login/login_write";

			$js =   "<script>";
			$js .=  "window.location.href='".$targetUrl."';";
			$js .=  "</script>";
			exit($js);
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



	private function default_error_url()
	{
		$targetUrl = $this->arr_class_common['siteURL'];
		$targetUrl .= "index.php/Config_default/main";

		$js = "<script>";
		$js .= "window.location.href='" . $targetUrl . "';";
		$js .= "</script>";
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

		//	@	로그인 값 쿠키가 있을 경우
		$targetUrl = $this->arr_class_common['siteURL'];
		$targetUrl .= "index.php/Config_default/main";

		$js = "<script>";
		$js .= "window.location.href='" . $targetUrl . "';";
		$js .= "</script>";
		exit($js);

	}//	end function


	//=============================================================================================================
	//=============================================================================================================
	// config setting
	// config setting


	public function config_setting_list()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//  $this->arr_class_common["widget_globalTop"]	=	$this->widget->run( 'admin/widgets/widget_globalTop', array());

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"] = $this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller' => get_class($this)
			, 'function' => __FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"] = $this->widget->run(
			'widgets/config/widget_config_setting_list'
			, array(
				'controller' => get_class($this)
			, 'function' => __FUNCTION__
			, 'sendData' => $this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser = 'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage($chk_execParser);

	}//	end function



	public function config_setting_writeForm()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"] = $this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller' => get_class($this)
			, 'function' => __FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"] = $this->widget->run(
			'widgets/config/widget_config_setting_writeForm'
			, array(
				'controller' => get_class($this)
			, 'function' => __FUNCTION__
			, 'sendData' => $this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser = 'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage($chk_execParser);
	}// end - fun



	public function dbProc_config_setting_insert()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info_ajax();
		$this->get_auth_info();

		$arrData    =   null;
		$rtnString  =   null;

		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		$rtnString['SQL_Result'] = "FAIL";
		$rtnString['error_type'] = "validation";

		/////////////////////////////////////////////////////////////////////////////////////////
		////// config_10_default


		if(strlen(trim($this->input->get_post('config_10_code')))<1)
		{

			$rtnString['error_focus'] = "config_10_code";
			$rtnString['msg'] = "[code] Please enter a value";
			exit( json_encode($rtnString) );
		}

		$config_100 = $this->Config_model->get_config_10_code($this->input->get_post('config_10_code'));


		if(isset($config_100[0]['config_10_pk'])===true )
		{
			$rtnString['error_focus'] = "config_10_code";
			$rtnString['msg'] = "code DUPLICATE";
			exit( json_encode($rtnString) );
		}

		if(strlen(trim($this->input->get_post('config_10_input')))<1)
		{
			$rtnString['error_focus'] = "config_10_input";
			$rtnString['msg'] = "[input type] Please enter a value";
			exit( json_encode($rtnString) );
		}



		if($this->input->get_post('config_10_input')=="radio")
		{
			if(strlen(trim($this->input->get_post('config_10_opt')))<1)
			{
				$rtnString['error_focus'] = "config_10_opt";
				$rtnString['msg'] = "[option] Please enter a value";
				exit( json_encode($rtnString) );
			}
		}


		if(strlen(trim($this->input->get_post('config_10_desc')))<1)
		{
			$rtnString['error_focus'] = "config_10_desc";
			$rtnString['msg'] = "[desc] Please enter a value";
			exit( json_encode($rtnString) );
		}


		////// config_10_default
		/////////////////////////////////////////////////////////////////////////////////////////


		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////




		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 데이터 입력

		/////////////////////////////////////////////////////////////////////////////////////////
		//////// 회원 기본데이터
		$arrData['tbl_name1']    =   'config_10_default';

		//$arrData['arr_data1']['config_10_pk'] = $this->input->get_post("config_10_pk");
		$arrData['arr_data1']['config_10_code'] = $this->input->get_post("config_10_code");
		$arrData['arr_data1']['config_10_input'] = $this->input->get_post("config_10_input");
		$arrData['arr_data1']['config_10_opt'] = $this->input->get_post("config_10_opt");
		$arrData['arr_data1']['config_10_value'] = "";
		$arrData['arr_data1']['config_10_desc'] = $this->input->get_post("config_10_desc");
		$arrData['arr_data1']['config_10_title'] = $this->input->get_post("config_10_title");

		//  echo "<pre>";	var_export( $arrData );		echo "</pre>";

		//////// 회원 기본데이터
		/////////////////////////////////////////////////////////////////////////////////////////

		$rtnString =  $this->Config_model->insert_config_10_default( $arrData ); // insert exe

		// @ 데이터 입력
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////

		exit( json_encode($rtnString) );

	}// end - fun



	public function config_setting_detail()
	{

		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/config/widget_config_setting_detail'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );

	}




	public function config_setting_modifyForm()
	{
		//debug_var(simple_debug_backtrace());exit;


		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/config/widget_config_setting_modifyForm'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );

	}



	public function dbProc_config_setting_update()
	{
		//debug_var(simple_debug_backtrace());exit;
		$this->check_auth_info_ajax();
		$this->get_auth_info();

		$arrData    =   null;
		$rtnString  =   null;

		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		$rtnString['SQL_Result'] = "FAIL";
		$rtnString['error_type'] = "validation";

		/////////////////////////////////////////////////////////////////////////////////////////
		////// config_10_default

		if(strlen(trim($this->input->get_post('config_10_input')))<1)
		{
			$rtnString['error_focus'] = "config_10_input";
			$rtnString['msg'] = "[input type] Please enter a value";
			exit( json_encode($rtnString) );
		}



		if($this->input->get_post('config_10_input')=="radio")
		{
			if(strlen(trim($this->input->get_post('config_10_opt')))<1)
			{
				$rtnString['error_focus'] = "config_10_opt";
				$rtnString['msg'] = "[option] Please enter a value";
				exit( json_encode($rtnString) );
			}
		}


		if(strlen(trim($this->input->get_post('config_10_desc')))<1)
		{
			$rtnString['error_focus'] = "config_10_desc";
			$rtnString['msg'] = "[desc] Please enter a value";
			exit( json_encode($rtnString) );
		}


		////// config_10_default
		/////////////////////////////////////////////////////////////////////////////////////////


		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////



		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 데이터 입력

		/////////////////////////////////////////////////////////////////////////////////////////
		//////// 회원 기본데이터
		$arrData['tbl_name1']    =   'config_10_default';

		$arrData['arr_data1']['config_10_pk'] = $this->input->get_post("config_10_pk");
		//$arrData['arr_data1']['config_10_code'] = $this->input->get_post("config_10_code");
		$arrData['arr_data1']['config_10_input'] = $this->input->get_post("config_10_input");
		$arrData['arr_data1']['config_10_opt'] = $this->input->get_post("config_10_opt");
		//$arrData['arr_data1']['config_10_value'] = "";
		$arrData['arr_data1']['config_10_desc'] = $this->input->get_post("config_10_desc");
		$arrData['arr_data1']['config_10_title'] = $this->input->get_post("config_10_title");

		//  echo "<pre>";	var_export( $arrData );		echo "</pre>";

		//////// 회원 기본데이터
		/////////////////////////////////////////////////////////////////////////////////////////

		$rtnString =  $this->Config_model->update_config_10_default( $arrData ); // insert exe

		// @ 데이터 입력
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////

		exit( json_encode($rtnString) );

	}// end - fun



	public function dbProc_config_setting_delete()
	{
		//debug_var(simple_debug_backtrace());exit;
		$this->check_auth_info_ajax();
		$this->get_auth_info();

		$getValue = null;
		$getValue = $this->arr_segment;

		//debug_var($getValue);exit;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ 데이터 삭제
		$arrData    =   null;
		$rtnString['SQL_Result']  =   "FAIL";

		$arrData['tbl_name1']    =   'config_10_default';
		$arrData['arr_data1']['config_10_pk']	= $this->input->get_post('config_10_pk');

		$rtnString = $this->Config_model ->delete_config_10_default( $arrData );
		// @ 데이터 삭제
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		exit( json_encode($rtnString) );
	}// end - fun



	public function dbProc_order_change()
	{


		//debug_var(simple_debug_backtrace());exit;
		$arrData    =   null;
		$rtnString  =   null;

		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		$rtnString['SQL_Result'] = "FAIL";
		$rtnString['error_type'] = "validation";

		if(count($this->input->get_post('arr_config_10_orderby'))<1)
		{
			$rtnString['error_focus'] = "no_focus";
			$rtnString['msg'] = "a wrong approach";
			exit( json_encode($rtnString) );
		}

		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////


		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 데이터 처리

		$cnt_config_10_orderby = count($this->input->get_post("arr_config_10_orderby"));
		$arr_config_10_orderby = $this->input->get_post("arr_config_10_orderby");

		$start_order_no = 1;

		for($loop=0;$loop<$cnt_config_10_orderby;$loop++)
		{
			$arrData['tbl_name1']    =   'config_10_default';

			$arrData['arr_data1']['config_10_pk'] = $arr_config_10_orderby[$loop];
			$arrData['arr_data1']['config_10_orderby'] = $start_order_no;

			$rtnString =  $this->Config_model->update_config_10_default( $arrData ); // update

			$start_order_no++;
		}


		// @ 데이터 처리
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////

		exit( json_encode($rtnString) );

	}




	// config setting
	// config setting
	//=============================================================================================================
	//=============================================================================================================







	//=============================================================================================================
	//=============================================================================================================
	// config
	// config


	public function config_list()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//  $this->arr_class_common["widget_globalTop"]	=	$this->widget->run( 'admin/widgets/widget_globalTop', array());

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/config/widget_config_list'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );

	}//	end function




	public function config_detail()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/config/widget_config_detail'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );

	}




	public function config_modifyForm()
	{
		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info();
		$this->get_auth_info();

		//	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
		$this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
			'widgets/widget_leftMenu'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			)
		);

		$this->arr_class_common["widget_contents"]	=	$this->widget->run(
			'widgets/config/widget_config_modifyForm'
			, array(
				'controller'	 	=>	get_class ( $this )
			,'function'			=>	__FUNCTION__
			,'sendData'			=>	$this->arr_segment
				//,'arr_company_10_default'			=>	$this->arr_company_10_default // 업체정보
			)
		);


		//	@	페이지 출력 여부 정의
		$chk_execParser				=	'execParser_YES';

		//	@	페이지 출력 실행
		$this->displayPage( $chk_execParser );

	}



	public function dbProc_config_update()
	{

		//debug_var(simple_debug_backtrace());exit;
		$this->check_auth_info_ajax();
		$this->get_auth_info();


		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		$rtnString['SQL_Result'] = "FAIL";
		$rtnString['error_type'] = "validation";


		$number_pattern =  '/^[0-9]+$/'; // 숫자만 있는 패턴
		$number_decimal_pattern =  '/^\d+(\.\d{0,1})?$/'; // 숫자 , 소수점 1자리 허용 1 , 1.5 , 2 , 2.5 ....
		$number_decimal_pattern2 =  '/^\d+(\.\d{0,2})?$/'; // 숫자 , 소수점 2자리 허용


		if(strlen(trim($this->input->get_post('config_10_pk')))<1)
		{
			$rtnString['error_focus'] = "no_focus";
			$rtnString['msg'] = "wrong approach";
			exit( json_encode($rtnString) );
		}


			/////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////
			// 현재 데이터
		$tmp_config_100	=	$this->Config_model->get_config_10_pk( $this->input->get_post('config_10_pk') );
		$arr_config_100	=	$tmp_config_100[0];
			// 현재 데이터
			/////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////


//		if(strlen(trim($this->input->get_post('config_10_value')))<1)
//		{
//			$rtnString['error_focus'] = "config_10_value";
//			$rtnString['msg'] = "[data] Please enter a value";
//			exit( json_encode($rtnString) );
//		}


		switch ($arr_config_100['config_10_input'])
		{
			case "number":
				if( !preg_match( $number_pattern, $this->input->get_post('config_10_value') ) )
				{
					$rtnString['error_focus'] = "config_10_value";
					$rtnString['msg'] = "[data] Only numbers can be entered";
					exit( json_encode($rtnString) );
				}

			break;
		}


		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////



		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// 데이터 처리
		$arrData['tbl_name1']    =   'config_10_default';

		$arrData['arr_data1']['config_10_pk']=$this->input->get_post('config_10_pk');
		$arrData['arr_data1']['config_10_value']=$this->input->get_post('config_10_value');


		$rtnString =  $this->Config_model ->update_config_10_default( $arrData );

		// 데이터 처리
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////


		exit( json_encode($rtnString) );
	}


	// config
	// config
	//=============================================================================================================
	//=============================================================================================================




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
