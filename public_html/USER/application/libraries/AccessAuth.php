<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AccessAuth {

	//	@	전송 세그먼트 값 연관배열 저장 변수 선언
	public $chkRun						=	"1";
	public $ReturnVals					=	array();
	public $arr_AccessAuthAgrs			=	array();


	private $Login_ID					=	"";
	private $Controller					=	"";
	private $Function					=	"";
	private $PageCode					=	"";
	private $Result						=	array();



	public function __construct()
	{
		$this->CI = & get_instance();

		$this->CI->load->model('Sys_cfg_model');
		$this->CI->load->model('Admin_member_model');

	}//	end function


	public function check_login_state()
	{
		$rtnVal	=	"login_info_error";

		$obj_json_auth_info	=	json_decode( base64_decode( $this->arr_AccessAuthAgrs['json_auth_info'] ) , true );

		//	echo "<pre>"; var_dump( $obj_json_auth_info ); echo "</pre>";

		$this->Login_ID		=	$obj_json_auth_info['admin_01_id'];

		// echo "-----------------------------<BR>";
		// echo $this->Login_ID."<BR>";

		$this->Controller	=	$this->arr_AccessAuthAgrs['sys01_controller'];
		$this->Function		=	$this->arr_AccessAuthAgrs['sys01_function'];


		if( strlen(trim($this->Login_ID)) > 3 )
		{
			$rtnVal	=	"login_info_exist";
			$this->check_Step_01();
		}//	end if

		return $rtnVal;

	}//	end function


	private function check_Step_01()
	{
		$this->Result[0]	=	"START_Controller/Function_EXIST_CHECK_STEP_01";

		//	var_dump( $this->arr_AccessAuthAgrs );


		if( ( strlen( trim($this->Controller) ) > 0 )&&( strlen( trim($this->Function) ) > 0 ) )
		{
			////////////////////////////////////////////////////////////////////////////
			//	@	컨트롤러 / 함수 등록 여부 검사 - 미등록시 등록처리 시작

				$this->CI->db->reset_query();
				$this->CI->db->flush_cache();
				$this->CI->db->start_cache();
				//	$this->CI->db->stop_cache();
				//---------------------------------------------------------------------------------------------
				//	@	Get Record DATA Start

					$this->CI->db->select("*", FALSE);
					$this->CI->db->from( "sys_cfg_01_pageList AS TB1" );
					$this->CI->db->where( "TB1.sys01_controller", $this->Controller );
					$this->CI->db->where( "TB1.sys01_function"	, $this->Function );

					$selectSQL	=	$this->CI->db->get_compiled_select();
					//	echo "<pre>"; echo $selectSQL."<BR>"; echo "</pre>";

					$arr_SQL_Result		=	null;
					$arr_SQL_Result		=	$this->CI->common_model->executeSQL( $selectSQL , 'array');

				//	@	Get Record DATA End
				//---------------------------------------------------------------------------------------------
				$this->CI->db->stop_cache();
				$this->CI->db->flush_cache();
				$this->CI->db->reset_query();

				if( count( $arr_SQL_Result ) == 0 )
				{
					$arrJSON	=	array(
										'sys01_recordNum'			=>	''
										,'sys01_seq'				=>	500
										,'sys01_controller'			=>	$this->Controller
										,'sys01_function'			=>	$this->Function
										,'sys01_pageDescription'	=>	''
										,'sys01_pageNameDisplay'	=>	'N'
										);

					$JSON		=	json_encode($arrJSON);

					if( $this->CI->Sys_cfg_model->insert_sys_cfg_01_default( $JSON ) == true )
					{
						//	@	PASS
					}//	end if

				}//	end if

			//	@	컨트롤러 / 함수 등록 여부 검사 - 미등록시 등록처리 끝
			////////////////////////////////////////////////////////////////////////////
		}//	end if

		$this->Result[0]	=	"FINISHT_Controller/Function_EXIST_CHECK_STEP_01";

		$this->check_Step_02();

	}//	end function



	private function check_Step_02()
	{
		$this->Result[1]	=	"START_GET_PAGE_CODE_VAL_STEP_02";
		////////////////////////////////////////////////////////////////////////////
		//	@	컨트롤러 / 함수 등록 여부 검사 - 미등록시 등록처리 시작

			$this->CI->db->reset_query();
			$this->CI->db->flush_cache();
			$this->CI->db->start_cache();
			//	$this->CI->db->stop_cache();
			//---------------------------------------------------------------------------------------------
			//	@	Get Record DATA Start

				$this->CI->db->select("*", FALSE);
				$this->CI->db->from( "sys_cfg_01_pageList AS TB1" );
				$this->CI->db->where( "TB1.sys01_controller", $this->Controller );
				$this->CI->db->where( "TB1.sys01_function"	, $this->Function );

				$selectSQL	=	$this->CI->db->get_compiled_select();
				//	echo "<pre>"; echo $selectSQL."<BR>"; echo "</pre>";

				$arr_SQL_Result		=	null;
				$arr_SQL_Result		=	$this->CI->common_model->executeSQL( $selectSQL , 'array');

			//	@	Get Record DATA End
			//---------------------------------------------------------------------------------------------
			$this->CI->db->stop_cache();
			$this->CI->db->flush_cache();
			$this->CI->db->reset_query();

		//	var_export( $arr_SQL_Result );

		$this->PageCode		=	$arr_SQL_Result[0]['sys01_recordNum'];

		$this->Result[1]	=	"FINISH_GET_PAGE_CODE_VAL_STEP_02";

		if($this->chkRun == 1)
		{
			echo "<BR>";
			echo $this->Result[ ( count($this->Result)-1 ) ];
			echo "<BR>";
		}//	end if

		$this->check_Step_03();
	}//	end function



	private function check_Step_03()
	{
		$this->Result[2]	=	"START_PERSONAL_ACCESSAUTH_RECORD_EXIST_CHECK_STEP_03";

		////////////////////////////////////////////////////////////////////////////
		//	@	개인별 접근 권한 레코드 존재 여부 검사 - 미등록시 생성 - 시작

			$this->CI->db->reset_query();
			$this->CI->db->flush_cache();
			$this->CI->db->start_cache();
			//	$this->CI->db->stop_cache();
			//---------------------------------------------------------------------------------------------
			//	@	Get Record DATA Start

				$this->CI->db->select(
										"
										*
										,IFNULL( TB2.admin_99_id ,'".$this->Login_ID."' )		AS admin_99_id
 										,IFNULL( TB2.admin_99_pageCode ,TB1.sys01_recordNum )	AS admin_99_pageCode
										,IFNULL( TB2.admin_99_read   , 'N') AS admin_99_read
										,IFNULL( TB2.admin_99_write  , 'N') AS admin_99_write
										,IFNULL( TB2.admin_99_modify , 'N') AS admin_99_modify
										,IFNULL( TB2.admin_99_delete , 'N') AS admin_99_delete

										", FALSE);
				$this->CI->db->from( "sys_cfg_01_pageList AS TB1" );
				$this->CI->db->join( "member_admin_99_accessAuth AS TB2", "TB1.sys01_recordNum=TB2.admin_99_pageCode", "left outer", TRUE );
				$this->CI->db->where( "TB2.admin_99_id"		, $this->Login_ID	 );
				$this->CI->db->where( "TB1.sys01_recordNum"	, $this->PageCode	 );

				$selectSQL	=	$this->CI->db->get_compiled_select();
				//	echo "<pre>"; echo $selectSQL."<BR>"; echo "</pre>";

				$arr_SQL_Result		=	null;
				$arr_SQL_Result		=	$this->CI->common_model->executeSQL( $selectSQL , 'array');

			//	@	Get Record DATA End
			//---------------------------------------------------------------------------------------------
			$this->CI->db->stop_cache();
			$this->CI->db->flush_cache();
			$this->CI->db->reset_query();


			if( count( $arr_SQL_Result ) == 0 )
			{
				//	@	접근 페이지 정의 누락의 경우 처리
				$arrData['tbl_name']	=	"member_admin_99_accessAuth";
				$arrData['arr_data']	=	array(
										'admin_99_recordNum'		=>	''
										,'admin_99_id'				=>	$this->Login_ID
										,'admin_99_pageCode'		=>	$this->PageCode
										,'admin_99_controller'		=>	$this->Controller
										,'admin_99_function'		=>	$this->Function
										,'admin_99_read'			=>	'N'
										,'admin_99_write'			=>	'N'
										,'admin_99_modify'			=>	'N'
										,'admin_99_delete'			=>	'N'
									);

				////////////////////////////////////////////////////////////////////////////////////////
				//
				//	권한 설정 예외처리 시작	----------------------------------------------------------------

					if( $this->Login_ID == 'root' )
					{
						$arrData['arr_data']['admin_99_read']	=	"Y";
						$arrData['arr_data']['admin_99_write']	=	"Y";
						$arrData['arr_data']['admin_99_modify']	=	"Y";
						$arrData['arr_data']['admin_99_delete']	=	"Y";
					}//	end if

                    if( strpos( strtoupper( $this->Function ), 'AJAX' ) !== false )
                    {
						$arrData['arr_data']['admin_99_read']	=	"Y";
						$arrData['arr_data']['admin_99_write']	=	"Y";
						$arrData['arr_data']['admin_99_modify']	=	"Y";
						$arrData['arr_data']['admin_99_delete']	=	"Y";
					}//	end if

					if( strtoupper( substr($this->Function, -6) ) == "DBPROC" )
					{
						$arrData['arr_data']['admin_99_read']	=	"Y";
						$arrData['arr_data']['admin_99_write']	=	"Y";
						$arrData['arr_data']['admin_99_modify']	=	"Y";
						$arrData['arr_data']['admin_99_delete']	=	"Y";
					}//	end if

				//	권한 설정 예외처리 끝	----------------------------------------------------------------
				//
				////////////////////////////////////////////////////////////////////////////////////////

				if( $this->CI->Admin_member_model->insert_member_admin_99_accessAuth( $arrData ) == true )
				{
					//	@ PASS
				}//	end if
			}//	end if

		//	@	개인별 접근 권한 레코드 존재 여부 검사 - 미등록시 생성 - 끝
		////////////////////////////////////////////////////////////////////////////

		////////////////////////////////////////////////////////////////////////////

		$this->Result[2]	=	"FINISH_PERSONAL_ACCESSAUTH_RECORD_EXIST_CHECK_STEP_03";

		if($this->chkRun == 1)
		{
			echo "<BR>";
			echo $this->Result[ ( count($this->Result)-1 ) ];
			echo "<BR>";
		}//	end if

		$this->check_Step_04();

	}//	end function


	private function check_Step_04()
	{
		$this->Result[3]	=	"START_GET_PERSONAL_ACCESS_AUTH_VALS_STEP_04";

		////////////////////////////////////////////////////////////////////////////
		//	@	페이지 접근 권한 검사 실행 시작

			$this->CI->db->reset_query();
			$this->CI->db->flush_cache();
			$this->CI->db->start_cache();
			//	$this->CI->db->stop_cache();
			//---------------------------------------------------------------------------------------------
			//	@	Get Record DATA Start

				$this->CI->db->select(
										"
										*
										,IFNULL( TB2.admin_99_id ,'".$this->Login_ID."' )		AS admin_99_id
 										,IFNULL( TB2.admin_99_pageCode ,TB1.sys01_recordNum )	AS admin_99_pageCode
										,IFNULL( TB2.admin_99_read   , 'N') AS admin_99_read
										,IFNULL( TB2.admin_99_write  , 'N') AS admin_99_write
										,IFNULL( TB2.admin_99_modify , 'N') AS admin_99_modify
										,IFNULL( TB2.admin_99_delete , 'N') AS admin_99_delete

										", FALSE);
				$this->CI->db->from( "sys_cfg_01_pageList AS TB1" );
				$this->CI->db->join( "member_admin_99_accessAuth AS TB2", "TB1.sys01_recordNum=TB2.admin_99_pageCode", "left outer", TRUE );
				$this->CI->db->where( "TB2.admin_99_id"		, $this->Login_ID	 );
				$this->CI->db->where( "TB1.sys01_recordNum"	, $this->PageCode	 );

				$selectSQL	=	$this->CI->db->get_compiled_select();
				//	echo "<pre>"; echo $selectSQL."<BR>"; echo "</pre>";

				$arr_SQL_Result		=	null;
				$arr_SQL_Result		=	$this->CI->common_model->executeSQL( $selectSQL , 'array');

			//	@	Get Record DATA End
			//---------------------------------------------------------------------------------------------
			$this->CI->db->stop_cache();
			$this->CI->db->flush_cache();
			$this->CI->db->reset_query();

			$this->ReturnVals['page_info']	=	$arr_SQL_Result[0]['sys01_controller']."/".$arr_SQL_Result[0]['sys01_function'];
			$this->ReturnVals['READ']		=	$arr_SQL_Result[0]['admin_99_read'];
			$this->ReturnVals['WRITE']		=	$arr_SQL_Result[0]['admin_99_write'];
			$this->ReturnVals['MODIFY']		=	$arr_SQL_Result[0]['admin_99_modify'];
			$this->ReturnVals['DELETE']		=	$arr_SQL_Result[0]['admin_99_delete'];

		//	@	페이지 접근 권한 검사 실행 끝
		////////////////////////////////////////////////////////////////////////////


		////////////////////////////////////////////////////////////////////////////
		$this->Result[3]	=	"FINIST_GET_PERSONAL_ACCESS_AUTH_VALS_STEP_04";

		if($this->chkRun == 1)
		{
			echo "<BR>";
			echo $this->Result[ ( count($this->Result)-1 ) ];
			echo "<BR>";
		}//	end if

		//$this->check_Step_05();
	}//	end function









/*
	public function check_DB_Work_AccessAuth( $sqlMode )
	{
		// $this->ReturnVals['READ']		=	$arr_SQL_Result[0]->{'p99_read'};
		// $this->ReturnVals['WRITE']		=	$arr_SQL_Result[0]->{'p99_write'};
		// $this->ReturnVals['MODIFY']		=	$arr_SQL_Result[0]->{'p99_modify'};
		// $this->ReturnVals['DELETE']		=	$arr_SQL_Result[0]->{'p99_delete'};

		//var_dump( $this->ReturnVals );
		$targetAuthPartVal	=	"";

		if( strlen( trim($sqlMode) ) > 0 )
		{
			switch( $sqlMode )
			{
				case "insert":	$targetAuthPartVal	=	$this->ReturnVals['WRITE'];		break;
				case "update":	$targetAuthPartVal	=	$this->ReturnVals['MODIFY'];	break;
				default:

			}//	end switch
		}else{
			exit( "UNDEFINE : SQL WORK MODE " );
		}//end if


		if( $targetAuthPartVal == "Y" )
		{
			//	@	PASS
		}else{
			$msg	=	"[".$this->Login_ID."] 접근권한 없음.";
			$JS		=	"<script>";
			$JS		.=	"alert( '".$msg."' );";
			$JS		.=	"window.location.href='".site_url()."'";
			$JS		.=	"</script>";
			exit( $JS );
		}//	end if




	}//	end function




*/





}//	end class


?>