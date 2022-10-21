<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
*	<input type="hidden" name="company_11_pk[]" class="company_11_pk" >
*	var arr_company_11_pk = jQuery(".company_11_pk").serialize();
*		
*   위 형태의 값을 ajax로 받은값 php 처리
* 			
 */
function helper_common_unserialize_htmlToPhp($arrData)
{
	//debug_var($arrData);
	$arrData = urldecode($arrData);
	parse_str($arrData, $out_array);

	return $out_array;
}


/*
 * 소수점 이하가 0 이라면 소수점버림. 100.00 => 100
 * 소수점 이하가 0 보다 크다면 소수점 포함 출력 100.01 => 100.01
 */
 function helper_common_autoIntDecimal($data)
 {
	 $arr_tmp = explode(".",$data);

	 if(count($arr_tmp)>1)
	 {
		 // 소수점 있음

		 if($arr_tmp[1]>0)
		 {
			// 소수점이 0보다 큼
			 return $data;
		 }
		 else
		 {
			 // 소수점이 0보다 같음
			 return floor($data);
		 }
	 }
	 else
	 {
		 // 소수점 없음
		 return $data;
	 }
 }// end - fun
