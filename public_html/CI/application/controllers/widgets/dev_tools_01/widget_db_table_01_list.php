<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_db_table_01_list extends Widget {


	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->library('pagination');

	}//	end function


	public function run( $arrayData )
	{
	    $arr_searchValue        =   null;
	    $arr_searchValue        =   array();

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

						$targetUrl  =   base_url();
						$js =   "<script>";
						$js .=  "alert('"."ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  "."');";
						$js .=  "window.location.href='".$targetUrl."';";
						$js .=  "</script>";

						exit($js);

		        }//	end switch

		    }//	end if
		}//	end for

		$arr_VARIABLE_DATA['dbName']	=	$this->CI->db->database;;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$arrData              =   null;
		$arrData['sqlWhere']  =   null;
		$arr_SQL_Result       =   null;
		$arr_SQL_Result       =   $this->CI->Dev_tools_01_model->getDbTablesList($arrData);

		//debug_var($arr_SQL_Result);

//		echo "<pre>";
//		var_export( $arr_SQL_Result );
//		echo "</pre>";

		$arr_recordList	=	array();
		$loopCnt		=	0;
		$loopCntLimit	=	count( $arr_SQL_Result );
		for($loopCnt = 0; $loopCntLimit > $loopCnt; $loopCnt++)
		{
		    $arr_recordList[$loopCnt]                       =   $arr_SQL_Result[$loopCnt];

		    $arr_recordList[$loopCnt]['detail_url']   =   $arr_VARIABLE_DATA['siteURL'];
		    $arr_recordList[$loopCnt]['detail_url']   .=   "index.php/Dev_tools_01/db_table_01_detail";
		    $arr_recordList[$loopCnt]['detail_url']   .=   "?table_name=".$arr_SQL_Result[$loopCnt]['MY_TABLE_NAME'];

		}//	end for

//		echo "<pre>";
//		var_export( $arr_recordList );
//		echo "</pre>";

		$arr_VARIABLE_DATA['arr_recordList']	=	$arr_recordList;


/*
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	PAGE 처리 시작
		$cfg_pagination                         =    null;
		$cfg_pagination['base_url']				=	 $arr_VARIABLE_DATA['NowPageURL'];

		//    @   검색값 전달 세그먼트가 있을 경우 처리
		if( count($arr_searchValue) > 0 )
		{
		    $arr_Keys	=	array_keys($arr_searchValue);

		    for( $loopCnt=0; count($arr_Keys)>$loopCnt; $loopCnt++ )
		    {
		        if( strlen( trim( $arr_searchValue[$arr_Keys[$loopCnt]] ) ) == 0 )
		        {
		            //    $cfg_pagination['base_url']			.=	"/".$arr_Keys[$loopCnt]."/NULL";
		        }else{
		            $cfg_pagination['base_url']			.=	"/".$arr_Keys[$loopCnt]."/".$arr_searchValue[$arr_Keys[$loopCnt]];
		        }//	end if
		    }//	end for
		}//	enf if


		$cfg_pagination['base_url']				.=	"/nowPage/";


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
		$cfg_pagination['page_query_string']	=	FALSE;
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


		$arr_VARIABLE_DATA['url_go_list']   =   "";
		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_list']   .=   "/Corp_01/corp_01_list";

		$arr_VARIABLE_DATA['url_go_write']   =   "";
		$arr_VARIABLE_DATA['url_go_write']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_write']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_write']   .=   "/Corp_01/corp_01_write";

//		$arr_VARIABLE_DATA['url_go_write']   =   "";
//		$arr_VARIABLE_DATA['url_go_write']   =   $arr_VARIABLE_DATA['siteURL'];
//		$arr_VARIABLE_DATA['url_go_write']   .=   "index.php";
//		$arr_VARIABLE_DATA['url_go_write']   .=   "/Corp_01/corp_01_modify";
//
//		$arr_VARIABLE_DATA['url_go_write']   =   "";
//		$arr_VARIABLE_DATA['url_go_write']   =   $arr_VARIABLE_DATA['siteURL'];
//		$arr_VARIABLE_DATA['url_go_write']   .=   "index.php";
//		$arr_VARIABLE_DATA['url_go_write']   .=   "/Corp_01/corp_01_delete";

*/
		$htmlFilePath         =   "widgets/dev_tools_01/Widget_db_table_01_list.html";
		return $this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);



	}//	end function


}

?>















