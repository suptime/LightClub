<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="textBlock">
    <tbody class="textBlockOuter">
    <tr>
        <td valign="top" class="textBlockInner">
            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="textContentContainer">
                <tbody>
                <tr>
                    <td valign="top" class="textContent"
                        style="padding-top:5px; padding-right: 40px; padding-bottom: 25px;padding-left: 40px;background-color:rgba(255,255,255,0)">
                        <div style="text-align: center"><br>
                            <span style="font-family: 'Microsoft YaHei', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif;text-align: center; font-size: 14px !important; line-height: 24.9333px;">
                                感谢您注册{{ $sitename }}用户,请根据指导完成账户激活
                                <br /><br />
                                点击下方按钮完成注册</span>
                        </div>
                        <div style="text-align:center;margin-top: 20px">
                            <div style="width: 600px;display:inline-block;padding:10px">
                                <a class="activeA" style="display:inline-block;background:#07d681;
                                               border-radius:4px;padding: 0px auto;color:white;
                                               text-decoration:none;font-size:16px;line-height: 44px ; width: 280px;height: 44px"
                                   href="{{ $url }}"
                                   target="_blank">完成注册</a>
                            </div>
                        </div>
                        <div style="text-align:center;margin-top: 20px">
                            或复制以下网址到浏览器里直接打开：<br>
                            <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>