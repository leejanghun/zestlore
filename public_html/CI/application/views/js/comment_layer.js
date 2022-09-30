
function comment_PopupDiv_show()
{
	jQuery( "body" ).append("<div id='commentBackFilm' style='display:none; z-index:9998;' onclick='comment_PopupDiv_hidden()'></div>");
	jQuery( "body" ).append("<div id='commentDivPop' style='display:none; vertical-align: top; padding: 0px 0px 0px 0px; z-index:9999'></div>");
	//----------------------------------------------------------------------------
	jQuery("#commentBackFilm").css('display'		,	"block"							);
	jQuery("#commentBackFilm").css('position'		,	"absolute"						);
	jQuery("#commentBackFilm").css('background'	,	"#cccccc"						);
	jQuery("#commentBackFilm").css('opacity'		,	0.7								);
	jQuery("#commentBackFilm").css('top'			,	'0'								);
	jQuery("#commentBackFilm").css('left'			,	'0'								);
	jQuery("#commentBackFilm").css('width'			,	jQuery(document).width()		);
	jQuery("#commentBackFilm").css('height'		,	jQuery(document).height()		);

	//	jQuery("#commentBackFilm").css('display'		,	"block"							);
	//----------------------------------------------------------------------------
	jQuery("#commentDivPop").css('display'			,	"block"							);
	jQuery("#commentDivPop").css('position'		,	"absolute"						);
	jQuery("#commentDivPop").css('background'		,	"#ffffff"						);
	jQuery("#commentDivPop").css('opacity'			,	1.0								);

	//	레이어 팝업 드레그 지원 여부
	//	jQuery( "#commentDivPop" ).draggable();

	//----------------------------------------------------------------------------------------------------------------------
	//  @   레이어 팝업 출력폼  설정 시작
	//	var popWidth    =       jQuery("#commentDivPop").css('width').replace('px','');
	/*
		var popWidth    =       "800";

		var popHeight   =       jQuery("#commentDivPop").css('height').replace('px','');

		var popTop  =       100;
		if( jQuery(window).scrollTop() > 50 )
		{
			popTop  =       100 + jQuery(window).scrollTop();
		}//     end if

		jQuery("#commentDivPop").css('top'     ,       popTop                                                                          );
		jQuery("#commentDivPop").css('left'    ,       ((jQuery(document).width() - popWidth)/2)                                       );
		jQuery("#commentDivPop").css('width'   ,       popWidth                                                                        );
		jQuery("#commentDivPop").css('height'  ,       popHeight                                                                       );
		jQuery("#commentBackFilm").css('width'         ,   jQuery(document).width()        );  //  commentBackFilm Resize
		jQuery("#commentBackFilm").css('height'        ,   jQuery(document).height()       );  //  commentBackFilm Resize
	*/
	//  @   레이어 팝업 출력폼  설정 끝
	//----------------------------------------------------------------------------------------------------------------------


	//----------------------------------------------------------------------------

}//	end function



function comment_PopupDiv_hidden()
{
	jQuery("#commentBackFilm").remove();
	jQuery("#commentDivPop").remove();
	//	jQuery( "body" ).append("<div id='divPop' style='display:none; padding: 0px 0px 0px 0px; z-index:9999'></div>");


	jQuery("#commentBackFilm").html('');
	jQuery("#commentBackFilm").css('display', "none");


}//	end function



/////////////////// 코멘트 페이징
jQuery(document).on("click",".comment_pageing > li > a",function (e) {

	e.preventDefault();e.stopPropagation();

	if(jQuery(this).attr("href").length>0) {

		var targetUrl = jQuery(this).attr("href");

		jQuery.ajax({
			url: targetUrl,
			type: "GET",
			//async: false,
			// data:{
			// 	cmt_30_post_table			: "real_estate_20_default"
			// 	,cmt_30_post_pk			: jQuery("#re_20_pk").val()
			// },
			//dataType: "html",
			success: function (rtn_arr) {
				//console.log(rtn_arr);//	return false;
				jQuery(".comment_div").html(rtn_arr);
			}

		});
	}

})



jQuery("button").bind(
	"click",function()
	{
		//console.log( "this.id => " + this.id );

		switch(this.id)
		{
			case "btn_go_submit_comment_write": comment_write_submit();	break; ////////////////// // 코멘트 작성

		}//	end switch
	}
);





////////////////// // 코멘트 작성
function comment_write_submit()
{

	let cmt_30_post_table		   = jQuery("#cmt_30_post_table").val();
	let cmt_30_post_pk             = jQuery("#cmt_30_post_pk").val();
	let write_cmt_30_text_data     = jQuery("#write_cmt_30_text_data").val();

	let targetUrl 	= jQuery("#url_go_comment_submit_write").val();

	jQuery.ajax({
		url: targetUrl,
		type: "POST",
		data: {
			cmt_30_post_table	:cmt_30_post_table
			,cmt_30_post_pk				:cmt_30_post_pk
			,cmt_30_text_data			:write_cmt_30_text_data
		},
		dataType: "json",
		success: function (rtn_arr)
		{
			//console.log( rtn_arr );//	return false;

			if(rtn_arr.SQL_Result=="FAIL")
			{
				switch (rtn_arr.error_type)
				{
					case "validation":
						alert(rtn_arr.msg);
						jQuery("#"+rtn_arr.error_focus).focus();
						break;
					case "no_login":
						alert(rtn_arr.msg);
						window.location.href	=	jQuery("#url_go_login").val();
						break;
					default:
						//	실패
						alert("DB PROCESS ERROR : DB 처리 오류 관리자에게 문의하세요.");
						//location.reload();
						break;
				}// end switch

			}
			else
			{
				location.reload();
			}

		}

	});

	return false;
}




////////////////// 코멘트 수정 폼
jQuery(document).on("click",".btn_comment_modify_form",function () {

	var cmt_30_pk = jQuery(this).data("cmt_30_pk");

	comment_PopupDiv_show(); // #divPop

	targetUrl = jQuery("#url_go_comment_modify").val();

	jQuery.ajax({
		url: targetUrl,
		type: "POST",
		data: {
			cmt_30_pk	:cmt_30_pk
			// ,cmt_30_post_pk				:cmt_30_post_pk
			// ,cmt_30_text_data			:write_cmt_30_text_data
		},
		success: function (msg) {

			jQuery("#commentDivPop").html(msg);

			let popWidth    =       jQuery("#commentDivPop").css('width').replace('px','');
			let popHeight   =       jQuery("#commentDivPop").css('height').replace('px','');
			let popTop      =       "0";

			if( jQuery(window).scrollTop() < 50 )
			{
				popTop  =       300;
			}else{
				popTop  =       300 + jQuery(window).scrollTop();
			}//     end if

			jQuery("#commentDivPop").css('top'     ,       popTop                                                                          );
			jQuery("#commentDivPop").css('left'    ,       ((jQuery(document).width() - popWidth)/2)										);
			jQuery("#commentDivPop").css('width'   ,       popWidth                                                                        );
			jQuery("#commentDivPop").css('height'  ,       popHeight                                                                       );

		}
	}) // end - ajax
}) // end - fun





////////////////// 코멘트 수정 전송
jQuery(document).on("click","#btn_go_submit_comment_modify",function () {


	let cmt_30_pk             = jQuery("#modify_cmt_30_pk").val();
	let cmt_30_text_data     = jQuery("#modify_cmt_30_text_data").val();

	let targetUrl 	= jQuery("#url_go_comment_submit_modify").val();

	jQuery.ajax({
		url: targetUrl,
		type: "POST",
		data: {
			cmt_30_pk	: cmt_30_pk
			,cmt_30_text_data	: cmt_30_text_data
		},
		dataType: "json",
		success: function (rtn_arr)
		{
			//console.log( rtn_arr );//	return false;

			if(rtn_arr.SQL_Result=="FAIL")
			{
				switch (rtn_arr.error_type)
				{
					case "validation":
						alert(rtn_arr.msg);
						jQuery("#"+rtn_arr.error_focus).focus();
						break;
					case "no_login":
						alert(rtn_arr.msg);
						window.location.href	=	jQuery("#url_go_login").val();
						break;
					default:
						//	실패
						alert("DB PROCESS ERROR : DB 처리 오류 관리자에게 문의하세요.");
						//location.reload();
						break;
				}// end switch

			}
			else
			{
				location.reload();
			}

		}

	});

}) // end - fun




////////////////// 코멘트 답글 폼
jQuery(document).on("click",".btn_comment_reply_form",function () {

	var cmt_30_parent_pk = jQuery(this).data("cmt_30_parent_pk");

	comment_PopupDiv_show(); // #divPop

	targetUrl = jQuery("#url_go_comment_reply").val();

	jQuery.ajax({
		url: targetUrl,
		type: "POST",
		data: {
			cmt_30_parent_pk	:cmt_30_parent_pk
			// ,cmt_30_post_pk				:cmt_30_post_pk
			// ,cmt_30_text_data			:write_cmt_30_text_data
		},
		success: function (msg) {

			jQuery("#commentDivPop").html(msg);

			let popWidth    =       jQuery("#commentDivPop").css('width').replace('px','');
			let popHeight   =       jQuery("#commentDivPop").css('height').replace('px','');
			let popTop      =       "0";

			if( jQuery(window).scrollTop() < 50 )
			{
				popTop  =       300;
			}else{
				popTop  =       300 + jQuery(window).scrollTop();
			}//     end if

			jQuery("#commentDivPop").css('top'     ,       popTop                                                                          );
			jQuery("#commentDivPop").css('left'    ,       ((jQuery(document).width() - popWidth)/2)										);
			jQuery("#commentDivPop").css('width'   ,       popWidth                                                                        );
			jQuery("#commentDivPop").css('height'  ,       popHeight                                                                       );

		}
	}) // end - ajax
}) // end - fun




////////////////// 코멘트 답글 전송
jQuery(document).on("click","#btn_go_submit_comment_reply",function () {

	let cmt_30_parent_pk             = jQuery("#reply_cmt_30_parent_pk").val();
	let cmt_30_text_data     = jQuery("#reply_cmt_30_text_data").val();

	let targetUrl 	= jQuery("#url_go_comment_submit_reply").val();

	jQuery.ajax({
		url: targetUrl,
		type: "POST",
		data: {
			cmt_30_parent_pk	: cmt_30_parent_pk
			,cmt_30_text_data	: cmt_30_text_data
		},
		dataType: "json",
		success: function (rtn_arr)
		{
			//console.log( rtn_arr );//	return false;

			if(rtn_arr.SQL_Result=="FAIL")
			{
				switch (rtn_arr.error_type)
				{
					case "validation":
						alert(rtn_arr.msg);
						jQuery("#"+rtn_arr.error_focus).focus();
						break;
					case "no_login":
						alert(rtn_arr.msg);
						window.location.href	=	jQuery("#url_go_login").val();
						break;
					default:
						//	실패
						alert("DB PROCESS ERROR : DB 처리 오류 관리자에게 문의하세요.");
						//location.reload();
						break;
				}// end switch

			}
			else
			{
				location.reload();
			}

		}

	});

}) // end - fun




////////////////// 삭제


////////////////// 코멘트 답글 전송
jQuery(document).on("click",".btn_comment_delete",function () {

	let cmt_30_pk             = jQuery(this).data('cmt_30_pk');

	if( confirm("삭제한 데이타는 복구가 불가능합니다. \n\n삭제하시겠습니까...? ") )
	{

		let targetUrl 	= jQuery("#url_go_comment_submit_delete").val();

		jQuery.ajax({
			url: targetUrl,
			type: "POST",
			data: {
				cmt_30_pk	: cmt_30_pk
			},
			dataType: "json",
			success: function (rtn_arr)
			{
				//console.log( rtn_arr );//	return false;

				if(rtn_arr.SQL_Result=="FAIL")
				{
					switch (rtn_arr.error_type)
					{
						case "validation":
							alert(rtn_arr.msg);
							jQuery("#"+rtn_arr.error_focus).focus();
							break;
						case "no_login":
							alert(rtn_arr.msg);
							window.location.href	=	jQuery("#url_go_login").val();
							break;
						default:
							//	실패
							alert("DB PROCESS ERROR : DB 처리 오류 관리자에게 문의하세요.");
							//location.reload();
							break;
					}// end switch

				}
				else
				{
					location.reload();
				}

			}

		});

	}//	end if


}) // end - fun
