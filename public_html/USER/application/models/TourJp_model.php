<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TourJp_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function




	public function getTourJp_RecordCnt( $arrData )
	{
		//debug_var(simple_debug_backtrace());exit;
		//debug_var($arrData);exit;

		$arr_SQL_Result		=	null;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select(" count(*) AS RecordCount ", FALSE);
		$this->db->from( "tourJp_400_default" );

		if( isset( $arrData['sqlWhere'] ) == true )
		{
			$this->db->where( $arrData['sqlWhere'] );
		}//   end if

		$selectSQL	=	$this->db->get_compiled_select();

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



	public function getTourJp_RecordList( $arrData )
	{

		// debug_var(simple_debug_backtrace());exit;
		// debug_var($arrData);exit;

		$arr_SQL_Result		=	null;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("tourJp_400_default.*", FALSE);

		$this->db->from( "tourJp_400_default" );

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

		// debug_var($selectSQL); exit;

		$arr_SQL_Result		=	null;
		$arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);

		// debug_var($arr_SQL_Result); exit;

		//	@	Get Record DATA End
		//---------------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->stop_cache();
		$this->db->reset_query();

		return $arr_SQL_Result;

	}//   end function



	public function update_tourJp_400_default( $arrData )
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
					case "tourJp_400_pk":
						//	@	nothing
						break;
					default:
						$this->db->set( $arr_Keys1[ $loopCnt ] ,	$arrData['arr_data1'][$arr_Keys1[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for
			$this->db->where('tourJp_400_pk', $arrData['arr_data1']['tourJp_400_pk']);

			$SQL_1	=	$this->db->get_compiled_update( $arrData['tbl_name1'] );
			$this->db->query($SQL_1);

			$db_error = $this->db->error();

			if( $db_error["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result"] =   "SUCCESS";
				$rtnValue["SQL_Result_Data"]['tourJp_400_pk'] =   $arrData['arr_data1']['tourJp_400_pk'];
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





}//	end class


?>
