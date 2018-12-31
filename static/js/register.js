$(function () {
    $("#regSubmitBtns").on("click", function () {
        var $this = $(this);
        var regNickname = $("#regNickname").val();
        var regEmail = $("#regEmail").val();
        var regPass = $("#regPass").val();
        var regrepass = $("#regrepass").val();
        if (!IsEmpty(regNickname)) {
            layer.alert('用户名不能为空！', { icon: 2 }, function(index){
                layer.close(index);
            })
            return false;
        }
        if (!IsEmail(regEmail)) {
            layer.alert('请输入正确的邮箱！', { icon: 2 }, function(index){
                layer.close(index);
            })
            return false;
        }
        if (!IsEmpty(regPass)) {
            layer.alert('密码不能为空！', { icon: 2 }, function(index){
                layer.close(index);
            })
            return false;
        }
        if (regrepass != regPass) {
            layer.alert('确认密码不正确！', { icon: 2 }, function(index){
                layer.close(index);
            })
            return false;
        }
        var FormDOM = $('#regsiterFORM');
        $.ajax({
            url: FormDOM.attr('action'),
            type: 'POST',
            data: FormDOM.serialize(),
            dataType: 'json',
            beforeSend: function(){
                $this.addClass('loading');
                $this.text('正在提交...');
            },
            complete: function(){
                $this.removeClass('loading');
                $this.text('提交');
            },
        }).done(function(res){
            if(res.status == 1){
                window.location = res.url;
            }else{
                layer.alert(res.msg, { icon: 2 }, function(index){
                    layer.close(index);
                    var URL = res.url;
                    if(URL){
                        setTimeout(function(){
                            window.location = res.url
                        }, 10)
                    }
                })
            }
        })
    });
})