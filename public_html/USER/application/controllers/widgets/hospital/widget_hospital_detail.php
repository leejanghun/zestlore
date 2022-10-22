<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




class Widget_hospital_detail extends Widget {


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

        // debug_var($arr_VARIABLE_DATA);exit;

        //////@@ 데이터정리
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "&FILTER_FIELD_NAME=".$arr_VARIABLE_DATA['FILTER_FIELD_NAME'];
        $arr_VARIABLE_DATA['go_url_naver_map']   .=   "&FILTER_FIELD_VALUE=".$arr_VARIABLE_DATA['FILTER_FIELD_VALUE'];

        /// @이동 url
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $arr_VARIABLE_DATA['html_tpl_path']		=	'widgets/hospital/widget_hospital_view.html';	    //	디자인 파일 경로

        return $this->CI->parser->parse( $arr_VARIABLE_DATA['html_tpl_path'] , $arr_VARIABLE_DATA, true );

    }//	end function


}

?>















