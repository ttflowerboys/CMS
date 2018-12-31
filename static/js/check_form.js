function tijiao(){
    var uname = $("#V_user").val();  
    if(uname.length<1){
        layer.tips('姓名不能为空',$("#V_user"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    if(!/.*[\u4e00-\u9fa5]+.*$/.test(uname)){
        layer.tips('姓名还是填中文的吧',$("#V_user"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    var uemail = $("#V_email").val();  
    if(uemail.length<1){
        layer.tips('邮箱不能为空',$("#V_email"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    if(!(/^([A-Za-z0-9_\-\.\u4e00-\u9fa5])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,8})$/.test(uemail))){
        layer.tips('请输入正确的邮箱',$("#V_email"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    var uwechat = $("#V_wechat").val();  
    if(uwechat.length<1){
        layer.tips('微信不能为空',$("#V_wechat"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    if(!(/^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$/.test(uwechat))){
        layer.tips('请输入正确的微信',$("#V_wechat"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    var mobile = parseInt($("#V_phone").val());
    if(!(/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/.test(mobile))){
        layer.tips('请输入正确的手机号',$("#V_phone"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }
    var umessage = $("#V_message").val();
    if(umessage.length<1){
        layer.tips('请输入您的留言',$("#V_message"), { tips: [1, '#FF3100'], time:3000 });
        return false;
    }

    var action = $("#V_form").attr('action');
    $.ajax({
        type: 'POST',
        url: action,
        timeout: 20000,
        dataType: "json",
        beforeSend: function(){
            $('.J_submit').addClass('loading');
            $('.J_submit').text('正在提交...');
        },
        complete: function(){
            $('.J_submit').removeClass('loading');
            $('.J_submit').text('预约试听提交');
        },
        data: $("#V_form").serialize(),
        success: function(data){
            if(data.status==1){
                layer.msg(data.info);
                $("#V_user").value("");
                $("#V_phone").value("");
            }else{
                layer.msg(data.info);
            }
            
        },
        error:function(data){
            layer.msg("网络延迟，请您一定要再试一试");
        }
    });
}