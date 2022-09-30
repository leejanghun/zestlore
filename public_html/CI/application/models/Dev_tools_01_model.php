<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dev_tools_01_model extends CI_Model
{
    public $CI    =   null;
    public function __construct()
    {
        parent::__construct();
        $this->CI = & get_instance();

    }//	end function



    public function getDbTablesList( $arrData )
    {
        $arr_SQL_Result		=	null;

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        //---------------------------------------------------------------------------------------------
        //	@	Get Record DATA Start

//        $selectSQL	=	"SHOW TABLES FROM `[TARGET_DB_NAME]`";
//        $selectSQL	=	str_replace( "[TARGET_DB_NAME]", $this->db->database, $selectSQL );
        $selectSQL = " 
            SELECT 
                TABLE_NAME AS MY_TABLE_NAME 
            FROM 
              INFORMATION_SCHEMA.TABLES
            WHERE 
                TABLE_SCHEMA = DATABASE();                        
            ";

        $arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);

        //	@	Get Record DATA End
        //---------------------------------------------------------------------------------------------
        $this->db->flush_cache();
        $this->db->stop_cache();
        $this->db->reset_query();

        return $arr_SQL_Result;

    }//   end function

    public function getTableFieldList( $arrData )
    {
        $arr_SQL_Result		=	null;

        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        //---------------------------------------------------------------------------------------------
        //	@	Get Record DATA Start
/*
        $selectSQL	=	"SHOW TABLES FROM `[TARGET_DB_NAME]`";
        $selectSQL	=	str_replace( "[TARGET_DB_NAME]", $this->db->database, $selectSQL );

        $arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);
*/

        $arr_SQL_Result =   $this->db->list_fields($arrData['tbl_name']);

        //	@	Get Record DATA End
        //---------------------------------------------------------------------------------------------
        $this->db->flush_cache();
        $this->db->stop_cache();
        $this->db->reset_query();

        return $arr_SQL_Result;

    }//   end function




/*
    public function getCorp_01_RecordCnt( $arrData )
    {
        $arr_SQL_Result		=	null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        //---------------------------------------------------------------------------------------------
        //	@	Get Record DATA Start

        $this->db->select(" count(*) AS RecordCount ", FALSE);
        $this->db->from( "corp_01_default");

        if( isset( $arrData['sqlWhere'] ) == true )
        {
            $this->db->where( $arrData['sqlWhere'] );
        }//   end if

        $selectSQL	=	$this->db->get_compiled_select();

//        echo $selectSQL."<BR>";

        $arr_SQL_Result		=	null;
        $arr_SQL_Result		=	$this->common_model->executesql( $selectSQL , 'array', $this->db);

//        echo "<pre>";
//        var_export( $arr_SQL_Result );
//        echo "<pre>";

        //	@	Get Record DATA End
        //---------------------------------------------------------------------------------------------
        $this->db->flush_cache();
        $this->db->stop_cache();
        $this->db->reset_query();

        return $arr_SQL_Result;

    }//   end function





    public function insert_corp_01( $arrData ):array
    {
        $rtnValue   =   null;
        $rtnValue   =   array();
        $rtnValue["SQL_Result"] =   "FAIL";

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
                $rtnValue["SQL_Result_Data"]['pk'] =   $this->db->insert_id();
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

            $rtnValue["SQL_Result"] =   "SUCCESS";

        } catch (Exception $e){
            $this->db->trans_rollback();
            log_message('error',$e->getMessage());

            $rtnValue["SQL_Result"] =   "FAIL";
            $rtnValue["SQL_Error"]  =   $e->getMessage();

        }// end try

        return $rtnValue;

    }//	end function

    public function update_corp_01( $arrData )
    {
        $rtnValue   =   null;
        $rtnValue   =   array();
        $rtnValue["SQL_Result"] =   "FAIL";

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
                    default:
                        $this->db->set( $arr_Keys[ $loopCnt ] ,	$arrData['arr_data'][$arr_Keys[ $loopCnt ]], TRUE );
                }//	end switch
            }//	end for
            $this->db->where('corp01_pk', $arrData['arr_data']['corp01_pk']);

            $SQL_1	=	$this->db->get_compiled_update( $arrData['tbl_name'] );
            $this->db->query($SQL_1);

            $db_error = $this->db->error();

            if( $db_error["code"] == 0 )
            {
                //  @ nothing
                $rtnValue["SQL_Result_Data"]['pk'] =   $arrData['arr_data']['corp01_pk'];
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

            $rtnValue["SQL_Result"] =   "SUCCESS";

        } catch (Exception $e){
            $this->db->trans_rollback();
            log_message('error',$e->getMessage());

            $rtnValue["SQL_Result"] =   "FAIL";
            $rtnValue["SQL_Error"]  =   $e->getMessage();

        }// end try

        return $rtnValue;

    }//	end function

    public function delete_corp_01( $arrData )
    {
        $rtnValue   =   null;
        $rtnValue   =   array();
        $rtnValue["SQL_Result"] =   "FAIL";

        try{
            ///////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////
            //	@	트랜잭션 시작
            $this->db->trans_begin();
            ///////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////

            ///////////////////////////////////////////////////////////////////////////
            //	@	query 1 시작

            $this->db->where('corp01_pk', $arrData['arr_data']['corp01_pk']);
            $SQL_1	=	$this->db->get_compiled_delete( $arrData['tbl_name'] );

            $this->db->query($SQL_1);

            $db_error = $this->db->error();

            if( $db_error["code"] == 0 )
            {
                //  @ nothing
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

            $rtnValue["SQL_Result"] =   "SUCCESS";

        } catch (Exception $e){
            $this->db->trans_rollback();
            log_message('error',$e->getMessage());

            $rtnValue["SQL_Result"] =   "FAIL";
            $rtnValue["SQL_Error"]  =   $e->getMessage();


        }// end try

        return $rtnValue;

    }//	end function

/**/

}//	end class

?>