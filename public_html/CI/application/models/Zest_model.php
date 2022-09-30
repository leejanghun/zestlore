<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zest_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function

	public function get_enum_field_var($arrData)
	{

		$this->db->reset_query();
		$this->db->flush_cache();
		$this->db->start_cache();
		//	$this->CI->db->stop_cache();
		//---------------------------------------------------------------------------------------------
		//	@	Get Record DATA Start

		$selectSQL = "SHOW COLUMNS FROM ".$arrData['table_name']." LIKE '".$arrData['field_name']."'";

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
		$rtnVal	=	$arr_SQL_Result[0];
		return $rtnVal;

	}



}//	end class


?>
