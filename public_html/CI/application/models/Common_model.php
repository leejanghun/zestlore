<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




	class Common_model extends CI_Model
	{
		public $arr_select_item	=	array();

		public function __construct()
		{
			$this->init();

			// $this->arr_select_item				=	null;
			// $this->arr_select_item["FieldSet"]	=	" * ";
		}//	end function


		public function init()
		{
			$this->arr_select_item				=	null;
			$this->arr_select_item["FieldSet"]	=	" * ";
		}//	end function


		public function createSQL()
		{
			switch( strtoupper( trim($this->arr_select_item['SQL']) ) )
			{
				case "SELECT":


					$SQL	=	$this->arr_select_item["SQL"];

					if( array_key_exists("FieldSet", $this->arr_select_item) === true )
					{
						$SQL	=	$SQL." ".$this->arr_select_item["FieldSet"];
					}//	end if

					if( array_key_exists("Table", $this->arr_select_item) === true )
					{
						$SQL	=	$SQL." FROM ".$this->arr_select_item["Table"];
					}//	end if

					if( array_key_exists("WHERE", $this->arr_select_item) === true )
					{
						$SQL	=	$SQL." WHERE ".$this->arr_select_item["WHERE"];
					}//	end if

					if( array_key_exists("SORT", $this->arr_select_item) === true )
					{
						$SQL	=	$SQL." ORDER BY ".$this->arr_select_item["SORT"];
					}//	end if

					if( array_key_exists("LIMIT", $this->arr_select_item) === true )
					{
						$SQL	=	$SQL." LIMIT ".$this->arr_select_item["LIMIT"];
					}//	end if

					break;
			}//	end switch

			return $SQL;

		}//	end function


		public function executeSQL( $SQL , $mode='object', $dbObj=null)
		{
			if( is_null( $dbObj ) == true )
			{
				$result		=	$this->db->query($SQL);
			}else{
				$result		=	$dbObj->query($SQL);
			}//	end if



			if( is_bool( $result ) )
			{

				$returnObj	=	$result;
			}else{

				switch($mode)
				{
					case "array":
						$returnData	=	$result->result_array();
						break;

					case "object":
						$returnData	=	$result->result_object();
						break;
				}//	end switch

				$result->free_result();
			}//	end if

			//	echo "<BR><BR><BR><BR>";
			//	var_dump( $result );

			return $returnData;
		}//	end function

	}//	end class

