<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dev_tools_01 extends CI_Controller {

    /// @brief 전송 세그먼트 값 연관배열 저장 변수 선언
    private $arr_segment			=	array();

    /// @brief 기본사용 페이지 레이아웃 템플릿 HTML 경로 저장 변수
    private $cfg_pageLayout 		=	"";

    /// @brief 클래스 내부 사용 전역 변수 선언
    public $arr_class_common   	    =	array();

    /// @brief 로그인 및 권한정보 저장 변수
    public $arr_Auth_info			=	null;

    /// @brief UNIXTIME 저장 변수
    public $now_unixtime			=	null;

    public function __construct()
    {
        parent::__construct();

        // - UNIXTIME 설정
        $this->now_unixtime =   time();

        // - URL 세그먼테이션 전달값 할당
        $this->arr_segment	=	$this->uri->uri_to_assoc(3);

        // - 클래스 내부 전역 변수값 설정
        $this->arr_class_common	=	array(
            "siteURL"				=>	base_url() //base_url은 config파일에 설정되어 있다.
        //,"System_info"          =>  $this->lib_cfg_env->get_linux_system_info()
        );


        ////////////////////////////////////////////////////////////////////////////
        //	@	DB 접속 / DB MODEL 로드
        ////////////////////////////////////////////////////////////////////////////
		$dbconfig_file = $this->zest_common->get_db_config();
		$cfg_server_db1_connect_info	=	$_SERVER["DOCUMENT_ROOT"];
		$cfg_server_db1_connect_info	.=	$dbconfig_file;

		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->load->database($config);

		$this->load->model('Dev_tools_01_model');

        ////////////////////////////////////////////////////////////////////////////
        //	@	컨트롤러에서 기본적으로 사용할 페이지 레이아웃 정의
        ////////////////////////////////////////////////////////////////////////////

        $this->cfg_pageLayout		=	'layout_default.html';


        //  @   로그인 검사 시작 ----------------------------------------------------------------------------
        //	@	로그인 쿠키 존재 여부 검사
        if( strlen( trim( $this->input->cookie('json_auth_info_admin') ) ) == 0 )
        {
            //	@	로그인 값 쿠키가 없을 경우 로그인 창 페이지 출력
            $targetUrl  =   "/CI/index.php/Admin_login/login_write";

            $js =   "<script>";
            $js .=  "window.location.href='".$targetUrl."';";
            $js .=  "</script>";
            exit($js);

        }//	end if
        $this->arr_Auth_info                =   json_decode( base64_decode( $this->input->cookie('json_auth_info_admin') ) , true );

//        echo "<pre>";
//        var_export( $this->arr_Auth_info );
//        echo "</pre>";

//        $this->arr_class_common['a01_name'] =   $this->arr_Auth_info['a01_name'];

        //  @   로그인 검사 끝 ------------------------------------------------------------------------------

        //  @   접근권한 검사 시작 ---------------------------------------------------------------------------

        $arr_agr   =   null;
//        $arr_agr['a01_pk']          =   $this->arr_Auth_info['a01_pk'];
//        $arr_agr['a01_id']          =   $this->arr_Auth_info['a01_id'];
//        $arr_agr['segments'][0]     =   null;
//        $arr_agr['segments'][1]     =   null;
//
//        if( isset( $this->uri->segments[1] ) === true )
//        {
//            $arr_agr['segments'][0]     =   $this->uri->segments[1];
//        }// end if
//
//        if( isset( $this->uri->segments[2] ) === true )
//        {
//            $arr_agr['segments'][1]     =   $this->uri->segments[2];
//        }// end if
//
//        //  @   검사예외 설정
//        $arr_agr['exception_func']  =   array(
//            'index'
//        ,'dbProc_corp_01_insert'
//        ,'dbProc_corp_01_update'
//        ,'dbProc_corp_01_delete'
//        ,'displayPage'
//        );

//        $arrRtnResult    =   $this->lib_cfg_util->check_auth($arr_agr);

//        if( $arrRtnResult["Result"] === "deny" )
//        {
//            //	@	권한이 없을 경우
//            $targetUrl  =   base_url();
//            if($this->input->is_ajax_request() === true)
//            {
//                //  @   AJAX 호출
//                $this->lib_cfg_util->output_jsonString( json_encode( array("SQL_Result"    =>  "FAIL","SQL_Error"    =>  "AccessDeny") ) );
//                exit();
//            }else{
//                //  @   일반 호출
//                $js =   "<script>";
//                $js .=  "alert('접근권한을 확인하세요.');";
//                $js .=  "window.location.href='".$targetUrl."';";
//                $js .=  "</script>";
//                exit($js);
//
//            }// end if
//        }// end if

        //  @   접근권한 검사 끝 ----------------------------------------------------------------------------

    }//	end function


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /// @brief 별도의 실행 함수가 정의되지 않았을 경우 기본 실힝 함수
    /// - class : Actor_01
    /// - function : index
    /// @author yym
    ///
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
//        echo "controllers name : ".__CLASS__ ."</br>";
//        echo "function name : ".__FUNCTION__."</br >";
//        echo "<pre>";
//            var_Export($_REQUEST);
//        echo "</pre>";

        //	@	로그인 값 쿠키가 있을 경우
        $targetUrl  =   $this->arr_class_common['siteURL'];
        $targetUrl  .=   "index.php/".__CLASS__."/db_table_01_list";

        $js =   "<script>";
        $js .=  "window.location.href='".$targetUrl."';";
        $js .=  "</script>";
        exit($js);

    }//	end function

    public function db_table_01_list()
    {
//        echo "controllers name : ".__CLASS__ ."</br>";
//        echo "function name : ".__FUNCTION__."</br >";
//        echo "<pre>";
//            var_Export($_REQUEST);
//        echo "</pre>";

        //	@	출력 위젯 정의 & 컨텐츠 위젯 처리값( HTML ) 받아오기
        $this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
            'widgets/widget_leftMenu'
            , array(
                'controller'	 	=>	__CLASS__
                ,'function'			=>	__FUNCTION__
            )
            );

        $this->arr_class_common["widget_contents"]	=	$this->widget->run(
            'widgets/dev_tools_01/widget_db_table_01_list'
            , array(
                'controller'	 	=>	__CLASS__
                ,'function'			=>	__FUNCTION__
                ,'sendData'			=>	$this->arr_segment
            )
            );

        //	@	페이지 출력 여부 정의
        $chk_execParser				=	'execParser_YES';

        //	@	페이지 출력 실행
        $this->displayPage( $chk_execParser );

    }//	end function

    public function db_table_01_detail()
    {
//        echo "controllers name : ".__CLASS__ ."</br>";
//        echo "function name : ".__FUNCTION__."</br >";
//        echo "<pre>";
//        var_Export($_REQUEST);
//        echo "</pre>";

        $this->arr_class_common["widget_leftMenu"]	   =	$this->widget->run(
            'widgets/widget_leftMenu'
            , array(
                'controller'	 	=>	__CLASS__
            ,'function'			=>	__FUNCTION__
            )
        );

        $this->arr_class_common["widget_contents"]	=	$this->widget->run(
            'widgets/dev_tools_01/widget_db_table_01_detail'
            , array(
                'controller'	 	=>	__CLASS__
            ,'function'			=>	__FUNCTION__
            ,'sendData'			=>	$this->arr_segment
            )
        );

        //	@	페이지 출력 여부 정의
        $chk_execParser				=	'execParser_YES';

        //	@	페이지 출력 실행
        $this->displayPage( $chk_execParser );

    }// end function


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
