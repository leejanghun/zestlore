<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_admin_list extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{
		$arr_searchValue        =   null;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$arr_VARIABLE_DATA	    =	null;
		$arr_VARIABLE_DATA		=	array();
		$arr_VARIABLE_DATA		=	$arrayData;

		$arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
		$arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
		$arr_VARIABLE_DATA['function']			=	$arrayData['function'];

		$arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/index.php";
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
						//history_back("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
		                //exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");

		        }//	end switch

		    }//	end if
		}//	end for

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 전달값

		$arr_VARIABLE_DATA['FILTER_FIELD_NAME']		=	$this->CI->input->get_post("FILTER_FIELD_NAME");
		$arr_VARIABLE_DATA['FILTER_FIELD_VALUE']	=	$this->CI->input->get_post("FILTER_FIELD_VALUE");
		$arr_VARIABLE_DATA['per_page']	=	$this->CI->input->get_post("per_page");

		/// @ 전달값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	게시물 목록 가져오기 시작

		$arrData				=   null;

		//-------------------------------------------------------------------------
		//  검색처리값 처리 시작 -----------------------------------------------------

		if(
			( is_null( $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] ) === false )
			&& ( strlen( trim( $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] ) ) > 0 )
		)
		{
			$arrData['sqlWhere'] = " admin_00_default.".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'] . " Like '%" . $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] . "%'";
			$arr_searchValue['FILTER_FIELD_NAME']	= $arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
			$arr_searchValue['FILTER_FIELD_VALUE']	= $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];
		}else{
			$arr_searchValue['FILTER_FIELD_NAME']	= "";
			$arr_searchValue['FILTER_FIELD_VALUE']	= "";
		}//	end if

		//  검색처리값 처리 끝 ---------------------------------------------------------
		//---------------------------------------------------------------------------


		$arr_admin_00_recCnt	=   null;
		$arr_admin_00_recCnt	=	$this->CI->Admin_model->getAdmin_RecordCnt( $arrData );

		$_CNT_TOTAL_RECORD    =   0;

		if(
			( is_array($arr_admin_00_recCnt) === false )
			|| ( count($arr_admin_00_recCnt) === 0 ) )
		{
			//	@	nothing
		}else{
			$_CNT_TOTAL_RECORD    =   $arr_admin_00_recCnt[0]['RecordCount'];
		}//	end if


		$_CNT_RECORD_PER_PAGE =   10;
		// $_CNT_RECORD_PER_PAGE =   2;//test
		$_CNT_NUMBER_PER_PAGE =   5;
		$_NOWPAGE             =   0;


		if(( isset( $arr_VARIABLE_DATA['per_page'] ) === TRUE )&&( $arr_VARIABLE_DATA['per_page'] > 0 ))
		{
			$_NOWPAGE  =   $arr_VARIABLE_DATA['per_page'];
		}//	end if


		$arrData['Limit_RecCnt']   =   $_CNT_RECORD_PER_PAGE;
		$arrData['Limit_nowPage']  =   $_NOWPAGE;
		$arrData['OrderBy']        =   "admin_00_pk DESC";

		$arr_admin_00_recList	=   null;
		$arr_admin_00_recList	=	$this->CI->Admin_model->getAdmin_RecordList( $arrData );


		$arr_recordList	=	array();
		$loopCntLimit	=	count( $arr_admin_00_recList );

		$record_no = $_CNT_TOTAL_RECORD - $_NOWPAGE;// 게시글 출력번호

		for($loopCnt_1 = 0; $loopCntLimit > $loopCnt_1; $loopCnt_1++)
		{
			$arr_recordList[$loopCnt_1]                       	=   $arr_admin_00_recList[$loopCnt_1];

			$arr_recordList[$loopCnt_1]['detail_url']   =   $arr_VARIABLE_DATA['siteURL'];
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "index.php/admin_default/admin_view";
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "?admin_00_pk=".$arr_admin_00_recList[$loopCnt_1]['admin_00_pk'];

			$arr_recordList[$loopCnt_1]['record_no']   =   $record_no--; // 게시글 출력번호

		}//	end for

		$arr_VARIABLE_DATA['arr_recordList']	=	$arr_recordList;


		//	@	게시물 목록 가져오기 끝
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	검색 창 처리

		$arr_FILTER_FIELD_OPTION_TEXT		=	array("id", "name");
		$arr_FILTER_FIELD_OPTION_VALUE		=	array("admin_00_id", "admin_00_name");
		$arr_VARIABLE_DATA['html_sch_select_box']    =   makeOptionList(
			$arr_FILTER_FIELD_OPTION_VALUE
			, $arr_FILTER_FIELD_OPTION_TEXT
			, $selectedVal = $arr_searchValue['FILTER_FIELD_NAME']
		);
		//	@	검색 창 처리
		///////////////////////////////////////////////////////////////////////////////////////////////////////



		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	PAGE 처리 시작
		$cfg_pagination                         =    null;
		$cfg_pagination['base_url']				=	 $arr_VARIABLE_DATA['NowPageURL'];


		//	처음으로
		$cfg_pagination['first_tag_open']		= '<li class="paginate_button page-item first" id="dataTable_first">';
		$cfg_pagination['first_link'] 			= 'First';
		$cfg_pagination['first_tag_close']		= '</li>';

		//	이전 페이지 => [ -1 페이지 ]
		$cfg_pagination['prev_tag_open'] 		= '<li class="paginate_button page-item previous" id="dataTable_previous">';
		$cfg_pagination['prev_link']			= 'Previous';
		$cfg_pagination['prev_tag_close'] 		= '</li>';

		//	다음 페이지 => [ +1 페이지 ]
		$cfg_pagination['next_tag_open'] 		= '<li class="paginate_button page-item next" id="dataTable_next">';
		$cfg_pagination['next_link']			= 'Next';
		$cfg_pagination['next_tag_close'] 		= '</li>';

		//	끝으로
		$cfg_pagination['last_tag_open']		= '<li class="paginate_button page-item last" id="dataTable_last">';
		$cfg_pagination['last_link']			= 'Last';
		$cfg_pagination['last_tag_close']		= '</li>';

		//	현재 페이지
		$cfg_pagination['cur_tag_open']			=	'<li class="paginate_button page-item active">';
		$cfg_pagination['cur_tag_open']			.=	'<a aria-controls="dataTable" class="page-link">';

		$cfg_pagination['cur_tag_close']		=	'</a></li>';

		//  aria-controls="dataTable" data-dt-idx="0" tabindex="0"


		//	페이지 번호
		$cfg_pagination['num_tag_open']			=	'<li class="paginate_button page-item">';
		$cfg_pagination['num_tag_close']		=	'</li>';

		//    <a href="#" aria-controls="dataTable" class="page-link">4</a>

		$cfg_pagination['num_links'] 			=	$_CNT_NUMBER_PER_PAGE;
		$cfg_pagination['total_rows']			=	$_CNT_TOTAL_RECORD;
		$cfg_pagination['per_page']				=	$_CNT_RECORD_PER_PAGE;
		$cfg_pagination['page_query_string']	=	TRUE;
		$cfg_pagination['reuse_query_string']		=	TRUE;
		$cfg_pagination['use_page_numbers']		=	FALSE;
		$cfg_pagination['cur_page']				=	$_NOWPAGE;
		//		$cfg_pagination['use_page_numbers'] 	=	TRUE;
		//		$cfg_pagination['uri_segment']		=	1;
		//		$cfg_pagination['cur_page']			=	5;

		$this->CI->pagination->initialize($cfg_pagination);

		$pageNumber	=	$this->CI->pagination->create_links();

		//var_dump( $pageNumber );

		if(strlen(trim($pageNumber)) == 0 )
		{
			$pageNumber	=	1;
		}//	end if

		$this->CI->pagination->initialize($cfg_pagination);

		$pageNumber	=	$this->CI->pagination->create_links();
		if(strlen(trim($pageNumber)) == 0 )
		{
			//  $pageNumber	=	'<li class="paginate_button"><a>1</a></li>';
		}//	end if

		$arr_VARIABLE_DATA['pageNumber']		=	$pageNumber;

		//	@	PAGE 처리 끝
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ 목록표시 값
		$arr_VARIABLE_DATA['total_record'] = number_format($_CNT_TOTAL_RECORD);
		// @ 목록표시 값
		///////////////////////////////////////////////////////////////////////////////////////////////////////



		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@ 링크

		$arr_VARIABLE_DATA['url_go_list']   =   "";
		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "index.php/admin_default/admin_list";


		$arr_VARIABLE_DATA['url_go_write']   =   "";
		$arr_VARIABLE_DATA['url_go_write']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_write']   .=   "index.php/admin_default/admin_writeForm";

		//	@ 링크
		///////////////////////////////////////////////////////////////////////////////////////////////////////



		$htmlFilePath         =   "widgets/admin/widget_admin_list.html";

		return $this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);



	}//	end function


}

?>















