<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function



	public function getConfig_RecordCnt( $arrData )
	{
		$arr_SQL_Result		=	null;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select(" count(*) AS RecordCount ", FALSE);
		$this->db->from( "config_10_default");

		if( isset( $arrData['sqlWhere'] ) == true )
		{
			$this->db->where( $arrData['sqlWhere'] );
		}//   end if

		$selectSQL	=	$this->db->get_compiled_select();

		//  echo $selectSQL."<BR>";

		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);

//         	        echo "<pre>";
//         	        var_export( $arr_SQL_Result );
//         	        echo "<pre>";

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->stop_cache();
		$this->db->reset_query();

		return $arr_SQL_Result;

	}//   end function



	public function getConfig_RecordList( $arrData )
	{

		$arr_SQL_Result		=	null;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("*", FALSE);
		$this->db->from( "config_10_default" );

		if( isset( $arrData['sqlWhere'] ) == true )
		{
			$this->db->where( $arrData['sqlWhere'] );
		}//   end if

		if( ( isset( $arrData['sqlWhereIN_Field'] ) == true )&&( isset( $arrData['sqlWhereIN_Value'] ) == true ) )
		{
			$this->db->where_in($arrData['sqlWhereIN_Field'], $arrData['sqlWhereIN_Value']);
		}//   end if

		if( isset( $arrData['OrderBy'] ) == true )
		{
			$this->db->order_by( $arrData['OrderBy'] );
		}//   end if

		if( ( isset( $arrData['Limit_RecCnt'] ) == true )&&( isset( $arrData['Limit_nowPage'] ) == true ) )
		{
			$this->db->limit( $arrData['Limit_RecCnt'] , $arrData['Limit_nowPage'] );
		}//   end if

		$selectSQL	=	$this->db->get_compiled_select();

		//debug_var($selectSQL);


		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);

		// 	        echo "<pre>";
		// 	        var_export( $arr_SQL_Result );
		// 	        echo "<pre>";

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->stop_cache();
		$this->db->reset_query();

		return $arr_SQL_Result;

	}//   end function




	public function get_config_10_code($config_10_code)
	{

		//debug_var(simple_debug_backtrace());exit;

		$this->db->reset_query();
		$this->db->flush_cache();
		$this->db->start_cache();
		//	$this->db->stop_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("TB1.*" , FALSE);
		$this->db->from( "config_10_default AS TB1" );

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	검색 처리 시작
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$this->db->where( "TB1.config_10_code", $config_10_code );

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	검색 전송값 끝
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$selectSQL	=	$this->db->get_compiled_select();

		//	echo "<pre>";	echo $selectSQL;	echo "</pre>";

		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executeSQL( $selectSQL , 'array');

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------

		$this->db->stop_cache();
		$this->db->flush_cache();
		$this->db->reset_query();


		// echo array_key_exists( 0 , $arr_SQL_Result);
		// echo "<pre>";
		// var_export( $arr_SQL_Result[ 0 ] );
		// echo "</pre>";
		// echo "<br/><br/><br/><br/><br/>";


		$rtnVal	=	null;
		$rtnVal	=	$arr_SQL_Result;
		return $rtnVal;


	}





	public function insert_config_10_default( $arrData )
	{
		//debug_var(simple_debug_backtrace());exit;

		try{
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 시작
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 시작
			// real_estate_20_default
			$arr_Keys1	=	array_keys( $arrData['arr_data1'] );
			for($loopCnt=0; count($arrData['arr_data1'])>$loopCnt; $loopCnt++)
			{
				switch( $arr_Keys1[ $loopCnt ] )
				{
					case "config_10_pk":
						$this->db->set( $arr_Keys1[ $loopCnt ] ,	'null', FALSE );
						break;
//					case "member_10_pw":
//						$this->db->set( $arr_Keys1[ $loopCnt ] ,	"password('".$arrData['arr_data1'][$arr_Keys1[ $loopCnt ]]."')", FALSE );
//						break;
					default:
						$this->db->set( $arr_Keys1[ $loopCnt ] ,	$arrData['arr_data1'][$arr_Keys1[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for

			$SQL_1	=	$this->db->get_compiled_insert( $arrData['tbl_name1'] );
			//debug_var($SQL_1);

			$this->db->query($SQL_1);


			$db_error1 = $this->db->error();

			if( $db_error1["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result_Data"]['config_10_pk'] =   $this->db->insert_id();
			}else{
				throw new Exception('Database error! Error Code [' . $db_error1['code'] . '] Error: ' . $db_error1['message']);
			}// end if

			//	@	query 1 끝
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 완료
			$this->db->trans_commit();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

		}
		catch (Exception $e){
			$this->db->trans_rollback();
			log_message('error',$e->getMessage());

			$rtnValue["SQL_Result"] =   "FAIL";
			$rtnValue["SQL_Error"]  =   $e->getMessage();

		}// end try


		return $rtnValue;


	}//	end function



	public function get_config_10_pk($config_10_pk)
	{

		//debug_var(simple_debug_backtrace());exit;

		$this->db->reset_query();
		$this->db->flush_cache();
		$this->db->start_cache();
		//	$this->db->stop_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("TB1.*" , FALSE);
		$this->db->from( "config_10_default AS TB1" );

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	검색 처리 시작
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$this->db->where( "TB1.config_10_pk", $config_10_pk );

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	@	검색 전송값 끝
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$selectSQL	=	$this->db->get_compiled_select();

		//	echo "<pre>";	echo $selectSQL;	echo "</pre>";

		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executeSQL( $selectSQL , 'array');

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------

		$this->db->stop_cache();
		$this->db->flush_cache();
		$this->db->reset_query();


		// echo array_key_exists( 0 , $arr_SQL_Result);
		// echo "<pre>";
		// var_export( $arr_SQL_Result[ 0 ] );
		// echo "</pre>";
		// echo "<br/><br/><br/><br/><br/>";


		$rtnVal	=	null;
		$rtnVal	=	$arr_SQL_Result;
		return $rtnVal;


	}



	public function update_config_10_default( $arrData )
	{


		try
		{

			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 시작
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 시작

			$arr_Keys1	=	array_keys( $arrData['arr_data1'] );
			for($loopCnt=0; count($arrData['arr_data1'])>$loopCnt; $loopCnt++)
			{
				switch( $arr_Keys1[ $loopCnt ] )
				{
					case "config_10_pk":
						//	@	nothing
						break;
//					case "member_10_pw":
//						$this->db->set( $arr_Keys1[ $loopCnt ] ,	"password('".$arrData['arr_data1'][$arr_Keys1[ $loopCnt ]]."')", FALSE );
//						break;
					default:
						$this->db->set( $arr_Keys1[ $loopCnt ] ,	$arrData['arr_data1'][$arr_Keys1[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for
			$this->db->where('config_10_pk', $arrData['arr_data1']['config_10_pk']);

			$SQL_1	=	$this->db->get_compiled_update( $arrData['tbl_name1'] );
			$this->db->query($SQL_1);

			$db_error = $this->db->error();

			if( $db_error["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result"] =   "SUCCESS";
				$rtnValue["SQL_Result_Data"]['config_10_pk'] =   $arrData['arr_data1']['config_10_pk'];
			}else{
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
			}// end if

			//	@	query 1 끝
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 완료
			$this->db->trans_commit();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			log_message('error',$e->getMessage());

			$rtnValue["SQL_Result"] =   "FAIL";
			$rtnValue["SQL_Error"]  =   $e->getMessage();
		}// end try

		return $rtnValue;

	}//	end function



	public function delete_config_10_default($arrData)
	{


		try
		{

			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 시작
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 시작

			$this->db->where('config_10_pk', $arrData['arr_data1']['config_10_pk']);

			$SQL_1	=	$this->db->get_compiled_delete( $arrData['tbl_name1'] );
			$this->db->query($SQL_1);

			$db_error1 = $this->db->error();

			if ($db_error1["code"] == 0)
			{
				//  @ nothing
			}
			else
			{
				throw new Exception('Database error! Error Code [' . $db_error1['code'] . '] Error: ' . $db_error1['message']);
			}// end if

			//	@	query 1 끝
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 완료
			$this->db->trans_commit();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

			$rtnValue["SQL_Result"] =   "SUCCESS";
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			log_message('error',$e->getMessage());

			$rtnValue["SQL_Result"] =   "FAIL";
			$rtnValue["SQL_Error"]  =   $e->getMessage();
		}// end try

		return $rtnValue;


	}





	public function get_config_10_default_code( $config_10_code )
	{
		$arr_SQL_Result		=	null;

//         		    echo "<pre>";
//         		    var_export($arrData);
//         		    echo "</pre>";
//exit;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("*", FALSE);
		$this->db->from( "config_10_default");

		$this->db->where( "config_10_code", $config_10_code );

		$selectSQL	=	$this->db->get_compiled_select();

		//  echo $selectSQL."<BR>";

		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array');

		// 	        echo "<pre>";
		// 	        var_export( $arr_SQL_Result );
		// 	        echo "<pre>";

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->stop_cache();
		$this->db->reset_query();

		$rtnVal	=	null;
		if(isset($arr_SQL_Result[0])===true)
		{
			$rtnVal	=	$arr_SQL_Result[0];
		}

		return $rtnVal;

	}//	end function



}//	end class


?>
