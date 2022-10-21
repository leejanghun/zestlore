<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class widget_top extends Widget
{

    public function __construct()
    {
        $this->CI = & get_instance();

    }//	end function


    public function run( $arrayData )
    {
		$arr_VARIABLE_DATA						=	null;
		$arr_VARIABLE_DATA['siteURL']           =   $this->CI->arr_class_common['siteURL'];
		$arr_VARIABLE_DATA['controller']		=	$arrayData['controller'];
		$arr_VARIABLE_DATA['function']			=	$arrayData['function'];

		$arr_VARIABLE_DATA['NowPageURL']        =   $arr_VARIABLE_DATA['siteURL'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/index.php";
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['controller'];
		$arr_VARIABLE_DATA['NowPageURL']        .=   "/".$arr_VARIABLE_DATA['function'];



		$arr_Keys	=	array_keys( $arrayData['sendData'] );
		for($loopCnt=0; count($arr_Keys)>$loopCnt; $loopCnt++)
		{
			if( isset( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] ) == true )
			{
				$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]		=	urldecode( $arrayData['sendData'][ $arr_Keys[$loopCnt] ] );
			}else{
				switch( $arr_Keys[$loopCnt] )
				{
					case "nowPage":	$arr_VARIABLE_DATA[ $arr_Keys[$loopCnt] ]	=	0;	break;
					default:
						exit("ERROR : UNDEFINE - `".$arr_Keys[$loopCnt]."` Value  ");
				}//	end switch
			}//	end if
		}//	end for


//        switch( strtoupper( $arr_VARIABLE_DATA['controller'] ) )
//        {
//            default:
//                echo "Undefine Active Node"."<BR>";
//                echo strtoupper( $arr_VARIABLE_DATA['controller'] )."<BR>";
//                echo strtoupper( $arr_VARIABLE_DATA['function'] )."<BR>";
//        }// end switch


		//debug_var($_COOKIE);




		$htmlFilePath   =   "widget_top.html"; //

        $rtnValue	    =	$this->CI->parser->parse($htmlFilePath, $arr_VARIABLE_DATA, true);


        return $rtnValue;

    }//	end function

}//	class


?>
