<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospital_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function




	public function getHospital_RecordCnt( $arrData )
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
		$this->db->from( "hospital_100_default" );

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





	public function getHospital_RecordList( $arrData )
	{

		// debug_var(simple_debug_backtrace());exit;
		// debug_var($arrData);exit;

		$arr_SQL_Result		=	null;

		$this->db->flush_cache();
		$this->db->reset_query();
		$this->db->start_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$this->db->select("hospital_100_default.*", FALSE);

		$this->db->from( "hospital_100_default" );

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

		//debug_var($selectSQL); exit;

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






}//	end class


?>
