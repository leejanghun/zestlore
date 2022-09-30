<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  @   functions
//
//  @   a84146943@gmail.com
//
////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function AddHeadZero($Length, $String)
	{
		return sprintf('%0'.$Length.'s', $String);
/*
		$StrZero	=	"";
		switch(STRLEN($String))
		{
			case $Length:
				RETURN $String;
				break;
			default:
				for($Cnt = 0; ($Length - STRLEN($String)) > $Cnt ; $Cnt++)
				{
					$StrZero	=	$StrZero."0";
				}//	end function
				$String		=	$StrZero.$String;
				RETURN $String;
		}//	end switch
*/
	}//	end Function
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function mobileNumberFormat($mobileNumber)
	{
		$mobileNumber	=	preg_replace("/[^0-9]*/s", "", $mobileNumber);
		switch(strlen($mobileNumber))
		{
			case 10:
				$rtn_mobile	=	substr($mobileNumber,0,3)."-".substr($mobileNumber,3,3)."-".substr($mobileNumber,6,4);
				break;
			case 11:
				$rtn_mobile	=	substr($mobileNumber,0,3)."-".substr($mobileNumber,3,4)."-".substr($mobileNumber,7,4);
				break;
			case 0:
				$rtn_mobile	=	"";
				break;
			default:
				$rtn_mobile	=	$mobileNumber;
		}//	end switch

		return $rtn_mobile;
	}//	end function
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
	function dateNumberForm($str_number, $delimiter)
	{
		switch(strlen($str_number))
		{
			case 0:
				$rtnValue	=	"noData";
				break;
			case 8:
				$rtnValue	=	substr($str_number,0,4).$delimiter.substr($str_number,4,2).$delimiter.substr($str_number,6,2);
				break;
			default:
				$rtnValue	=	$str_number."[format error]";
		}//	end switch

		return $rtnValue;

	}//	end function
////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////
//
	//	입력 인수값 정의
	//	$datetime1	=	"2009-10-11"; - 시작일
	//	$datetime2	=	"2009-10-12"; - 종료일
	function getDateDiff_day( $datetime1, $datetime2)
	{
		$rtnVal					=	null;
		$arr_startDate			=	explode("-",$datetime1);
		$arr_endDate			=	explode("-",$datetime2);
		$timeStamp_startDate	=	mktime("00" ,"00" ,"01" ,$arr_startDate[1]	,$arr_startDate[2]	,$arr_startDate[0]	);
		$timeStamp_endDate		=	mktime("00" ,"00" ,"01" ,$arr_endDate[1] 	,$arr_endDate[2]	,$arr_endDate[0]	);

		$loopCnt		=	0;
		$tempTimeStamp	=	$timeStamp_startDate;
		while(  $timeStamp_endDate >= $tempTimeStamp  )
		{
			$tempTimeStamp	=	$tempTimeStamp + 86400;
			$loopCnt		=	$loopCnt + 1;
		}//	end while

		$rtnVal	=	$loopCnt;

		return $rtnVal;

	}//	end function
//
////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////
//	html select Box option
	function makeOptionList($arrValue, $arrText, $selectedVal)
	{
		$rtnOption	=	"";
		for($cnt = 0; COUNT($arrValue) > $cnt; $cnt++)
		{
			if($arrValue[$cnt] == $selectedVal)
			{
				$rtnOption	=	$rtnOption."<option value=\"".$arrValue[$cnt]."\" selected=\"selected\">".$arrText[$cnt]."</option>\n";
			}else{
				$rtnOption	=	$rtnOption."<option value=\"".$arrValue[$cnt]."\">".$arrText[$cnt]."</option>\n";
			}//	end if
		}//	end for

		return $rtnOption;
	}//	end function
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function StringCutting($String, $Length, $Ext)
	{

		//	$TempString = SUBSTR($String, 0, $Length);
		//	PREG_MATCH('/^([\x00-\x7e]|.{2})*/', $TempString, $RtnArray);
		//	$RtnValue = $RtnArray[0];

		$RtnValue = SUBSTR($String, 0, $Length);

		switch(STRLEN($String) > $Length)
		{
		case TRUE: $RtnValue = $RtnValue.$Ext;	break;
		case FALSE: $RtnValue = $RtnValue;		break;
		}// end switch

		return $RtnValue;

	}// End function
////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////
//
/*
	function strcut_utf8($str, $len, $checkmb=false, $tail='...')
	{
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

		$m    = $match[0];
		$slen = strlen($str);  // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters

		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;

		$ret   = array();
		$count = 0;

		for ($i=0; $i < $len; $i++)
		{
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}

		return join('', $ret).$tail;
	}	//	end function
*/

	function strcut_utf8($str, $len, $tail='...')
	{
		return mb_substr($str, 0, $len, 'UTF-8');
	}//	end function

////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function getOnlyNumberData($str)
	{
		if( substr($str, 0, 1) == "-" )
		{
			$rtnValue	=	substr($str, 0, 1).preg_replace("/[^\.0-9]/", "", substr($str, 1));
		}else{
			$rtnValue	=	preg_replace("/[^\.0-9]/", "", $str);
		}//	end if

		return $rtnValue;
	}	// end function
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
//
	if(!function_exists('mb_detect_encoding'))
	{
		function mb_detect_encoding($string, $enc=null)
		{
    		static $list = array('utf-8', 'euc-kr', 'iso-8859-1', 'windows-1251');
    		foreach ($list as $item)
    		{
        		$sample = @iconv($item, $item, $string);
        		if (md5($sample) == md5($string))
        		{
            		if ($enc == $item)
            		{
            			return true;
					}else{
						return $item;
					}
        		}
    		}
    	return null;
		}
	}//	end if


////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function fileWrite_mode_W($filePath, $fileData)
	{
		// A. 동일경로에 존재하는 기존파일 삭제처리
		// B. fopen w 모드
		// 파일을 쓰기 모드로 연다.
		// 파일이 존재하면 기존내용을 지우고 그 위에 새로운 내용을 쓴다.
		// 그러나 존재하지 않은면 해당 파일을 생성한다.
		// 이때 파일 포인터는 해당 파일의 처음에 위치한다.

		$rtnValue	=	"FAIL";

		if( file_exists($filePath) )
		{
			unlink($filePath);
		}// end if

		$fp	=	fopen($filePath, 'w');
				fwrite($fp, $fileData);
				fclose($fp);

		if( file_exists($filePath) )
		{
			$rtnValue	=	"SUCCESS";
		}// end if

		return $rtnValue;

	}// end function
////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////
//
	function custom_array_unique($arr_source)
	{
		//	배열에서 중복을 제거한다.
		//	array_unique 함수의 경우 array index 번호 순서에 문제가 있을 수 있어서 별도로 구현함.
		$rtnArray	=	array();
		$arr_source	=	array_unique($arr_source);

		$arrayKeys	=	array_keys($arr_source);
		for($loopCnt=0; count($arrayKeys)>$loopCnt; $loopCnt++ )
		{
			$rtnArray[$loopCnt]	=	$arr_source[ $arrayKeys[$loopCnt] ];
		}//	end for

		//	$arr_source

		return $rtnArray;

	}// end function
////////////////////////////////////////////////////////////////////////////////////////////////////


?>