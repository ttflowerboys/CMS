$(function () {
    $(".js_loginSubmitBtn").click(function () {
        var $this = $(this),
            FormDOM = $this.closest('form');
        var uname = FormDOM.find('input[name="userid"]').val();
        var password = FormDOM.find('input[name="pwd"]').val();
        if (!IsEmpty(uname)) {
            layer.alert('请输入用户名！', { icon: 2 }, function (index) {
                layer.close(index);
            })
            return false;
        }
        if (!IsEmpty(password)) {
            layer.alert('请输入您的密码！', { icon: 2 }, function (index) {
                layer.close(index);
            })
            return false;
        }
        $.ajax({
            url: FormDOM.attr('action'),
            type: 'POST',
            data: FormDOM.serialize(),
            dataType: 'json',
            beforeSend: function () {
                $this.addClass('loading');
                $this.text('正在登录...');
            },
            complete: function () {
                $this.removeClass('loading');
                $this.text('马上登录');
            },
        }).done(function (res) {
            if (res.status == 1) {
                layer.msg(res.msg,{ icon: 1 },function(){
                    window.location = '/member/';
                })
            } else {
                layer.alert(res.msg, { icon: 2 }, function (index) {
                    layer.close(index);
                })
            }
        })
    });
});