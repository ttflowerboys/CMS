$(function () {
    $("#loginSubmitBtn").click(function () {
        var $this = $(this);
        var uname = $("#uname").val();
        var password = $("#password").val();
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
        var FormDOM = $('#loginFORM');
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
            console.log(res, 61)
            if (res.status == 1) {

            } else {
                layer.alert(res.msg, { icon: 2 }, function (index) {
                    layer.close(index);
                })
            }
        })
    });
});