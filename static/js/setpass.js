    $(function(){
        $(".js_setPassBtns").on('click', function(){
            var $this = $(this),
                FormDOM = $this.closest('form'),
                getPass = FormDOM.find('input[name="userpwd"]').val();
                getPassOK = FormDOM.find('input[name="userpwdok"]').val();

            if (!IsEmpty(getPass)) {
                layer.alert('密码不能为空！', { icon: 2 }, function(index){
                    layer.close(index);
                })
                return false;
            }
            if (getPassOK != getPass) {
                layer.alert('确认密码不正确！', { icon: 2 }, function(index){
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
                }
            }).done(function (res) {
                if (res.status == 1) {
                    layer.msg(res.msg,{ icon: 1 },function(){
                        setTimeout(function(){
                            window.location="/"
                        }, 2000);
                    })
                } else {
                    layer.alert(res.msg, { icon: 2 }, function (index) {
                        layer.close(index);
                    })
                }
            })
        });
    });
