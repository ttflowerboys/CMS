// 检查 email 格式
function IsEmail(strg) {
    //var patrn = new RegExp('^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$'); 
    var patrn = new RegExp('^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$');
    if (!patrn.test(strg))
        return false;
    return true;
}

// 验证电话
function IsTel(strg) {
    var patrn = new RegExp('^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$');
    if (!patrn.test(strg))
        return false;
    return true;
}

// 验证手机
function IsMobile(strg) {
    //var patrn = new RegExp("^0?(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9]|19[0-9])[0-9]{8}$");
    var patrn = new RegExp("^1[\\d]{10}$");
    //var patrn = new RegExp('^(13|15|18)[0-9]{9}$');
    if (!patrn.test(strg))
        return false;
    return true;
}

// 验证邮编
function IsZip(strg) {
    var patrn = new RegExp('^\\d{6}$');
    if (!patrn.test(strg))
        return false;
    return true;
}

// 验证整数
function IsInt(strg) {
    var patrn = new RegExp('^\\d{1,10}$');
    if (!patrn.test(strg))
        return false;
    return true;
}

//验证浮点数
function IsFloat(strg){//?([0-9]{0,9})?(.([0-9]{1,2}))
    var patrn = new RegExp('^[1-9]{0,1}[0-9]{0,9}(\.[0-9]{1,2})?$');
    if (!patrn.test(strg))
        return false;
    return true;
}

//验证IP
function IsIP(strg){
    var patrn = new RegExp('^([0-9]{1,3}\.{1}){3}[0-9]{1,3}$');
    if (!patrn.test(strg))
        return false;
    return true;
}

//验证空(去除空格和回车)
function IsEmpty(str){
	if(!str) return false;
	var resultStr = str.replace(/\ +/g, ""); //去掉空格
		if(resultStr.length == 0) return false;
        var resultStr2 = resultStr.replace(/[\r\n]/g, ""); //去掉回车换行
        if(resultStr2.length == 0) return false;
        return true;
}

//验证密码
function IsPass(strg){
	/*//var patrn = new RegExp("^[a-zA-Z0-9\u4e00-\u9fa5]{6,18}$");
	if (!patrn.test(strg))
        return false;
    return true;*/
    if(strg.length < 6 || strg.length > 18) return false;
    return true;
}

// 验证微信号
function IsWechat(str){
    if(!str) return false;
    var reg = new RegExp('^[a-zA-Z]{1}[-_a-zA-Z0-9]{5,19}$');
    if(!reg.test(str)) return false;
    return false;
}



$(function () {
    // ajax loading
    function show_loading_body() {
        if ($("#layer_loading").length > 0) {
            $("#layer_loading").css("display") == 'none' ? $("#layer_loading").css('display', '') : $("#layer_loading").css('display', 'none');
        } else {
            var yScroll = document.documentElement.scrollTop;
            var screenheight = document.documentElement.clientHeight;
            var t = yScroll + screenheight - 240;
            $("body").append('<div id="layer_loading" style="position:fixed;background:url(\'/static/images/heibg.png\');z-index:100000;color:#FFF;font-size:16px;font-weight:bold;top:0px !important;left:0px !important;bottom:0px !important;right:0px !important;text-align:center;" id="layer_loading"><table height="100%" width="100%"><tr><td valign="middle"><img src="/static/images/load2.gif" align="absmiddle" /> loading……</td></tr></table></div>');
            $("#layer_loading").show();
        }
    }

    //关闭弹窗操作
    $("body").on("click", ".closeAlertBoxs", function () {
        $(this).parents(".alertBoxs").remove();
    })
    //登陆框开始
    $("body").on("click", ".js_showAlertBtn", function () {
        var obj = $(this);
        var url = $(this).attr("data-url");
        if (url == '/plus/login_popup/') {
            url = url + "?random=" + Math.random() + '&jump=';
        } else {
            url = url + "?random=" + Math.random();
        }
        var closeparents = $(this).attr("data-do");
        $.ajax({
            type: 'post',
            url: url,
            timeout: 90000,
            beforeSend: function () { show_loading_body(); },
            dataType: 'html',
            success: function (o) {
                //关闭前面已有弹窗
                if (closeparents == "close") {
                    $(obj).parents(".alertBoxs").remove();
                }
                //显示当前弹窗
                $("body").append(o);
            },
            complete: function () { show_loading_body(); },
            error: function () { }
        });
    });
    //用户注销操作
    $("#logoutBtn").on("click", function () {
        $.ajax({
            type: 'post',
            url: "/welcome/logout/?random=" + Math.random(),
            timeout: 90000,
            beforeSend: function () { show_loading_body(); },
            dataType: 'json',
            success: function (o) {
                showMsg('<b style="color:green;">' + o.msg + '</b>', 3, 'succeed');
                window.location.href = "/";
            },
            complete: function () { show_loading_body(); },
            error: function () { }
        });
    });
})