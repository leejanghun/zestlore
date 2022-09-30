//	TRIM
String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}

//	ReplaceAll
String.prototype.replaceAll = function(searchStr, replaceStr) {

    return this.split(searchStr).join(replaceStr);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	DATE FORMAT	/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Date.prototype.format = function(f) {
    if (!this.valueOf()) return " ";

    var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
    var d = this;

    return f.replace(/(yyyy|yy|MM|dd|E|hh|mm|ss|a\/p)/gi, function($1) {
        switch ($1) {
            case "yyyy": return d.getFullYear();
            case "yy": return (d.getFullYear() % 1000).zf(2);
            case "MM": return (d.getMonth() + 1).zf(2);
            case "dd": return d.getDate().zf(2);
            case "E": return weekName[d.getDay()];
            case "HH": return d.getHours().zf(2);
            case "hh": return ((h = d.getHours() % 12) ? h : 12).zf(2);
            case "mm": return d.getMinutes().zf(2);
            case "ss": return d.getSeconds().zf(2);
            case "a/p": return d.getHours() < 12 ? "오전" : "오후";
            default: return $1;
        }
    });
};

String.prototype.string = function(len){var s = '', i = 0; while (i++ < len) { s += this; } return s;};
String.prototype.zf 	= function(len){return "0".string(len - this.length) + this;};
Number.prototype.zf 	= function(len){return this.toString().zf(len);};

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
var uri =
    {
        segment_array : function  ()
        {
            var path = location.pathname;
            //-- 앞 / 제거
            path = path.substr(1);
            //-- 끝 / 제거
            if (path.slice(-1) == '/'){	path = path.substr(0 , path.length - 1);	}
            var seg_arr = path.split('/');

            //-- index.php 제거
            if (seg_arr[0] == 'index.php'){	seg_arr.shift();	}

            return seg_arr;
        },

        segment : function (n , v)
        {
            var seg_array = this.segment_array();
            var seg_n = seg_array[n-1];

            if (typeof seg_n == 'undefined')
            {
                if (typeof v != 'undefined')
                {
                    return v;
                }else{
                    return false;
                }//	end if
            }else{
                return seg_n;
            }//	end if
        }
    };




/*

function movePage(sendValue)
{
	var targetUrl	=	"./index.php";
	var tempArr1	=	sendValue.split(",");
	var tempArr2	=	null;
	var tempCnt1	=	0;

	for( tempCnt1=0; tempArr1.length > tempCnt1; tempCnt1++ )
	{
		if(tempCnt1 == 0)
		{
			targetUrl	=	targetUrl + "?";
		}else{
			targetUrl	=	targetUrl + "&";
		}//	end if
		tempArr2	=	tempArr1[tempCnt1].split(":");
		targetUrl	=	targetUrl + tempArr2[0] + "=" + tempArr2[1];
	}//	end for

	location.href	=	targetUrl;

}// end function

*/


/*
	// str은 0~9까지 숫자만 가능하다.
	function checkNumber(str)
	{
	    var flag=true;
	    if (str.length > 0) {
	        for (i = 0; i < str.length; i++) {
	            if (str.charAt(i) < '0' || str.charAt(i) > '9') {
	                flag=false;
	            }
	        }
	    }
	    return flag;
	}//	end function
*/



/*
//콤마찍기
function setComma(str)
{
    var rtnStr	=	"";

    if( str.trim().length > 0 )
    {
        if( str == "-" )
        {
            rtnStr	=	str;
        }else{
            rtnStr	=	Number(str).toLocaleString('en');
        }//	end if
    }//	end if

    return rtnStr;
}//	end function

function setCommaProc( obj )
{
    var temp	=	jQuery("#"+obj.id).val();
    temp	=	getNumberOnly( temp );
    temp	=	setComma( temp );

    jQuery("#"+obj.id).val( temp );

}//	end function




/*

	//콤마풀기
	function unSetcomma(str)
	{
		var rtnStr	=	"";
		var str 	=	String(str);
		if( str == "-" )
		{
			rtnStr	=	str;
		}else{
			var intType	=	str.substr(0,1);
			if( intType == "-" )
			{
				rtnStr	=	"-" + str.replace(/[^\d]+/g, '');
			}else{
				rtnStr	=	str.replace(/[^\d]+/g, '');
			}//	end if
		}//	end if
	    return rtnStr;
	}//	end function


/*
	function setNullString( getVal )
	{
		var rtnValue	=	"";
		if( getVal.trim().length == 0 )
		{
			rtnValue	=	"NULL";
		}else{
			rtnValue	=	getVal;
		}//	end if

		return rtnValue;
	}//	end funciton
*/




//Number Only
function getNumberOnly(getVal)
{
  var sign		=	"";
  var rtnValue	=	"";
  var rtnValue	=	new String(getVal);

  if( rtnValue == "-" )
  {
      //	nothing
  }else{
      if( rtnValue.substr(0,1) == "-" )
      {
          sign		=	"-";
          rtnValue	=	rtnValue.substr(1);
      }//	end if

      var regex		=	/[^\.0-9]/g;
      rtnValue	= 	sign + rtnValue.replace(regex, '');
  }//	end if

  return rtnValue;
}//	end function




function sleep(gap)
{
    var then,now;
    then = new Date().getTime();
    now=then;
    while((now-then)<gap)
    {
        now = new Date().getTime();
    }// end while

}// end function


function checkEnglishNumber(str)
{
    var rtnValue	=	1;
    //	var str = "체크할 문자열";
    var err = 0;

    for (var i=0; i<str.length; i++)
    {
        var chk = str.substring(i,i+1);
        if(!chk.match(/[0-9]|[a-z]|[A-Z]/))
        {
            err = err + 1;
        }//	end if
    }//	end for

    if (err > 0)
    {
        //	alert("숫자 및 영문만 입력가능합니다.");
        rtnValue	=	0;
    }//	end if

    return rtnValue;
}//	end function


// 이메일 체크
function checkMail(strMail)
{
    // - 체크사항
    // - @가 2개이상일 경우
    // - .이 붙어서 나오는 경우
    // -  @.나  .@이 존재하는 경우
    // - 맨처음이.인 경우
    // - @이전에 하나이상의 문자가 있어야 함
    // - @가 하나있어야 함
    // - Domain명에 .이 하나 이상 있어야 함
    // - Domain명의 마지막 문자는 영문자 2~4개이어야 함

    var check1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/;
    var check2 = /^[a-zA-Z0-9\-\.\_]+\@[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4})$/;

    if ( !check1.test(strMail) && check2.test(strMail) )
    {
        return true;
    } else {
        return false;
    }
}// end function





//////////////////////////////////////////////////////////////////////////////////////////



function PopupDiv_show()
{
    jQuery( "body" ).append("<div id='BackFilm' style='display:none; z-index:9998;' onclick='PopupDiv_hidden()'></div>");
    jQuery( "body" ).append("<div id='divPop' style='display:none; vertical-align: top; padding: 0px 0px 0px 0px; z-index:9999'></div>");
    //----------------------------------------------------------------------------
    jQuery("#BackFilm").css('display'		,	"block"							);
    jQuery("#BackFilm").css('position'		,	"absolute"						);
    jQuery("#BackFilm").css('background'	,	"#cccccc"						);
    jQuery("#BackFilm").css('opacity'		,	0.7								);
    jQuery("#BackFilm").css('top'			,	'0'								);
    jQuery("#BackFilm").css('left'			,	'0'								);
    jQuery("#BackFilm").css('width'			,	jQuery(document).width()		);
    jQuery("#BackFilm").css('height'		,	jQuery(document).height()		);

    //	jQuery("#BackFilm").css('display'		,	"block"							);
    //----------------------------------------------------------------------------
    jQuery("#divPop").css('display'			,	"block"							);
    jQuery("#divPop").css('position'		,	"absolute"						);
    jQuery("#divPop").css('background'		,	"#ffffff"						);
    jQuery("#divPop").css('opacity'			,	1.0								);

    //	레이어 팝업 드레그 지원 여부
    //	jQuery( "#divPop" ).draggable();

    //----------------------------------------------------------------------------------------------------------------------
    //  @   레이어 팝업 출력폼  설정 시작
    //	var popWidth    =       jQuery("#divPop").css('width').replace('px','');
    /*
    	var popWidth    =       "800";
    
        var popHeight   =       jQuery("#divPop").css('height').replace('px','');

        var popTop  =       100;
        if( jQuery(window).scrollTop() > 50 )
        {
            popTop  =       100 + jQuery(window).scrollTop();
        }//     end if

        jQuery("#divPop").css('top'     ,       popTop                                                                          );
        jQuery("#divPop").css('left'    ,       ((jQuery(document).width() - popWidth)/2)                                       );
        jQuery("#divPop").css('width'   ,       popWidth                                                                        );
        jQuery("#divPop").css('height'  ,       popHeight                                                                       );
        jQuery("#BackFilm").css('width'         ,   jQuery(document).width()        );  //  BackFilm Resize
        jQuery("#BackFilm").css('height'        ,   jQuery(document).height()       );  //  BackFilm Resize
    */
    //  @   레이어 팝업 출력폼  설정 끝
    //----------------------------------------------------------------------------------------------------------------------    
    
    
    //----------------------------------------------------------------------------

}//	end function

function PopupDiv_hidden()
{
    jQuery("#BackFilm").remove();
    jQuery("#divPop").remove();
    //	jQuery( "body" ).append("<div id='divPop' style='display:none; padding: 0px 0px 0px 0px; z-index:9999'></div>");


    jQuery("#BackFilm").html('');
    jQuery("#BackFilm").css('display', "none");

}//	end function

//document.writeln("<div id='BackFilm' style='display:none; z-index:9998'></div>");
//document.writeln("<div id='divPop' style='display:none; padding: 0px 0px 0px 0px; z-index:9999'></div>");

jQuery( document ).ready(
    function()
    {
        jQuery( "body" ).append("<div id='temp' style='top:0px; background-color:yellow; z-index:9999'></div>");
    }
);




//////////////////////////////////////////////////////////////////////////////////////////


function pageLoading()
{
    PopupDiv_show();

    var loding_img_gif	=	Array();

    loding_img_gif[0]	=	"/CI/application/views/img/preloader/Preloader_1.gif";
    loding_img_gif[1]	=	"/CI/application/views/img/preloader/Preloader_2.gif";
    loding_img_gif[2]	=	"/CI/application/views/img/preloader/Preloader_3.gif";
    loding_img_gif[3]	=	"/CI/application/views/img/preloader/Preloader_4.gif";
    loding_img_gif[4]	=	"/CI/application/views/img/preloader/Preloader_5.gif";
    loding_img_gif[5]	=	"/CI/application/views/img/preloader/Preloader_6.gif";
    loding_img_gif[6]	=	"/CI/application/views/img/preloader/Preloader_7.gif";
    loding_img_gif[7]	=	"/CI/application/views/img/preloader/Preloader_8.gif";

    var array_idx	=	Math.floor(Math.random() * 7);
    var html		=	"<img src='" + loding_img_gif[array_idx] + "'>";

    jQuery("#divPop").html(html);

    var popWidth    =       jQuery("#divPop").css('width').replace('px','');
    var popHeight   =       jQuery("#divPop").css('height').replace('px','');

    var popTop      =       "0";

    if( jQuery(window).scrollTop() < 50 )
    {
        popTop  =       300;
    }else{
        popTop  =       300 + jQuery(window).scrollTop();
    }//     end if

    jQuery("#divPop").css('top'     ,       popTop                                                                          );
    jQuery("#divPop").css('left'    ,       ((jQuery(document).width() - popWidth)/2)										);
    jQuery("#divPop").css('width'   ,       popWidth                                                                        );
    jQuery("#divPop").css('height'  ,       popHeight                                                                       );

}//	end function


console.log("Load_common_js_yym.js");
