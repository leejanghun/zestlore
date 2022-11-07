<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_hospital_detail_dev extends Widget {


    public function __construct()
    {

        $this->CI = & get_instance();
        $this->CI->load->library('pagination');

    }//	end function


    public function run( $arrayData )
    {
        $arr_searchValue        =   null;

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $arr_VARIABLE_DATA	    =	null;
        $arr_VARIABLE_DATA		=	array();
        $arr_VARIABLE_DATA		=	$arrayData;

        $arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
        $arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
        $arr_VARIABLE_DATA['function']			=	$arrayData['function'];

        $arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
        $arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['controller'];
        $arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['function'];

        $arr_Keys	=	array_keys( $arrayData['sendData'] );
        for($loopCnt=0; count($arr_Keys)>$loopCnt; $loopCnt++)
        {
            if( isset( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] ) == true )
            {
                $arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]		=	urldecode( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] );
            }else{

                switch($arr_Keys[$loopCnt])
                {
                    case "nowPage":	$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]	=	0;	break;
                    default:
                        exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
                }//	end switch

            }//	end if
        }//	end for



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @필수값

        $arr_VARIABLE_DATA['hosp_100_pk']				=	$this->CI->input->get_post("hosp_100_pk");
        $arr_VARIABLE_DATA['per_page']				=	$this->CI->input->get_post("per_page");
        $arr_VARIABLE_DATA['FILTER_FIELD_NAME']				=	$this->CI->input->get_post("FILTER_FIELD_NAME");
        $arr_VARIABLE_DATA['FILTER_FIELD_VALUE']				=	$this->CI->input->get_post("FILTER_FIELD_VALUE");

        /// @필수값
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @데이터 가져오기

        $arrData              =   null;
        $arrData['sqlWhere']  =   array('hosp_100_pk' =>  $arr_VARIABLE_DATA['hosp_100_pk']);

        $arr_SQL_Result	=   null;
        $arr_SQL_Result       =   $this->CI->Hospital_model->getHospital_RecordList($arrData);


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////@@ 데이터정리

//        $arrKeys              =   array_keys($arr_SQL_Result[0]);
//        for($loopCnt1=0; count($arrKeys)>$loopCnt1; $loopCnt1++ )
//        {
//            $arr_VARIABLE_DATA[ $arrKeys[$loopCnt1] ] =   $arr_SQL_Result[0][ $arrKeys[$loopCnt1] ];
//
//        }//   end for


        $arr_hospital_100 = $arr_SQL_Result[0];
        $arr_VARIABLE_DATA['hosp_100_pk'] = $arr_hospital_100['hosp_100_pk'] ;
        $arr_VARIABLE_DATA['hosp_100_addr'] = $arr_hospital_100['hosp_100_addr'] ;
        $arr_VARIABLE_DATA['hosp_100_clCd'] = $arr_hospital_100['hosp_100_clCd'] ;
        $arr_VARIABLE_DATA['hosp_100_clCdNm'] = $arr_hospital_100['hosp_100_clCdNm'] ;
        $arr_VARIABLE_DATA['hosp_100_cmdcGdrCnt'] = $arr_hospital_100['hosp_100_cmdcGdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_cmdcIntnCnt'] = $arr_hospital_100['hosp_100_cmdcIntnCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_cmdcResdntCnt'] = $arr_hospital_100['hosp_100_cmdcResdntCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_cmdcSdrCnt'] = $arr_hospital_100['hosp_100_cmdcSdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_detyGdrCnt'] = $arr_hospital_100['hosp_100_detyGdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_detyIntnCnt'] = $arr_hospital_100['hosp_100_detyIntnCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_detyResdntCnt'] = $arr_hospital_100['hosp_100_detyResdntCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_detySdrCnt'] = $arr_hospital_100['hosp_100_detySdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_drTotCnt'] = $arr_hospital_100['hosp_100_drTotCnt'] ;

        $arr_VARIABLE_DATA['hosp_100_estbDd'] = $arr_hospital_100['hosp_100_estbDd'] ; // 개설일
        $arr_VARIABLE_DATA['hosp_100_estbDd2'] = date( "Y.m.d" , strtotime($arr_hospital_100['hosp_100_estbDd'])) ; // 개설일2

        $arr_VARIABLE_DATA['hosp_100_hospUrl'] = $arr_hospital_100['hosp_100_hospUrl'] ;
        $arr_VARIABLE_DATA['hosp_100_mdeptGdrCnt'] = $arr_hospital_100['hosp_100_mdeptGdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_mdeptIntnCnt'] = $arr_hospital_100['hosp_100_mdeptIntnCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_mdeptResdntCnt'] = $arr_hospital_100['hosp_100_mdeptResdntCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_mdeptSdrCnt'] = $arr_hospital_100['hosp_100_mdeptSdrCnt'] ;
        $arr_VARIABLE_DATA['hosp_100_postNo'] = $arr_hospital_100['hosp_100_postNo'] ;
        $arr_VARIABLE_DATA['hosp_100_sgguCd'] = $arr_hospital_100['hosp_100_sgguCd'] ;
        $arr_VARIABLE_DATA['hosp_100_sgguCdNm'] = $arr_hospital_100['hosp_100_sgguCdNm'] ;
        $arr_VARIABLE_DATA['hosp_100_sidoCd'] = $arr_hospital_100['hosp_100_sidoCd'] ;
        $arr_VARIABLE_DATA['hosp_100_sidoCdNm'] = $arr_hospital_100['hosp_100_sidoCdNm'] ;
        $arr_VARIABLE_DATA['hosp_100_telno'] = $arr_hospital_100['hosp_100_telno'] ;
        $arr_VARIABLE_DATA['hosp_100_XPos'] = $arr_hospital_100['hosp_100_XPos'] ;
        $arr_VARIABLE_DATA['hosp_100_YPos'] = $arr_hospital_100['hosp_100_YPos'] ;
        $arr_VARIABLE_DATA['hosp_100_yadmNm'] = $arr_hospital_100['hosp_100_yadmNm'] ;
        $arr_VARIABLE_DATA['hosp_100_ykiho'] = $arr_hospital_100['hosp_100_ykiho'] ;

		// debug_var($arr_VARIABLE_DATA['hosp_100_yadmNm']);
        // debug_var($arr_VARIABLE_DATA);exit;

        //////@@ 데이터정리
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @ 상세데이터 - 의료기관의 진료과목과 의사수 등 정보 제공
        if(1) {

            $arr_VARIABLE_DATA['display_getDgsbjtInfo'] = "display_none"; // 출력 안함

            //// 데이터 검색
            $arrData = null;
            $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);
            $arrData['OrderBy'] = "hd_102_pk asc";
            $arr_SQL_Result = null;
            $arr_SQL_Result = $this->CI->Hospital_model->getDgsbjtInfo_RecordList($arrData);

            if (count($arr_SQL_Result) < 1) {
                // 입력 데이터가 없으면 api 호출
                $return_getDgsbjtInfo = $this->getDgsbjtInfo($arr_hospital_100);/// api 호출

                if ($return_getDgsbjtInfo > 0) {
                    //// 데이터 검색
                    $arrData = null;
                    $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);
                    $arrData['OrderBy'] = "hd_102_pk desc";
                    $arr_SQL_Result = null;
                    $arr_SQL_Result = $this->CI->Hospital_model->getDgsbjtInfo_RecordList($arrData);

                }
            }


            if (count($arr_SQL_Result) > 0) {
                $arr_recordList = array();
                $loopCntLimit = count($arr_SQL_Result);

                for ($loopCnt_1 = 0; $loopCntLimit > $loopCnt_1; $loopCnt_1++) {
                    $arr_recordList[$loopCnt_1] = $arr_SQL_Result[$loopCnt_1];
                }//	end for

                $arr_VARIABLE_DATA['arr_getDgsbjtInfo_list'] = $arr_recordList;

                $arr_VARIABLE_DATA['display_getDgsbjtInfo'] = ""; // 출력

            }

        }// end - if(1)

        /// @ 상세데이터 - 의료기관의 진료과목과 의사수 등 정보 제공
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////



		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ 상세데이터 - 의료기관 종별, 주소, 병상 수 등 시설정보
        if(1) {

            $arr_VARIABLE_DATA['display_getEqpInfo'] = "display_none"; // 출력 안함

            //// 데이터 검색
            $arrData = null;
            $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);

            $arr_SQL_Result = null;
            $arr_SQL_Result = $this->CI->Hospital_model->getEqpInfo_RecordList($arrData);

            //debug_var($arr_SQL_Result);exit;
            /////////////////////////////////////////////////////////////
            /// db에 없으면 api 호출
            if (count($arr_SQL_Result) < 1) {
                $api_return = $this->api_getEqpInfo($arr_hospital_100);// api 호출

                if (isset($api_return['SQL_Result_Data']['hgi_101_pk']) === true) {
                    //// 데이터 검색
                    $arrData = null;
                    $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);

                    $arr_SQL_Result = null;
                    $arr_SQL_Result = $this->CI->Hospital_model->getEqpInfo_RecordList($arrData);

                }
            }

            /// db에 없으면 api 호출
            /////////////////////////////////////////////////////////////

            if (count($arr_SQL_Result) > 0) {
                $arr_VARIABLE_DATA['display_getEqpInfo'] = "";// 출력함

                $arr_hospital_101_getEqpInfo = $arr_SQL_Result[0];

                $arr_VARIABLE_DATA['hgi_101_pk'] = $arr_hospital_101_getEqpInfo['hgi_101_pk'];
                $arr_VARIABLE_DATA['fk_hosp_100_pk'] = $arr_hospital_101_getEqpInfo['fk_hosp_100_pk'];
                $arr_VARIABLE_DATA['hgi_101_orgTyCdNm'] = $arr_hospital_101_getEqpInfo['hgi_101_orgTyCdNm'];
                $arr_VARIABLE_DATA['hgi_101_aduChldSprmCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_aduChldSprmCnt'];
                $arr_VARIABLE_DATA['hgi_101_anvirTrrmSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_anvirTrrmSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_chldSprmCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_chldSprmCnt'];
                $arr_VARIABLE_DATA['hgi_101_emymCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_emymCnt'];
                $arr_VARIABLE_DATA['hgi_101_hghrSickbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_hghrSickbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_isnrSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_isnrSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_nbySprmCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_nbySprmCnt'];
                $arr_VARIABLE_DATA['hgi_101_partumCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_partumCnt'];
                $arr_VARIABLE_DATA['hgi_101_permSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_permSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_psydeptClsGnlSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_psydeptClsGnlSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_psydeptClsHigSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_psydeptClsHigSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_psydeptOpenGnlSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_psydeptOpenGnlSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_psydeptOpenHigSbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_psydeptOpenHigSbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_ptrmCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_ptrmCnt'];
                $arr_VARIABLE_DATA['hgi_101_soprmCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_soprmCnt'];
                $arr_VARIABLE_DATA['hgi_101_stdSickbdCnt'] = $arr_hospital_101_getEqpInfo['hgi_101_stdSickbdCnt'];
                $arr_VARIABLE_DATA['hgi_101_moddt'] = $arr_hospital_101_getEqpInfo['hgi_101_moddt'];
            }

        }// end - if(1)
		/// @ 상세데이터 - 의료기관 종별, 주소, 병상 수 등 시설정보
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @ 상세데이터 - 의료기관의 장비코드에 따른 장비 대수 등 의료장비정보 제공
        if(1) {

            $arr_VARIABLE_DATA['display_getMedOftInfo'] = "display_none"; // 출력 안함

            //// 데이터 검색
            $arrData = null;
            $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);
            $arrData['OrderBy'] = "hmo_103_pk asc";
            $arr_SQL_Result = null;
            $arr_SQL_Result = $this->CI->Hospital_model->getMedOftInfo_RecordList($arrData);

            // debug_var($arr_SQL_Result);exit;

            if (count($arr_SQL_Result) < 1) {
                // 입력 데이터가 없으면 api 호출
                $return_getMedOftInfo = $this->api_getMedOftInfo($arr_hospital_100);/// api 호출

                if ($return_getMedOftInfo > 0) {
                    //// 데이터 검색
                    $arrData = null;
                    $arrData['sqlWhere'] = array('fk_hosp_100_pk' => $arr_VARIABLE_DATA['hosp_100_pk']);
                    $arrData['OrderBy'] = "hmo_103_pk asc";
                    $arr_SQL_Result = null;
                    $arr_SQL_Result = $this->CI->Hospital_model->getMedOftInfo_RecordList($arrData);

                }
            }


            if (count($arr_SQL_Result) > 0) {
                $arr_recordList = array();
                $loopCntLimit = count($arr_SQL_Result);

                for ($loopCnt_1 = 0; $loopCntLimit > $loopCnt_1; $loopCnt_1++) {
                    $arr_recordList[$loopCnt_1] = $arr_SQL_Result[$loopCnt_1];
                }//	end for

                $arr_VARIABLE_DATA['arr_getMedOftInfo_list'] = $arr_recordList;

                $arr_VARIABLE_DATA['display_getMedOftInfo'] = ""; // 출력

            }


        }// end - if(1)

        /// @ 상세데이터 - 의료기관의 장비코드에 따른 장비 대수 등 의료장비정보 제공
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////


        /// @데이터 가져오기
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @이동 url

        $arr_VARIABLE_DATA['url_go_list']   =   "";
        $arr_VARIABLE_DATA['url_go_list']   =   $arr_VARIABLE_DATA['siteURL'];
        $arr_VARIABLE_DATA['url_go_list']   .=   "index.php";
        $arr_VARIABLE_DATA['url_go_list']   .=   "/hospital_default/hospital_list";
        $arr_VARIABLE_DATA['url_go_list']   .=   "?per_page=".$arr_VARIABLE_DATA['per_page'];
        $arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_NAME=".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
        $arr_VARIABLE_DATA['url_go_list']   .=   "&FILTER_FIELD_VALUE=".$arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];


        // 네이버 지도
        // 'http://map.naver.com/index.nhn?enc=utf8&level=2&lng='+ position.lng() +'&lat='+ position.lat() +'&pinTitle=야탑중학교&pinType=SITE';
        $arr_VARIABLE_DATA['go_url_naver_map']   =   "";
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "http://map.naver.com/index.nhn";
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "?enc=utf8&level=1&pinType=SITE";
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lng=".$arr_VARIABLE_DATA['hosp_100_XPos'];
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "&lat=".$arr_VARIABLE_DATA['hosp_100_YPos'];
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "&pinTitle=".$arr_VARIABLE_DATA['hosp_100_yadmNm'];

        /// @이동 url
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        $arr_VARIABLE_DATA['html_tpl_path']		=	'widgets/hospital/widget_hospital_view_dev.html';	    //	디자인 파일 경로

        return $this->CI->parser->parse( $arr_VARIABLE_DATA['html_tpl_path'] , $arr_VARIABLE_DATA, true );

    }//	end function



    /// @ 상세데이터 - 의료기관의 진료과목과 의사수 등 정보 제공
	private function getDgsbjtInfo($arr_hospital_100)
	{
        // debug_var($arr_hospital_100);

	    $exe_datetime =  date("Y-m-d H:i:s");

		$rtnString = 0;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 설정값
		$config_getEqpInfo = $this->CI->Config_model->get_config_10_default_code("getEqpInfo");
		$service_key = $config_getEqpInfo['config_10_value'];
		/// @ api 설정값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @ api 호출
		$url = 'http://apis.data.go.kr/B551182/MadmDtlInfoService/getDgsbjtInfo'; //  진료과목2
		$queryParams = '?' . urlencode('serviceKey') . '=' . urlencode($service_key); //Service Key
		$queryParams .= '&' . urlencode('ykiho') . '=' . urlencode($arr_hospital_100['hosp_100_ykiho']);
		$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
		$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode(1);
		$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode(100); //  한번에 가져오는 갯수


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		curl_close($ch);

		// debug_var($response);

		$response_arr = json_decode($response,true);

		// debug_var($response_arr['response']['body']['totalCount']);

        /// @ api 호출
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////


		if( isset($response_arr['response']['body']['totalCount'])===true && $response_arr['response']['body']['totalCount']>0)
		{
            $items = $response_arr['response']['body']['items']['item'];

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /// @ 데이터 입력
            for($i=0;$i<$response_arr['response']['body']['totalCount'];$i++)
            {

                $arrDBdata = array();
                $arrDBdata = $items[$i];

                $arrData['tbl_name1']    =   'hospital_102_getDgsbjtInfo';

                //$arrData['arr_data1']['hd_102_pk'] = $arrDBdata['hd_102_pk'];
                $arrData['arr_data1']['fk_hosp_100_pk'] = $arr_hospital_100['hosp_100_pk'];
                $arrData['arr_data1']['hd_102_dgsbjtCd'] = $arrDBdata['dgsbjtCd'];
                $arrData['arr_data1']['hd_102_dgsbjtCdNm'] = $arrDBdata['dgsbjtCdNm'];
                $arrData['arr_data1']['hd_102_dgsbjtPrSdrCnt'] = $arrDBdata['dgsbjtPrSdrCnt'];
                $arrData['arr_data1']['hd_102_cdiagDrCnt'] = $arrDBdata['cdiagDrCnt'];
                $arrData['arr_data1']['hd_102_moddt'] = $exe_datetime;

                $this->CI->Hospital_model->insert_hospital_102_getDgsbjtInfo( $arrData ); // 데이터 입력

                $rtnString = $i;
            }// end - for

            /// @ 데이터 입력
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }// end - if


        return $rtnString;

	}



	/// @ 상세데이터 - 의료기관 종별, 주소, 병상 수 등 시설정보
	private function api_getEqpInfo($arr_hospital_100)
	{

		$rtnString = 0;

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// @ api 설정값
		$config_getEqpInfo = $this->CI->Config_model->get_config_10_default_code("getEqpInfo");
		$service_key = $config_getEqpInfo['config_10_value'];
		/// @ api 설정값
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$url = 'http://apis.data.go.kr/B551182/MadmDtlInfoService/getEqpInfo'; //  의료기관 종별, 주소, 병상 수 등 시설정보

		$ch = curl_init();
		$queryParams = '?' . urlencode('serviceKey') . '=' . urlencode($service_key); /*Service Key*/
		$queryParams .= '&' . urlencode('ykiho') . '=' . urlencode($arr_hospital_100['hosp_100_ykiho']);
		$queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
		$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode(1); /**/
		$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode(1); /*  한번에 가져오는 갯수 */

		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		curl_close($ch);

		// debug_var($response);exit;

		$response_arr = json_decode($response,true);

		if( isset($response_arr['response']['body']['items']['item']['yadmNm'])===true)
		{
			
			//// 데이터 입력
			$arrDBdata = $response_arr['response']['body']['items']['item'];

			
			$arrData['tbl_name1']    =   'hospital_101_getEqpInfo';

			//$arrData['arr_data1']['hgi_101_pk'] = $arrDBdata['101_pk'];
			$arrData['arr_data1']['fk_hosp_100_pk'] = $arr_hospital_100['hosp_100_pk'];
			$arrData['arr_data1']['hgi_101_orgTyCdNm'] = $arrDBdata['orgTyCdNm'];
			$arrData['arr_data1']['hgi_101_aduChldSprmCnt'] = $arrDBdata['aduChldSprmCnt'];
			$arrData['arr_data1']['hgi_101_anvirTrrmSbdCnt'] = $arrDBdata['anvirTrrmSbdCnt'];
			$arrData['arr_data1']['hgi_101_chldSprmCnt'] = $arrDBdata['chldSprmCnt'];
			$arrData['arr_data1']['hgi_101_emymCnt'] = $arrDBdata['emymCnt'];
			$arrData['arr_data1']['hgi_101_hghrSickbdCnt'] = $arrDBdata['hghrSickbdCnt'];
			$arrData['arr_data1']['hgi_101_isnrSbdCnt'] = $arrDBdata['isnrSbdCnt'];
			$arrData['arr_data1']['hgi_101_nbySprmCnt'] = $arrDBdata['nbySprmCnt'];
			$arrData['arr_data1']['hgi_101_partumCnt'] = $arrDBdata['partumCnt'];
			$arrData['arr_data1']['hgi_101_permSbdCnt'] = $arrDBdata['permSbdCnt'];
			$arrData['arr_data1']['hgi_101_psydeptClsGnlSbdCnt'] = $arrDBdata['psydeptClsGnlSbdCnt'];
			$arrData['arr_data1']['hgi_101_psydeptClsHigSbdCnt'] = $arrDBdata['psydeptClsHigSbdCnt'];
			$arrData['arr_data1']['hgi_101_psydeptOpenGnlSbdCnt'] = $arrDBdata['psydeptOpenGnlSbdCnt'];
			$arrData['arr_data1']['hgi_101_psydeptOpenHigSbdCnt'] = $arrDBdata['psydeptOpenHigSbdCnt'];
			$arrData['arr_data1']['hgi_101_ptrmCnt'] = $arrDBdata['ptrmCnt'];
			$arrData['arr_data1']['hgi_101_soprmCnt'] = $arrDBdata['soprmCnt'];
			$arrData['arr_data1']['hgi_101_stdSickbdCnt'] = $arrDBdata['stdSickbdCnt'];
			$arrData['arr_data1']['hgi_101_moddt'] = date("Y-m-d H:i:s");

			$rtnString =  $this->CI->Hospital_model->insert_hospital_101_getEqpInfo( $arrData ); // 데이터 입력


		}

		return $rtnString;

	}// end - fun



    /// @ 상세데이터 - 의료기관의 장비코드에 따른 장비 대수 등 의료장비정보 제공
    private function api_getMedOftInfo($arr_hospital_100)
    {
        $exe_datetime =  date("Y-m-d H:i:s");

        $rtnString = 0;

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @ api 설정값
        $config_getEqpInfo = $this->CI->Config_model->get_config_10_default_code("getEqpInfo");
        $service_key = $config_getEqpInfo['config_10_value'];
        /// @ api 설정값
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// @ api 호출
        $url = 'http://apis.data.go.kr/B551182/MadmDtlInfoService/getMedOftInfo'; //  진료과목2
        $queryParams = '?' . urlencode('serviceKey') . '=' . urlencode($service_key); //Service Key
        $queryParams .= '&' . urlencode('ykiho') . '=' . urlencode($arr_hospital_100['hosp_100_ykiho']);
        $queryParams .= '&' . urlencode('_type') . '=' . urlencode('json');
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode(1);
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode(200); //  한번에 가져오는 갯수

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        // debug_var($response);

        $response_arr = json_decode($response,true);

        // debug_var($response_arr);exit;
        // debug_var($response_arr['response']['body']['totalCount']);

        /// @ api 호출
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////


        if( isset($response_arr['response']['body']['totalCount'])===true && $response_arr['response']['body']['totalCount']>0)
        {
            $items = $response_arr['response']['body']['items']['item'];

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /// @ 데이터 입력

            for($i=0;$i<$response_arr['response']['body']['totalCount'];$i++)
            {

                $arrDBdata = array();
                $arrDBdata = $items[$i];

                $arrData['tbl_name1']    =   'hospital_103_getMedOftInfo';

                // $arrData['arr_data1']['hmo_103_pk'] = $arrDBdata['hmo_103_pk'];
                $arrData['arr_data1']['fk_hosp_100_pk'] = $arr_hospital_100['hosp_100_pk'];
                $arrData['arr_data1']['hmo_103_oftCd'] = $arrDBdata['oftCd'];
                $arrData['arr_data1']['hmo_103_oftCdNm'] = $arrDBdata['oftCdNm'];
                $arrData['arr_data1']['hmo_103_oftCnt'] = $arrDBdata['oftCnt'];
                $arrData['arr_data1']['hmo_103_moddt'] = $exe_datetime;


                $this->CI->Hospital_model->insert_hospital_103_getMedOftInfo( $arrData ); // 데이터 입력

                $rtnString = $i;
            }// end - for

            /// @ 데이터 입력
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }// end - if


        return $rtnString;

    }






}// end - class

?>















