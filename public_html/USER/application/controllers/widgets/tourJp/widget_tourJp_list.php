<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_tourJp_list extends Widget {


	public function __construct()
	{

		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{

		//debug_var(simple_debug_backtrace());exit;
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
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ ?????????

		$arr_VARIABLE_DATA['FILTER_FIELD_NAME']		=	$this->CI->input->get_post("FILTER_FIELD_NAME");
		$arr_VARIABLE_DATA['FILTER_FIELD_VALUE']	=	$this->CI->input->get_post("FILTER_FIELD_VALUE");
		$arr_VARIABLE_DATA['per_page']	=	$this->CI->input->get_post("per_page");

		/// @ ?????????
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	????????? ?????? ???????????? ??????

		$arrData				=   null;

		$arr_sql_where = array();
		//-------------------------------------------------------------------------
		//  ??????????????? ?????? ?????? -----------------------------------------------------

		if(
			( is_null( $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] ) === false )
			&& ( strlen( trim( $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] ) ) > 0 )
		)
		{
			$arr_sql_where[] = " tourJp_400_default.".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'] . " Like '%" . $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'] . "%'";
			$arr_searchValue['FILTER_FIELD_NAME']	= $arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
			$arr_searchValue['FILTER_FIELD_VALUE']	= $arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];
		}else{
			$arr_searchValue['FILTER_FIELD_NAME']	= "";
			$arr_searchValue['FILTER_FIELD_VALUE']	= "";
		}//	end if


		if( count($arr_sql_where)>0 )
		{
			$arrData['sqlWhere'] = implode(" and " , $arr_sql_where);
		}

		//  ??????????????? ?????? ??? ---------------------------------------------------------
		//---------------------------------------------------------------------------


		$arr_SQL_Result	=   null;
		$arr_SQL_Result       =   $this->CI->TourJp_model->getTourJp_RecordCnt( $arrData );

		$_CNT_TOTAL_RECORD    =   0;

		if(
			( is_array($arr_SQL_Result) === false )
			|| ( count($arr_SQL_Result) === 0 ) )
		{
			//	@	nothing
		}else{
			$_CNT_TOTAL_RECORD    =   $arr_SQL_Result[0]['RecordCount'];
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
		$arrData['OrderBy']        =   "tourJp_400_pk desc";

		$arr_SQL_Result	=   null;
		$arr_SQL_Result       =   $this->CI->TourJp_model->getTourJp_RecordList($arrData);


		$arr_recordList	=	array();
		$loopCntLimit	=	count( $arr_SQL_Result );

		$record_no = $_CNT_TOTAL_RECORD - $_NOWPAGE;// ????????? ????????????

		for($loopCnt_1 = 0; $loopCntLimit > $loopCnt_1; $loopCnt_1++)
		{
			$arr_recordList[$loopCnt_1]                       	=   $arr_SQL_Result[$loopCnt_1];

			$arr_recordList[$loopCnt_1]['detail_url']   =   $arr_VARIABLE_DATA['siteURL'];
			$arr_recordList[$loopCnt_1]['detail_url']   .=  "index.php/tourJp_default/tourJp_detail";
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "?tourJp_400_pk=".$arr_SQL_Result[$loopCnt_1]['tourJp_400_pk'];
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "&per_page=".$arr_VARIABLE_DATA['per_page'];
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "&FILTER_FIELD_NAME=".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
			$arr_recordList[$loopCnt_1]['detail_url']   .=   "&FILTER_FIELD_VALUE=".$arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];


			$arr_recordList[$loopCnt_1]['tour_image'] = "images/avatar.jpg";
			if($arr_SQL_Result[$loopCnt_1]['tourJp_400_firstimage2'])
			{
				$arr_recordList[$loopCnt_1]['tour_image'] = $arr_SQL_Result[$loopCnt_1]['tourJp_400_firstimage2'];
			}

			$arr_recordList[$loopCnt_1]['record_no']   =   $record_no--; // ????????? ????????????
			$arr_recordList[$loopCnt_1]['record_no2']   =   $loopCnt_1+1;  // ????????? ????????????

		}//	end for

		$arr_VARIABLE_DATA['arr_recordList']	=	$arr_recordList;


		//	@	????????? ?????? ???????????? ???
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	PAGE ?????? ??????
		$cfg_pagination                         =    null;
		$cfg_pagination['base_url']				=	 $arr_VARIABLE_DATA['NowPageURL'];


		//	????????????
		$cfg_pagination['first_tag_open']		= '<li class="paginate_button page-item first" id="dataTable_first">';
		$cfg_pagination['first_link'] 			= 'First';
		$cfg_pagination['first_tag_close']		= '</li>';

		//	?????? ????????? => [ -1 ????????? ]
		$cfg_pagination['prev_tag_open'] 		= '<li class="paginate_button page-item previous" id="dataTable_previous">';
		$cfg_pagination['prev_link']			= 'Previous';
		$cfg_pagination['prev_tag_close'] 		= '</li>';

		//	?????? ????????? => [ +1 ????????? ]
		$cfg_pagination['next_tag_open'] 		= '<li class="paginate_button page-item next" id="dataTable_next">';
		$cfg_pagination['next_link']			= 'Next';
		$cfg_pagination['next_tag_close'] 		= '</li>';

		//	?????????
		$cfg_pagination['last_tag_open']		= '<li class="paginate_button page-item last" id="dataTable_last">';
		$cfg_pagination['last_link']			= 'Last';
		$cfg_pagination['last_tag_close']		= '</li>';

		//	?????? ?????????
		$cfg_pagination['cur_tag_open']			=	'<li class="paginate_button page-item active">';
		$cfg_pagination['cur_tag_open']			.=	'<a aria-controls="dataTable" class="page-link">';

		$cfg_pagination['cur_tag_close']		=	'</a></li>';

		//  aria-controls="dataTable" data-dt-idx="0" tabindex="0"


		//	????????? ??????
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

		//	@	PAGE ?????? ???
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @ ???????????? ???
		$arr_VARIABLE_DATA['total_record'] = number_format($_CNT_TOTAL_RECORD);
		// @ ???????????? ???
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	?????? ??? ??????

		$arr_FILTER_FIELD_OPTION_TEXT		=	array("title", "address");
		$arr_FILTER_FIELD_OPTION_VALUE		=	array("tourJp_400_title", "tourJp_400_addr1");
		$arr_VARIABLE_DATA['html_sch_select_box']    =   makeOptionList(
			$arr_FILTER_FIELD_OPTION_VALUE
			, $arr_FILTER_FIELD_OPTION_TEXT
			, $selectedVal = $arr_searchValue['FILTER_FIELD_NAME']
		);
		//	@	?????? ??? ??????
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////


		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@ ??????

		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=  "index.php/tour_default/tour_list";


		//	@ ??????
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////

		$htmlFilePath         =   "widgets/tourJp/widget_tourJp_list.html";
		return $this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);



	}//	end function


}

?>















