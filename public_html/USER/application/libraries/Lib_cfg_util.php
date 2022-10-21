<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_cfg_util {

	public function __construct()
	{
	    $this->CI =& get_instance();

	    $this->CI->load->library('encryption');
	}//	end function


    public static function output_jsonString( string $str_json )
    {
        header('Content-type: application/json');
        echo( $str_json );
    }// end private function check_is_login()

/*
    public function check_auth( array $arr_agr ):array
    {
        $arrRtnValue                 =   array();
        $arrRtnValue["Result"]       =   "deny";

//        echo "<pre>";
//        var_export( $arr_agr );
//        echo "</pre>";

        if ( $arrRtnValue["Result"] === "deny" )
        {
            if( in_array(  $arr_agr['segments'][1], $arr_agr['exception_func'] ) === true )
            {
                $arrRtnValue["Result"] = "allow";
            }// end if
        }// end if

        if ( $arrRtnValue["Result"] === "deny" )
        {
//            echo "<pre>";
//            var_export( $this->CI->load->model('Actor_01_access_auth_model') );
//            echo "</pre>";

            $str_segments   =   "";
            if( is_null( $arr_agr['segments'][0] ) === false )
            {
                $str_segments   .=   "/".$arr_agr['segments'][0];
            }// end if

            if( is_null( $arr_agr['segments'][1] ) === false )
            {
                $str_segments   .=   "/".$arr_agr['segments'][1];
            }// end if

            $arrData              =   null;
            $arrData['sqlWhere']  =   " actor_01_accessAuth.fk_a01_pk='".$arr_agr['a01_pk']."'";
            $arrData['sqlWhere']  .=  " AND system_cfg_01_auth.sc01_routeUrl='".$str_segments."'";

            $arr_SQL_Result       =   null;
            $arr_SQL_Result       =   $this->CI->Actor_01_access_auth_model->getA01_authRecordList($arrData);

            if( count($arr_SQL_Result) === 1 )
            {
                if( $arr_SQL_Result[0]['a01_auth_allowYN'] === "Y" )
                {
                    $arrRtnValue["Result"] = "allow";
                }// end if
            }// end if

        }// end if

        if( $arrRtnValue["Result"] === "deny" )
        {
            if( $arr_agr['a01_id'] === "root" )
            {
                $arrRtnValue["Result"] = "allow";
            }// end if
        }// end if

        return $arrRtnValue;

    }// end private function check_is_login()
*/

    //  @   Array index 존재 여부만 검사
    public function check_parameter( $arr_target_index, $arr_target_params ):array
	{
	    $arrRtnValue                 =   array();
	    $arrRtnValue["Result"]       =   "FAIL";
	    $arrRtnValue["ResultMsg"]    =   "UNKNOWN_ERROR";
//	    $arrRtnValue["ExecClass"]    =   get_class($this);
//	    $arrRtnValue["ExecFunction"] =   __FUNCTION__;

	    $cnt_success   =   0;
	    for($loopCnt=0; count($arr_target_index)>$loopCnt; $loopCnt++)
	    {
	        if( array_key_exists($arr_target_index[$loopCnt], $arr_target_params) == true )
	        {
                $cnt_success   =   $cnt_success + 1;
	        }else{
	            $arrRtnValue["ResultMsg"]   =   "ERROR_NO_PARAMETER : ".$arr_target_index[$loopCnt];
	        }//    end if
	    }//   end for

	    if( count($arr_target_index) == $cnt_success )
	    {
	        $arrRtnValue["Result"]      =   "SUCCESS";
	        $arrRtnValue["ResultMsg"]   =   "SUCCESS";
	    }//    end if

	    return $arrRtnValue;

	}//   end if

    public function createAuthTokenString($agr_prefix):string
    {
        return hash("sha256", uniqid($agr_prefix), false);
    }// end function



/*
	public function get_personal_encrypt_encode_key($params):string
	{
	    $arrRtnValue =   array();
	    $arrRtnValue["Result"]         =   "FAIL";
	    $arrRtnValue["ResultMsg"]      =   "UNKNOWN_ERROR";
	    $arrRtnValue["ResultData"]     =   "NULL";
	    $arrRtnValue["ExecClass"]      =   get_class($this);
	    $arrRtnValue["ExecFunction"]   =   __FUNCTION__;

	    $goNextStep    =   "STEP1";

	    if( $goNextStep == "STEP1" )
	    {
	        $arr_check_result  =   $this->check_parameter( array('user_01_pk','user_01_id'), $params );

	        if( $arr_check_result['Result'] == "SUCCESS" )
	        {
	            $goNextStep    =   "STEP2";
	        }else{

	            $goNextStep    =   "ERROR_PROCESS_END";
	            $arrRtnValue   =   $arr_check_result;
	        }//    end if
	    }//    end

	    if( $goNextStep == "STEP2" )
	    {
	        $key   =   hash("sha256", $params['user_01_id']);

	        if( ( $params['user_01_pk'] % 2 ) == 0 )
	        {
	            $key           =   substr( $key , 0 , 32 );
	        }//    end if

	        if( ( $params['user_01_pk'] % 2 ) == 1 )
	        {
	            $key           =   substr( $key , 32 , 64 );
	        }//    end if

	        $arrRtnValue["Result"]      =   "SUCCESS";
	        $arrRtnValue["ResultMsg"]   =   "SUCCESS";
	        $arrRtnValue["ResultData"]  =   array("key" => $key);
	    }//    end if


	    return json_encode( $arrRtnValue );
	}//    end function


	// E-mail 인증을 위한 암호화된 코드값 생성
	public function get_email_confirm_code_encode($params)
	{
	    $arrRtnValue =   array();
	    $arrRtnValue["Result"]         =   "FAIL";
	    $arrRtnValue["ResultMsg"]      =   "UNKNOWN_ERROR";
	    $arrRtnValue["ResultData"]     =   "NULL";
	    $arrRtnValue["ExecClass"]      =   get_class($this);
	    $arrRtnValue["ExecFunction"]   =   __FUNCTION__;

	    $goNextStep    =   "STEP1";
	    if( $goNextStep == "STEP1" )
	    {
	        $arr_check_result  =   $this->check_parameter( array('user_01_pk','user_01_id'), $params );

	        if( $arr_check_result['Result'] == "SUCCESS" )
	        {
	            $goNextStep    =   "STEP2";
	        }else{
	            $goNextStep    =   "ERROR_PROCESS_END";
	            $arrRtnValue   =   $arr_check_result;
	        }//    end if
	    }//    end


	    if( $goNextStep == "STEP2" )
	    {
	        $arr_encode_key_result   =   json_decode( $this->get_personal_encrypt_encode_key($params), true );

	        if( $arr_encode_key_result['Result'] == "SUCCESS" )
	        {
	            $encryp_key     =   $arr_encode_key_result['ResultData']['key'];

	            $this->CI->encryption->initialize(
	                array(
	                    'cipher'    =>  'aes-256'
	                    ,'mode'     => 'ctr'
	                    ,'key'      => $encryp_key
	                )
	                );

	            $json_params   =   json_encode( $params );
	            $encode_str    =   $this->CI->encryption->encrypt( $json_params );

	            $arrRtnValue["Result"]      =   "SUCCESS";
	            $arrRtnValue["ResultMsg"]   =   "SUCCESS";
	            $arrRtnValue["ResultData"]  =   array("encode_str" => $encode_str);
	        }else{
	            $arrRtnValue    =   $arr_encode_key_result;
	        }// end if

	    }//    end if

        return json_encode( $arrRtnValue );

	}//    end function



	// E-mail 인증을 위한 코드전송값 복호화
	public function get_email_confirm_code_decode($params, $encode_str):string
	{
	    $arrRtnValue =   array();
	    $arrRtnValue["Result"]         =   "FAIL";
	    $arrRtnValue["ResultMsg"]      =   "UNKNOWN_ERROR";
	    $arrRtnValue["ResultData"]     =   "NULL";
	    $arrRtnValue["ExecClass"]      =   get_class($this);
	    $arrRtnValue["ExecFunction"]   =   __FUNCTION__;

	    $goNextStep    =   "STEP1";
	    if( $goNextStep == "STEP1" )
	    {
	        $arr_check_result  =   $this->check_parameter( array('user_01_pk','user_01_id'), $params );

	        if( $arr_check_result['Result'] == "SUCCESS" )
	        {
	            $goNextStep    =   "STEP2";
	        }else{
	            $goNextStep    =   "ERROR_PROCESS_END";
	            $arrRtnValue   =   $arr_check_result;
	        }//    end if
	    }//    end


	    if( $goNextStep == "STEP2" )
	    {
	        $arr_encode_key_result   =   json_decode( $this->get_personal_encrypt_encode_key($params), true );

	        if( $arr_encode_key_result['Result'] == "SUCCESS" )
	        {
	            $encryp_key     =   $arr_encode_key_result['ResultData']['key'];

	            $this->CI->encryption->initialize(
	                array(
	                    'cipher'    => 'aes-256'
	                    ,'mode'     => 'ctr'
	                    ,'key'      => $encryp_key
	                )
	                );

	            $decode_str        =   $this->CI->encryption->decrypt( $encode_str );

	            $arr_decode_str    =   json_decode( $decode_str );

	            $arrRtnValue["Result"]      =   "SUCCESS";
	            $arrRtnValue["ResultMsg"]   =   "SUCCESS";
	            $arrRtnValue["ResultData"]  =   array("decode_str" => $arr_decode_str);
	        }else{
	            $arrRtnValue    =   $arr_encode_key_result;
	        }// end if

	    }//    end if

	    return json_encode( $arrRtnValue );

	}//    end function

/**/




/*
	public function error_report_to_slack($json_rtnString)
	{
	    $this->slack_token     =   "xoxb-292345152407-712255877009-sFN7KFWnxPqmw5xRAOlMy4sI";
	    $this->slack_username  =   "@TEST_BOT";
	    $this->slack_channel   =   "#auto_report";
	    $this->error_message   =   "ERROR_REPORT_".date("Y-m-d H:i:s");
	    $this->error_message   .=   "\n\n";
	    $this->error_message   .=   $json_rtnString;

	    $postData  = array(
	        'token'    => $this->slack_token,
	        'channel'  => $channel,
	        'username' => $this->username,
	        'text'     => $this->message
	    );

        $ch   = curl_init("https://slack.com/api/chat.postMessage");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS,     $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $result = curl_exec($ch);

                curl_close($ch);

        return $result;

	}///   end function
*/






















	// 가상인물에 대한 아이디 비밀번호 생성을 위한 문자열 리턴 함수
	public function get_temp_string_id_pw()
	{
	    return uniqid("uunio_id_".time()."_");
	}//    end function


}//	end class


?>
