<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TourEn_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}//	end function



	public function insert_tourEn_300_default( $arrData )
	{


		try{
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	트랜잭션 시작
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 시작
			$arr_Keys	=	array_keys( $arrData['arr_data'] );
			for($loopCnt=0; count($arrData['arr_data'])>$loopCnt; $loopCnt++)
			{
				switch( $arr_Keys[ $loopCnt ] )
				{
					case "tourEn_300_pk":
						$this->db->set( $arr_Keys[ $loopCnt ] ,	'null', FALSE );
						break;

					default:
						$this->db->set( $arr_Keys[ $loopCnt ] ,	$arrData['arr_data'][$arr_Keys[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for

			$SQL_1	=	$this->db->get_compiled_insert( $arrData['tbl_name'] );

			//debug_var($SQL_1);exit;

			$this->db->query($SQL_1);

			$db_error = $this->db->error();

			if( $db_error["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result_Data"]['tourEn_300_pk'] =   $this->db->insert_id();
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
		catch (Exception $e){
			$this->db->trans_rollback();
			log_message('error',$e->getMessage());

			$rtnValue["SQL_Result"] =   "FAIL";
			$rtnValue["SQL_Error"]  =   $e->getMessage();

		}// end try





		return $rtnValue;


	}//	end function





}//	end class


?>
