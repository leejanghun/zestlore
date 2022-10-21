<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Html_produce
{


	public function __construct()
	{
		$this->CI = &get_instance();

	}//	end function


	// select box 만들기
	public function selectBox($select_arr, $element = null, $selected = null)
	{

		$select_arr_cnt = count($select_arr);

		$select_box = "";

		/////////////////////////////////////////////////////
		/// <select id='id' class='class' name='name'  >
		$select_box .= "<select";

		if (isset($element['id']) === true) {
			$select_box .= " id = '" . $element['id'] . "' ";
		}

		if (isset($element['class']) === true) {
			$select_box .= " class = '" . $element['class'] . "' ";
		}

		if (isset($element['name']) === true) {
			$select_box .= " name = '" . $element['name'] . "' ";
		}

		if (isset($element['etc']) === true) {
			$select_box .= " " . $element['etc'] . " ";
		}

		$select_box .= ">";

		/// <select id='id' class='class' name='name'  >
		/////////////////////////////////////////////////////


		/////////////////////////////////////////////////////
		/// <option value='value'>print</option>

		for ($i = 0; $i < $select_arr_cnt; $i++) {
			$select_box .= "<option value='" . $select_arr[$i]['value'] . "'";
			if (!is_null($selected) && ($select_arr[$i]['value'] == $selected)) {
				$select_box .= " selected='selected' ";
			}
			$select_box .= ">";
			$select_box .= $select_arr[$i]['print'];
			$select_box .= "</option>";
		}

		/// <option value='value'>print</option>
		/////////////////////////////////////////////////////


		$select_box .= "</select>";

		return $select_box;
	}





}// end - class

?>
