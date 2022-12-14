<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }//	end function

    // $arrData['tbl_name']	=	'admin_00_info_default';
    // $arrData['arr_data']

    //////////////////////////////////////////////////////////////////////////////////////////
    //	@	start admin_00_default
    //////////////////////////////////////////////////////////////////////////////////////////



    public function getAdmin_RecordCnt( $arrData )
    {
        $arr_SQL_Result		=	null;

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        //---------------------------------------------------------------------------------------------
        //	@	Get Record DATA Start

        $this->db->select(" count(*) AS RecordCount ", FALSE);
        $this->db->from( "admin_00_default");

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



    public function getAdmin_RecordList( $arrData )
    {
        $arr_SQL_Result		=	null;

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        //---------------------------------------------------------------------------------------------
        //	@	Get Record DATA Start

        $this->db->select("*", FALSE);
        $this->db->from( "admin_00_default" );

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

        if( ( isset( $arrData['Limit_RecCnt'] ) == true )&&( isset( $arrData['Limit_newPage'] ) == true ) )
        {
            $this->db->limit( $arrData['Limit_RecCnt'] , $arrData['Limit_newPage'] );
        }//   end if

        $selectSQL	=	$this->db->get_compiled_select();

        //  echo $selectSQL;

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



    public function insert_admin_member_00( $arrData )
    {
/*		echo __CLASS__;
		echo "\n";
		echo __FUNCTION__;
		echo "\n";
		echo __LINE__;
		echo "\n";
		var_export($arrData);
		exit;*/

		try{
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	???????????? ??????
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////

			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 ??????
			$arr_Keys	=	array_keys( $arrData['arr_data'] );
			for($loopCnt=0; count($arrData['arr_data'])>$loopCnt; $loopCnt++)
			{
				switch( $arr_Keys[ $loopCnt ] )
				{
					case "admin_00_pk":
						$this->db->set( $arr_Keys[ $loopCnt ] ,	'null', FALSE );
						break;
					case "admin_00_pw":
						//$this->db->set( $arr_Keys[ $loopCnt ] ,	"password('".$arrData['arr_data'][$arr_Keys[ $loopCnt ]]."')", FALSE );
						$this->db->set( $arr_Keys[ $loopCnt ] ,	"sha2('".$arrData['arr_data'][$arr_Keys[ $loopCnt ]]."',256)", FALSE );
						break;
					default:
						$this->db->set( $arr_Keys[ $loopCnt ] ,	$arrData['arr_data'][$arr_Keys[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for

			$SQL_1	=	$this->db->get_compiled_insert( $arrData['tbl_name'] );
			$this->db->query($SQL_1);

			$db_error = $this->db->error();

			if( $db_error["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result_Data"]['admin_00_pk'] =   $this->db->insert_id();
			}else{
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
			}// end if

			//	@	query 1 ???
			///////////////////////////////////////////////////////////////////////////

			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	???????????? ??????
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



    public function update_admin_member_00( $arrData )
    {


		try
		{

			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	???????????? ??????
			$this->db->trans_begin();
			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			//	@	query 1 ??????

			$arr_Keys	=	array_keys( $arrData['arr_data'] );
			for($loopCnt=0; count($arrData['arr_data'])>$loopCnt; $loopCnt++)
			{
				switch( $arr_Keys[ $loopCnt ] )
				{
					case "admin_00_pk":

						//	@	nothing

						break;
					case "admin_00_pw":

						if( $arrData['arr_data']['admin_00_pw'] == "**********" )
						{
							//	@	nothing
						}else{
							//$this->db->set( $arr_Keys[ $loopCnt ] ,	"password('".$arrData['arr_data'][$arr_Keys[ $loopCnt ]]."')", FALSE );
							$this->db->set( $arr_Keys[ $loopCnt ] ,	"sha2('".$arrData['arr_data'][$arr_Keys[ $loopCnt ]]."',256)", FALSE );
						}//	end if

						break;
					default:
						$this->db->set( $arr_Keys[ $loopCnt ] ,	$arrData['arr_data'][$arr_Keys[ $loopCnt ]], TRUE );
				}//	end switch
			}//	end for
			$this->db->where('admin_00_pk', $arrData['arr_data']['admin_00_pk']);

			$SQL_1	=	$this->db->get_compiled_update( $arrData['tbl_name'] );
			$this->db->query($SQL_1);

			$db_error = $this->db->error();

			if( $db_error["code"] == 0 )
			{
				//  @ nothing
				$rtnValue["SQL_Result_Data"]['admin_00_pk'] =   $arrData['arr_data']['admin_00_pk'];
			}else{
				throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
			}// end if

			//	@	query 1 ???
			///////////////////////////////////////////////////////////////////////////


			///////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////
			//	@	???????????? ??????
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



	public function delete_admin_member_00($arrData)
	{
		///////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////
		//	@	???????????? ??????
		$this->db->trans_begin();
		///////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////
		//	@	query 1 ??????

		$this->db->where('admin_00_pk', $arrData['arr_data']['admin_00_pk']);

		$SQL_1	=	$this->db->get_compiled_delete( $arrData['tbl_name'] );

		//debug_var($SQL_1);exit;

		$this->db->query($SQL_1);

		//	@	query 1 ???
		///////////////////////////////////////////////////////////////////////////

		///////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////
		//	@	???????????? ??????
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}//	end if
		///////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////

		return $this->db->trans_status();
	}


    //////////////////////////////////////////////////////////////////////////////////////////
    //	@	end member_admin_01
    //////////////////////////////////////////////////////////////////////////////////////////


}//	end class


?>
