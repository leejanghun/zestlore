<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Zest_common {

	private $_ENC_KEY = '';
	private $_ENC_KEY_256 = "";
	private $_ENC_KEY_128 = "";
	private $method = "AES-256-CBC";

	public function __construct()
	{
		$this->CI = & get_instance();

		$dbconfig_file = $this->get_db_config();
		$cfg_server_db1_connect_info	=	$dbconfig_file;

		$config	=	json_decode( read_file( $cfg_server_db1_connect_info ) , true );
		$this->CI->load->database($config);

	}//	end function


	public function get_db_config()
	{

		$server_uname = $this->get_server_uname();

		switch ($server_uname['server_nick'])
		{
			// aws 운영서버
			case "aws_operation":
				$return = "/home/zestlore/infofile/cfg_server_db1_connect_info_aws.json";
				break;
		}

		return $return;
	}


	// db에서 enum 타입의 필드 val 설정을 가져와서 checked 가능한 배열 만듬.
	// 테이블명 , 필드명 , checked 값
	public function enum_field_checked($table_name,$field_name,$checked_val)
	{

		///////////////////////////////////////////////////////
		/// @ db에서 필드 타입을 가져옴
		$this->CI->load->model("Zest_model");

		$selectData['table_name'] = $table_name;
		$selectData['field_name'] = $field_name;
		$row_enum = $this->CI->Zest_model->get_enum_field_var($selectData);

		/// @ db에서 필드 타입을 가져옴
		///////////////////////////////////////////////////////

		$val_enum = substr($row_enum['Type'],5,-1);
		eval("\$arr_enum = array(".$val_enum.");");

		$cnt = count($arr_enum);

		for($i=0;$i<$cnt;$i++)
		{
			$checked['checked_'.$row_enum['Field'].'_'.$arr_enum[$i]] = "";
		}

		if($checked_val)
		{
			$checked['checked_'.$row_enum['Field'].'_'.$checked_val] = "checked";
		}

		return $checked;
	}



	// 구글 지오코드 url
	public function google_geo_url()
	{
		$geocoding_url = "https://maps.googleapis.com/maps/api/geocode/json";
		return $geocoding_url;
	}


	public function curl_get($url,$send_data){

		$url = $url.'?'.http_build_query($send_data, '', '&');
		// curl start -----------------
		$ch = curl_init(); //curl 초기화
		curl_setopt($ch, CURLOPT_URL, $url);					//URL 지정하기
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//요청 결과를 문자열로 반환
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  //connection timeout 10초
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//원격 서버의 인증서가 유효한지 검사 안함
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data);     //POST data
		curl_setopt($ch, CURLOPT_POST, false);           //true시 post 전송
		$response = curl_exec($ch);
		$buffer = ob_get_contents();
		ob_end_clean();
		if (!$buffer) {
			$returnVal = "Curl Fetch Error : ".curl_error($ch);
			//debug_var("error");
		}else{
			$returnVal = $buffer;
			//debug_var("sessucess");
		}

		curl_close($ch);
		// curl end -----------------

		$response_arr = json_decode($response,true);

		return $response_arr;

	}


	// smtp 발송시 보내는 메일
	public function get_smtp_from_mail(){

		$smtp_from_mail = "";
		//$smtp_from_mail = "ljh@theboms.co.kr";
		//$smtp_from_mail = "info@theboms.co.kr"; // 다른계정으로 하려면 해당계정의 smtp 설정 필요함.
		return $smtp_from_mail;

	}

	public function get_smtp_confilg()
	{
		// 메일 기본 설정
		$smtp_confilg['useragent'] = 'SENDER';
		$smtp_confilg['protocol'] = 'smtp';
		$smtp_confilg['smtp_host'] = 'ssl://smtp.worksmobile.com';
		$smtp_confilg['smtp_user'] = '';
		$smtp_confilg['smtp_pass'] = '';
		$smtp_confilg['smtp_port'] = 465;
		$smtp_confilg['smtp_timeout'] = 5;
		$smtp_confilg['wordwrap'] = TRUE;
		$smtp_confilg['wrapchars'] = 76;
		$smtp_confilg['mailtype'] = 'html';
		$smtp_confilg['charset'] = 'utf-8';
		$smtp_confilg['validate'] = FALSE;
		$smtp_confilg['priority'] = 3;
		$smtp_confilg['crlf'] = "\r\n";
		$smtp_confilg['newline'] = "\r\n";
		$smtp_confilg['bcc_batch_mode'] = FALSE;
		$smtp_confilg['bcc_batch_size'] = 200;

		return $smtp_confilg;
	}


	// 메일 내용 전달 url
	public function get_smtp_server_url(){

		$arrTemp = parse_url(base_url());

		$rtnValue	=	$arrTemp['scheme']."://";
		$domain = $arrTemp['scheme'];

		switch ($arrTemp['host'])
		{
			// 개인pc vmware
			case "usareal.ljh.co.kr":
				$rtnValue	.=	"127.0.0.1";
				break;
			default: // 운영
				$rtnValue	.=	$arrTemp['host'];
				break;
		}
		return $rtnValue;
	}




	public function get_server_uname()
	{

		$host_server_name = trim(shell_exec("uname -a"));

		// debug_var($host_server_name);

		$return = array();

		$return['uname'] = $host_server_name;

		switch ($host_server_name)
		{

			case "Linux ip-172-31-8-78.ap-northeast-2.compute.internal 3.10.0-1160.76.1.el7.x86_64 #1 SMP Wed Aug 10 16:21:17 UTC 2022 x86_64 x86_64 x86_64 GNU/Linux":
				// aws
				$return['server_nick'] = "aws_operation";
				break;

			default:
				debug_var("server config error");
				debug_var(simple_debug_backtrace());
				exit;
				break;
		}// end - switch


		return $return;

	}



	/*
		public function get_server_url()
		{
			$arrTemp = parse_url(base_url());

			$rtnValue	=	$arrTemp['scheme']."://";
			$domain = $arrTemp['scheme'];

			switch ($arrTemp['host']){
				case "rea02.ljh.co.kr": // 개발
					$rtnValue	.=	"rea01.ljh.co.kr";
					break;
				default: // 운영
					$rtnValue	.=	$arrTemp['host'];
					break;
			}
			return $rtnValue;
		}



		public function get_api_url()
		{
			$arrTemp = parse_url(base_url());

			$rtnValue	=	$arrTemp['scheme']."://";
			$domain = $arrTemp['scheme'];

			switch ($arrTemp['host']){
				case "rea01.ljh.co.kr": // ljh virtualBox
					$rtnValue	.=	"reapi.ljh.co.kr";
					break;
				default: // aws
					$rtnValue	.=	$arrTemp['host'];
					break;
			}
			return $rtnValue;
		}


		public function call_curl_exec($data,$option=null)
		{

	//        debug_var(__CLASS__);
	//        debug_var(__FUNCTION__);
	//        debug_var($data);
	//        exit;
			// curl start -----------------
			$ch = curl_init(); //curl 초기화
			curl_setopt($ch, CURLOPT_URL, $data['url']);					//URL 지정하기
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//요청 결과를 문자열로 반환
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  //connection timeout 10초
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//원격 서버의 인증서가 유효한지 검사 안함
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data['send_data']);     //POST data
			curl_setopt($ch, CURLOPT_POST, true);           //true시 post 전송
			$response = curl_exec($ch);
			$buffer = ob_get_contents();
			ob_end_clean();
			if (!$buffer) {
				$returnVal = "Curl Fetch Error : ".curl_error($ch);
				debug_var(__CLASS__); debug_var(__FUNCTION__); debug_var(__LINE__); debug_var("error");
			}else{
				$returnVal = $buffer;
				debug_var(__CLASS__); debug_var(__FUNCTION__); debug_var(__LINE__); debug_var("sussucess");
			}

			curl_close($ch);
			// curl end -----------------

			debug_var($returnVal);
			debug_var($response);
			exit;

			$response_arr = json_decode($response,true);
			//debug_var($response_arr);

			$responseData = $this->AesOpensslDecrypt256($response_arr['rData']);
			$responseData = json_decode($responseData, true);
			//debug_var($responseData);
			//debug_var($returnVal);
			return $responseData;


		}

		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		/// @curl 값전송 암호화 복호화

		public function aesOpenSslSetData()
		{
			$this->_ENC_KEY = 'kthebom2021Y09M30Dpalisades-park';
			$this->_ENC_KEY_256 = substr($this->_ENC_KEY,0,32);
			$this->_ENC_KEY_128 = substr($this->_ENC_KEY,0,16);
		}


		// openssl 암호화
		public function AesOpensslEncrypt256($str)
		{
			$this->aesOpenSslSetData();
			$return = openssl_encrypt($str, $this->method, $this->_ENC_KEY_256, 0, $this->_ENC_KEY_128);
			return base64_encode($return);
		}



		// openssl 복호화
		public function AesOpensslDecrypt256($str)
		{
			$this->aesOpenSslSetData();
			$return = openssl_decrypt(base64_decode($str), $this->method, $this->_ENC_KEY_256, 0, $this->_ENC_KEY_128);
			return $return;
		}

		/// @curl 값전송 암호화 복호화
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////

	*/


}// end - class

?>
