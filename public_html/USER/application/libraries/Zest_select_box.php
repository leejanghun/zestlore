<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Zest_select_box {


	public function __construct()
	{
		$this->CI = & get_instance();


	}//	end function




	public function selectData_rent_21_bedroom()
	{
		$selectBox[0]['value']="";
		$selectBox[0]['print']="bedroom";
		$selectBox[1]['value']="1";
		$selectBox[1]['print']="1";
		$selectBox[2]['value']="2";
		$selectBox[2]['print']="2";
		$selectBox[3]['value']="3";
		$selectBox[3]['print']="3";
		$selectBox[4]['value']="4";
		$selectBox[4]['print']="4";
		$selectBox[5]['value']="5";
		$selectBox[5]['print']="5 or more";

		return $selectBox;
	}



	public function selectData_rent_21_bathroom()
	{
		$selectBox[0]['value']="";
		$selectBox[0]['print']="bathroom";
		$selectBox[1]['value']="1";
		$selectBox[1]['print']="1";
		$selectBox[2]['value']="1.5";
		$selectBox[2]['print']="1.5";
		$selectBox[3]['value']="2";
		$selectBox[3]['print']="2";
		$selectBox[4]['value']="2.5";
		$selectBox[4]['print']="2.5";
		$selectBox[5]['value']="3";
		$selectBox[5]['print']="3";
		$selectBox[6]['value']="3.5";
		$selectBox[6]['print']="3.5";
		$selectBox[7]['value']="4";
		$selectBox[7]['print']="4";
		$selectBox[8]['value']="4.5";
		$selectBox[8]['print']="4.5";
		$selectBox[9]['value']="5";
		$selectBox[9]['print']="5 or more";

		return $selectBox;
	}




	public function selectData_sale_24_bedroom()
	{
		$selectBox[0]['value']="";
		$selectBox[0]['print']="bedroom";
		$selectBox[1]['value']="1";
		$selectBox[1]['print']="1";
		$selectBox[2]['value']="2";
		$selectBox[2]['print']="2";
		$selectBox[3]['value']="3";
		$selectBox[3]['print']="3";
		$selectBox[4]['value']="4";
		$selectBox[4]['print']="4";
		$selectBox[5]['value']="5";
		$selectBox[5]['print']="5 or more";

		return $selectBox;
	}



	public function selectData_sale_24_bathroom()
	{
		$selectBox[0]['value']="";
		$selectBox[0]['print']="bathroom";
		$selectBox[1]['value']="1";
		$selectBox[1]['print']="1";
		$selectBox[2]['value']="1.5";
		$selectBox[2]['print']="1.5";
		$selectBox[3]['value']="2";
		$selectBox[3]['print']="2";
		$selectBox[4]['value']="2.5";
		$selectBox[4]['print']="2.5";
		$selectBox[5]['value']="3";
		$selectBox[5]['print']="3";
		$selectBox[6]['value']="3.5";
		$selectBox[6]['print']="3.5";
		$selectBox[7]['value']="4";
		$selectBox[7]['print']="4";
		$selectBox[8]['value']="4.5";
		$selectBox[8]['print']="4.5";
		$selectBox[9]['value']="5";
		$selectBox[9]['print']="5 or more";

		return $selectBox;
	}






}// end - class

?>
