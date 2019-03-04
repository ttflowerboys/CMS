    $(function(){
        $(".js_getPassBtns").on('click', function(){
            var $this = $(this),
                FormDOM = $this.closest('form'),
                getPassEmail = FormDOM.find('input[name="email"]').val();
            if(!IsEmail(getPassEmail)){
                layer.alert('<b style="color:red;">Please input your email address.</b>', { icon: 2 }, function (index) {
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
                            location.reload();
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
