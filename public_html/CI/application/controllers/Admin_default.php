<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///////////////////////////////////////////////////////////////////////////////
/// @brief 관리자 정보관리 컨트롤러
/// - class : Administrators
/// - function : enclosing_method
/// @author yym
///////////////////////////////////////////////////////////////////////////////
class Admin_default extends CI_Controller {

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
        $this->load->model('Admin_model');


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


    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /// @brief 관리자 목록 처리
    /// - class : Administrators
    /// - function : admin_list
    /// @author Yuk.Young.Min
    ///
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    public function admin_list()
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
            'widgets/admin/widget_admin_list'
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





	public function admin_writeForm()
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
			'widgets/admin/widget_admin_writeForm'
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
	}// end -fun



	public function dbProc_admin_insert()
	{

		// debug_var(simple_debug_backtrace());exit;

		$this->check_auth_info_ajax();
		$this->get_auth_info();

		$arrData    =   null;
		$rtnString['SQL_Result'] = "FAIL";



		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		if(1)
		{

			$rtnString['error_type'] = "validation";

			if (strlen(trim($this->input->get_post('admin_00_id'))) < 1) {
				$rtnString['error_focus'] = "admin_00_id";
				$rtnString['msg'] = "[ID] 입력하세요";
				exit(json_encode($rtnString));
			}


			$arrData              =   null;
			$arrData['sqlWhere']  =   array('admin_00_id' =>  $this->input->get_post('admin_00_id'));

			$arr_SQL_Result       =   null;
			$arr_SQL_Result       =   $this->Admin_model->getAdmin_RecordList($arrData);


			$admin_00 = array();

			if(count($arr_SQL_Result)>0)
			{
				$admin_00 = $arr_SQL_Result[0];
			}


			if (isset($admin_00['admin_00_pk']) === true) {
				$rtnString['error_focus'] = "admin_00_id";
				$rtnString['msg'] = "ID 중복 입니다.";
				exit(json_encode($rtnString));
			}

			if (strlen(trim($this->input->get_post('admin_00_pw'))) < 1) {
				$rtnString['error_focus'] = "admin_00_pw";
				$rtnString['msg'] = "[password] 입력하세요";
				exit(json_encode($rtnString));
			}

			if (strlen(trim($this->input->get_post('admin_00_pw2'))) < 1) {
				$rtnString['error_focus'] = "admin_00_pw2";
				$rtnString['msg'] = "[password check] 입력하세요";
				exit(json_encode($rtnString));
			}

			if (trim($this->input->get_post('admin_00_pw')) != trim($this->input->get_post('admin_00_pw2'))) {
				$rtnString['error_focus'] = "admin_00_pw2";
				$rtnString['msg'] = "[password check] 비밀번호 확인 틀림";
				exit(json_encode($rtnString));
			}

			if (strlen(trim($this->input->get_post('admin_00_name'))) < 1) {
				$rtnString['error_focus'] = "admin_00_name";
				$rtnString['msg'] = "[name] 입력하세요";
				exit(json_encode($rtnString));
			}

		}// end - if(1)

		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////



		$arrData['tbl_name']    =   'admin_00_default';
		$arrData['arr_data']    = array (
			'admin_00_id' => $this->input->get_post('admin_00_id'),
			'admin_00_pw' => $this->input->get_post('admin_00_pw'),
			'admin_00_name' => $this->input->get_post('admin_00_name'),
			'admin_00_email' => $this->input->get_post('admin_00_email'),
			'admin_00_mobile' => $this->input->get_post('admin_00_mobile'),
			'admin_00_regdt' => $this->input->get_post('admin_00_regdt'),
			'admin_00_moddt' => $this->input->get_post('admin_00_moddt'),
			'admin_00_ip' => $this->input->get_post('admin_00_ip'),
		);

		//  echo "<pre>";	var_export( $arrData );		echo "</pre>";

		$rtnString =  $this->Admin_model->insert_admin_member_00( $arrData );

		exit( json_encode($rtnString) );

	}// end - fun




	public function admin_view()
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
			'widgets/admin/widget_admin_view'
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

	}




	public function admin_modifyForm()
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
			'widgets/admin/widget_admin_modifyForm'
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

	}




	public function dbProc_admin_update()
	{

		//debug_var(simple_debug_backtrace());exit;
		$this->check_auth_info_ajax();
		$this->get_auth_info();


		////////////////////////////////////////////////////////// 여기 진행중
		////////////////////////////////////////////////////////// 여기 진행중
		////////////////////////////////////////////////////////// 여기 진행중
		////////////////////////////////////////////////////////// 여기 진행중

		

		$arrData    =   null;
		//$rtnString  =   "FAIL";

		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////
		// @ 유효성 검사

		if(1) {

			$rtnString['SQL_Result'] = "FAIL";
			$rtnString['error_type'] = "validation";

			// 비밀번호 변경시
			if (strlen(trim($this->input->get_post('admin_00_pw'))) > 0) {

				if (strlen(trim($this->input->get_post('admin_00_pw2'))) < 1) {
					$rtnString['error_focus'] = "admin_00_pw2";
					$rtnString['msg'] = "[password check] 입력하세요";
					exit(json_encode($rtnString));
				}

				if (trim($this->input->get_post('admin_00_pw')) != trim($this->input->get_post('admin_00_pw2'))) {
					$rtnString['error_focus'] = "admin_00_pw2";
					$rtnString['msg'] = "[password check] Incorrect password confirmation";
					exit(json_encode($rtnString));
				}
			}

			if (strlen(trim($this->input->get_post('admin_00_name'))) < 1) {
				$rtnString['error_focus'] = "admin_00_name";
				$rtnString['msg'] = "[name] 입력하세요";
				exit(json_encode($rtnString));
			}

		}// end - if(0)

		// @ 유효성 검사
		/////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////



		////////////////////////////////////////////////////////////////////////
		/// 데이터 처리 start

		$arrData['tbl_name']    =   'admin_00_default';

		$arrData['arr_data']['admin_00_pk']	= $this->input->get_post('admin_00_pk');

		// 비밀번호
		if( strlen($this->input->get_post('admin_00_pw'))>0 )
		{
			$arrData['arr_data']['admin_00_pw']	= $this->input->get_post('admin_00_pw');
		}

		$arrData['arr_data']['admin_00_name']	= $this->input->get_post('admin_00_name');
		$arrData['arr_data']['admin_00_email']	= $this->input->get_post('admin_00_email');
		$arrData['arr_data']['admin_00_mobile']	= $this->input->get_post('admin_00_mobile');
		$arrData['arr_data']['admin_00_moddt']	= $this->input->get_post('admin_00_moddt');

		/// 데이터 처리 end
		////////////////////////////////////////////////////////////////////////

		//  echo "<pre>";	var_export( $arrData );		echo "</pre>";


		$rtnString =  $this->Admin_model->update_admin_member_00( $arrData );


		exit( json_encode($rtnString) );
	}




	public function dbProc_admin_delete()
	{

		// debug_var(simple_debug_backtrace());exit;

		$arrData    =   null;
		$rtnString  =   "FAIL";

		$arrData['tbl_name']    =   'admin_00_default';
		$arrData['arr_data']['admin_00_pk']	= $this->input->get_post('admin_00_pk');

		if( $this->Admin_model->delete_admin_member_00( $arrData ) == true )
		{
			$rtnString  =	"SUCCESS";
		}// end if

		exit( $rtnString );
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
