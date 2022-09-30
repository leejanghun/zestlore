<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_db_table_01_detail extends Widget {


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
	                    exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
	            }//	end switch

	        }//	end if
	    }//	end for



	    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$arr_VARIABLE_DATA['tblName']	=	$this->CI->input->get_post('table_name');

		$arrData              	=   null;
		$arrData['tbl_name']	=   $arr_VARIABLE_DATA['tblName'];
		$arr_SQL_Result			=   $this->CI->Dev_tools_01_model->getTableFieldList($arrData);

		$table_arr = $this->tbl_name_arr($arrData['tbl_name']); // 테이블명 변형

		//debug_var($table_arr);


//		echo "<pre>";
//		var_export( $arr_SQL_Result );
//		echo "</pre>";

		$base_field 					=   "";
		$phpCode_arr_VARIABLE_DATA		=	"";
		$phpCode_this_input_get_post	=	"";
		$phpCode_this_input_get_post2	=	"";
		$phpCode_this_input_get_post3_1	=	"";
		$phpCode_this_input_get_post3_2	=	"";
		$phpCode_this_input_get_post4_1	=	"";
		$phpCode_this_input_get_post4_2	=	"";
		$phpCode_this_input_get_post4_3	=	"";
		$phpCode_this_input_get_post4_4	=	"";
		$phpCode_db_arr_data			=	"";
		$phpCode_db_arr_data_view		=	"";
		$phpCode_db_arr_data_view2		=	"";
		$jsCode_get_ajax_params			=	"";
		$jsCode_get_ajax_params_radio	=	"";
		$jsCode_set_ajax_params			=	"";
		$comma							=	"";
		$phpCase						=	"";
		$ci_sql_select					=	"";


		for($loopCnt=0; count($arr_SQL_Result)>$loopCnt; $loopCnt++)
		{

			$base_field			.=	$arr_SQL_Result[$loopCnt].'</BR>';

			$phpCode_arr_VARIABLE_DATA		.=	'$arr_VARIABLE_DATA[\''.$arr_SQL_Result[$loopCnt].'\']    =    "";</br>';

			$phpCode_this_input_get_post	.=	'$'.$arr_SQL_Result[$loopCnt].'	=	$this->input->get_post(\''.$arr_SQL_Result[$loopCnt].'\');</br>';

			$phpCode_this_input_get_post2	.=	'$arrData[\'arr_data\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$this->input->get_post(\''.$arr_SQL_Result[$loopCnt].'\');</br>';

			$phpCode_this_input_get_post3_1	.=	'$arrData[\'arr_data1\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$this->input->get_post(\''.$arr_SQL_Result[$loopCnt].'\');</br>';
			$phpCode_this_input_get_post3_2	.=	'$arrData[\'arr_data2\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$this->input->get_post(\''.$arr_SQL_Result[$loopCnt].'\');</br>';

			$phpCode_this_input_get_post4_1	.=	'$arrDBdata[\''.$arr_SQL_Result[$loopCnt].'\']	=	$this->input->get_post(\''.$arr_SQL_Result[$loopCnt].'\');</br>';
			$phpCode_this_input_get_post4_2	.=	'$arrData[\'arr_data1\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$arrDBdata[\''.$arr_SQL_Result[$loopCnt].'\'];</br>';
			$phpCode_this_input_get_post4_3	.=	'$arrData[\'arr_data2\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$arrDBdata[\''.$arr_SQL_Result[$loopCnt].'\'];</br>';
			$phpCode_this_input_get_post4_4	.=	'$arrData[\'arr_data3\'][\''.$arr_SQL_Result[$loopCnt].'\']	=	$arrDBdata[\''.$arr_SQL_Result[$loopCnt].'\'];</br>';

			$phpCase	.=	'case "'.$arr_SQL_Result[$loopCnt].'":</BR>';
			$ci_sql_select	.=	'$this->db->select("'.$arrData['tbl_name'].'.'.$arr_SQL_Result[$loopCnt].'", FALSE);</BR>';

			if($loopCnt === 0)
			{
				$comma	=	"";
			}else{
				$comma	=	",";
			}//	end if

			$phpCode_db_arr_data			.=	$comma.'\''.$arr_SQL_Result[$loopCnt].'\' =>$'.$arr_SQL_Result[$loopCnt].'</br>';
			$phpCode_db_arr_data_view		.=	'$arr_VARIABLE_DATA[\''.$arr_SQL_Result[$loopCnt].'\']	=	$arr_'.$table_arr['view'].'[\''.$arr_SQL_Result[$loopCnt].'\'] ;</br>';
											// 		$arr_VARIABLE_DATA['employee_20_pk'] = $arr_employee_20['employee_20_pk'];

			$phpCode_db_arr_data_view2		.=	'$arr_VARIABLE_DATA[\''.$arr_SQL_Result[$loopCnt].'\']	=	$arr_'.$table_arr['base'].'[\''.$arr_SQL_Result[$loopCnt].'\'] ;</br>';
			// 		$arr_VARIABLE_DATA['employee_20_pk'] = $arr_employee_20['employee_20_pk'];

			$jsCode_get_ajax_params			.=	'let '.$arr_SQL_Result[$loopCnt].'= jQuery(\'#'.$arr_SQL_Result[$loopCnt].'\').val();</BR>';
			$jsCode_get_ajax_params_radio	.=	'let '.$arr_SQL_Result[$loopCnt].'= jQuery("input[name=\''.$arr_SQL_Result[$loopCnt].'\']:checked").val(); // 라디오값;</BR>';
																				//jQuery("input[name='re_20_status']:checked").val(); // 라디오값

			$jsCode_set_ajax_params			.=	$comma.$arr_SQL_Result[$loopCnt].':'.$arr_SQL_Result[$loopCnt].'</BR>';


		}//	end for

		$arr_VARIABLE_DATA['base_field']		=	$base_field;
		$arr_VARIABLE_DATA['phpCode_arr_VARIABLE_DATA']		=	$phpCode_arr_VARIABLE_DATA;

		$arr_VARIABLE_DATA['phpCode_this_input_get_post']	=	$phpCode_this_input_get_post;

		$arr_VARIABLE_DATA['phpCode_this_input_get_post2']	=	$phpCode_this_input_get_post2;

		$arr_VARIABLE_DATA['phpCode_this_input_get_post3_1']	=	$phpCode_this_input_get_post3_1;
		$arr_VARIABLE_DATA['phpCode_this_input_get_post3_2']	=	$phpCode_this_input_get_post3_2;

		$arr_VARIABLE_DATA['phpCode_this_input_get_post4_1']	=	$phpCode_this_input_get_post4_1;
		$arr_VARIABLE_DATA['phpCode_this_input_get_post4_2']	=	$phpCode_this_input_get_post4_2;
		$arr_VARIABLE_DATA['phpCode_this_input_get_post4_3']	=	$phpCode_this_input_get_post4_3;
		$arr_VARIABLE_DATA['phpCode_this_input_get_post4_4']	=	$phpCode_this_input_get_post4_4;

		$arr_VARIABLE_DATA['phpCode_db_arr_data']			=	'array(</br>'.$phpCode_db_arr_data.');</br>';
		$arr_VARIABLE_DATA['phpCode_db_arr_data_view']			=	$phpCode_db_arr_data_view;
		$arr_VARIABLE_DATA['phpCode_db_arr_data_view2']			=	$phpCode_db_arr_data_view2;
		$arr_VARIABLE_DATA['jsCode_get_ajax_params']		=	$jsCode_get_ajax_params;
		$arr_VARIABLE_DATA['jsCode_get_ajax_params_radio']		=	$jsCode_get_ajax_params_radio;
		$arr_VARIABLE_DATA['jsCode_set_ajax_params']		=	$jsCode_set_ajax_params;
		$arr_VARIABLE_DATA['phpCase']		=	$phpCase;
		$arr_VARIABLE_DATA['ci_sql_select']		=	$ci_sql_select;





/*
		$arrData              =   null;
		$arrData['sqlWhere']  =   array('corp01_pk' =>  $arr_VARIABLE_DATA['corp01_pk']);

		$arr_SQL_Result       =   null;
		$arr_SQL_Result       =   $this->CI->Corp_01_model->getCorp_01_RecordList($arrData);

		$arrKeys              =   array_keys($arr_SQL_Result[0]);
		for($loopCnt1=0; count($arrKeys)>$loopCnt1; $loopCnt1++ )
		{
		    $arr_VARIABLE_DATA[ $arrKeys[$loopCnt1] ] =   $arr_SQL_Result[0][ $arrKeys[$loopCnt1] ];

		}//   end for

		$arr_VARIABLE_DATA['url_go_add_employee']   =   "";
		$arr_VARIABLE_DATA['url_go_add_employee']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_add_employee']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_add_employee']   .=   "/Actor_02/actor_02_write";
		$arr_VARIABLE_DATA['url_go_add_employee']   .=   "?corp01_pk=".$arr_VARIABLE_DATA['corp01_pk'];

		$arr_VARIABLE_DATA['url_go_list']   =   "";
		$arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_list']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_list']   .=   "/Corp_01/corp_01_list";

		$arr_VARIABLE_DATA['url_go_modify']   =   "";
		$arr_VARIABLE_DATA['url_go_modify']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_modify']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_modify']   .=   "/Corp_01/corp_01_modify";
		$arr_VARIABLE_DATA['url_go_modify']   .=   "/corp01_pk/".$arr_VARIABLE_DATA['corp01_pk'];

		$arr_VARIABLE_DATA['url_go_delete']   =   "";
		$arr_VARIABLE_DATA['url_go_delete']   =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['url_go_delete']   .=   "index.php";
		$arr_VARIABLE_DATA['url_go_delete']   .=   "/Corp_01/corp_01_del";
*/
		$htmlFilePath         =   "widgets/dev_tools_01/Widget_db_table_01_detail.html";
		return $this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);

	}//	end function



	private function tbl_name_arr($tbl_name)
	{
		$tbl_arr = array();

		$exp_arr = explode("_",$tbl_name);

		$tbl_arr['base'] = $tbl_name;
		$tbl_arr['view'] = str_replace('_'.end($exp_arr) ,'',$tbl_name);;
		//$tbl_arr['view2'] = $tbl_name;

		return $tbl_arr;
	}


}

?>















