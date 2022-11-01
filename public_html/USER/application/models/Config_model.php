<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function




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
