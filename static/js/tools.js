var tools = {
    loading: null,
    loading_config: {
        class: 'loading',
        text: 'Loading...',
        default_text: 'Update'
    },
    loading_show: function (obj) {
        if (obj) { obj.addClass(this.loading_config.class).text(this.loading_config.text); }
        this.loading = layer.load(2, { shade: [.3, '#000'] })
    },
    loading_hide: function (obj, params) {
        if (obj) {
            var text = params && params.text ? params.text : this.loading_config.default_text;
            obj.removeClass(this.loading_config.class).text(text);
        }
        layer.close(this.loading)
    },
    // 检查 email 格式
    IsEmail: function (strg) {
        var patrn = new RegExp('^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    // 验证电话
    IsTel: function (strg) {
        var patrn = new RegExp('^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    // 验证手机
    IsMobile: function (strg) {
        var patrn = new RegExp("^1[\\d]{10}$");
        if (!patrn.test(strg))
            return false;
        return true;
    },
    // 验证邮编
    IsZip: function (strg) {
        var patrn = new RegExp('^\\d{6}$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    // 验证整数
    IsInt: function (strg) {
        var patrn = new RegExp('^\\d{1,10}$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    //验证浮点数
    IsFloat: function (strg) {//?([0-9]{0,9})?(.([0-9]{1,2}))
        var patrn = new RegExp('^[1-9]{0,1}[0-9]{0,9}(\.[0-9]{1,2})?$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    //验证IP
    IsIP: function (strg) {
        var patrn = new RegExp('^([0-9]{1,3}\.{1}){3}[0-9]{1,3}$');
        if (!patrn.test(strg))
            return false;
        return true;
    },
    //验证空(去除空格和回车)
    IsEmpty: function (str) {
        if (!str) return false;
        var resultStr = str.replace(/\ +/g, ""); //去掉空格
        if (resultStr.length == 0) return false;
        var resultStr2 = resultStr.replace(/[\r\n]/g, ""); //去掉回车换行
        if (resultStr2.length == 0) return false;
        return true;
    },
    //验证密码
    IsPass: function (strg) {
        /*//var patrn = new RegExp("^[a-zA-Z0-9\u4e00-\u9fa5]{6,18}$");
        if (!patrn.test(strg))
            return false;
        return true;*/
        if (strg.length < 6 || strg.length > 18) return false;
        return true;
    },
    // 验证微信号
    IsWechat: function (str) {
        var reg = new RegExp('^[a-zA-Z]{1}[-_a-zA-Z0-9]{5,19}$');
        if (!reg.test(str))
            return false;
        return true;
    }
}




