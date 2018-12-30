<?php

?>

<div id="lgFromBoxs" class="alertBoxs floatmain pie">
<!--登录框开始-->
<table class="floatboxs">
	<tr><td>&nbsp;</td>
    <td valign="middle" width="404" height="100%">
		<div class="lktcDiv pie">
        	<a class="closeBtn closeAlertBoxs closeCz" href="javascript:;"></a>
			<div class="dlzc">
				<div class="dlzcTit"><h3>登陆</h3><a href="/member/register.php" class="gotoRegiest">立即注册</a></div>
				<div class="dlzcForm">
					<form name="loginFORM" id="loginFORM" method="post" action="/member/ajax_index_do.php">
					<input type="hidden" name="fmdo" value="login">
      <input type="hidden" name="dopost" value="login">
					<div class="inputDiv">
						<p class="icon"><img src="/static/images/dlIcon01.jpg" width="50" height="47" /></p>
						<input class="txt" name="userid" id="uname" type="text" placeholder="请输入用户名" />
					</div>
					<div class="inputDiv" style="margin-bottom:15px;">
						<p class="icon"><img src="/static/images/dlIcon02.jpg" width="50" height="47" /></p>
						<input class="txt" name="pwd" id="password" type="password" placeholder="设置密码" />
					</div>
                    <div class="dlczCz">
						<div class="xieyi"><label><input  type="checkbox" checked value="2592000" name="keeptime" />自动登录</label></div>
						<a href="javascript:;" data-url="/welcome/getpass/" data-do="close" class="showAlertBtn forget">忘记密码?</a>
					</div>
					<div class="inputBtn"><input class="submitBtn" name="" id="loginSubmitBtn" type="button" value="马上登陆" /></div>
					</form>
				</div>
				<div class="ht35"></div>
			</div>
        </div>            
    </td><td>&nbsp;</td></tr>
</table>
<script type="text/javascript">
$(function(){
	$("#loginSubmitBtn").click(function(){
        var $this = $(this);
		var uname = $("#uname").val();
		var password = $("#password").val();
		if(!IsEmpty(uname)){
            layer.alert('请输入用户名！', { icon: 2 }, function(index){
                layer.close(index);
            })
			return false;
		}
		if(!IsEmpty(password)){
            layer.alert('请输入您的密码！', { icon: 2 }, function(index){
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
            beforeSend: function(){
                $this.addClass('loading');
                $this.text('正在登录...');
            },
            complete: function(){
                $this.removeClass('loading');
                $this.text('马上登录');
            },
        }).done(function(res){
            console.log(res, 61)
            if(res.status == 1){

            }else{
                layer.alert(res.msg, { icon: 2 }, function(index){
                    layer.close(index);
                })
            }
        })
	});
});
</script>
</div>


<form name='form1' method='POST' action='index_do.php'>
      <input type="hidden" name="fmdo" value="login">
      <input type="hidden" name="dopost" value="login">
      <input type="hidden" name="gourl" value="<?php if(!empty($gourl)) echo $gourl;?>">
      <ul>
        <li> <span>用户名：</span>
          <input id="txtUsername" class="text login_from" type="text" name="userid"/>
        </li>
        <li> <span>密&nbsp;&nbsp;&nbsp;码：</span>
          <input id="txtPassword" class="text login_from2" type="password" name="pwd"/>
        </li>
        <li> <span>验证码：</span>
          <input id="vdcode" class="text login_from3" type="text" style="width: 50px; text-transform: uppercase;" name="vdcode"/>
          <img id="vdimgck" align="absmiddle" onclick="this.src=this.src+'?'" style="cursor: pointer;" alt="看不清？点击更换" src="../include/vdimgck.php"/>
           看不清？ <a href="#" onclick="changeAuthCode();">点击更换</a> </li>
        <!-- <li> <span>有效期：</span>
          <input type="radio" value="2592000" name="keeptime" id="ra1"/>
          <label for="ra1">一个月</label>
          <input type="radio" checked="checked" value="604800" name="keeptime" id="ra2"/>
          <label for="ra2">一周</label>
          <input type="radio" value="86400" name="keeptime"  id="ra3"/>
          <label for="ra3">一天</label>
          <input type="radio" value="0" name="keeptime"  id="ra4"/>
          <label for="ra4">即时</label></li>
        <li> -->
          <button id="btnSignCheck" class="button2" type="submit">登&nbsp;录</button>
          <button type="button" class="buttonGreen142" onclick="javascript:location='../plus/alipay.php'">支付宝登录</button>
          <a href="resetpassword.php">忘记密码？</a>
           </li>
      </ul>
    </form>