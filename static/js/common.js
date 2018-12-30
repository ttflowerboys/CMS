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