# 三镇网络科技有限公司

## 产品
| 产品名称 | 产品LOGO | 分支 |
|--------|--------|--------|
| XIAOCMS商业版 | ![XIAOCMS](http://www.xiaocms.com/core/template/img/logo.png)| xiaocms |

## XiaoCMS开发指南
* 多文件字段上传调用
>`pic`，是你自定义字段的名称
>`[fileurl]`、`[filename]`，这两个是系统内置固定的不可修改。`fileurl`，表示文件的连接地址；`filename`，表示文件名称。

 * 只调用文件地址不含名称
```PHP
{xiao:loop $pic[fileurl] $t}
    <img src="{xiao:$t}"/>
{/xiao:loop}
```

 * 只调用文件名称 不含地址
```PHP
{xiao:loop $pic[filename] $t}
    <img alt="{xiao:$t}"/>
{/xiao:loop}
```

 * 名称地址一起调
```PHP
{xiao:loop $pic[fileurl] $key=>$t}
    <img src="{xiao:$pic[fileurl][$key]}" alt="{xiao:$pic[filename][$key]}"/>
{/xiao:loop}
```

 * 获取第一张图片的地址
```PHP
<img src="{xiao:$pic[fileurl][0]}"/>
```

## 说明
* 营销官网：`http://www.threetowns.cn`
* 技术支持：`http://www.flowerboys.cn`

## 技术支持
>[三镇网络技术有限公司](http://www.threetowns.cn)，专注于网络营销、电子商务和企业定制化建站服务，把正确的营销方向当作一种使命，帮助客户提供专业的网络营销方案。其雄厚的实力，专业的营销团队一直活跃于各大电子商务平台的前线。

***

## 联系方式

* EMAIL联系方式：`threetowns@163.com`

| 官方网站 | 技术微信 | 技术QQ | QQ交流群 |
|--------|--------|--------|--------|
|![qq-1209445709](https://github.com/threetowns/About/raw/master/qrCode/website_threetowns.cn.jpg)|![wechat-433238694](https://github.com/threetowns/About/raw/master/qrCode/wechat_yonger_lei.jpg)|   ![qq-1209445709](https://github.com/threetowns/About/raw/master/qrCode/qq_1209445709.jpg)     |    ![qq-433238694](https://github.com/threetowns/About/raw/master/qrCode/qqGroup_433238694.jpg)    |
