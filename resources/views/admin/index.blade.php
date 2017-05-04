@extends('admin.common_admin')
@section('content')
    <div class="mbnav">
        <span class="layui-breadcrumb"><a><cite>您好! 欢迎来到后台主页</cite></a></span>
    </div>

    @include('layout.message')

{{------------------------------------------------------------------}}
    <!--服务器相关参数-->
    <table class="layui-table">
        <tr><th colspan="4">服务器参数</th></tr>
        <tr>
            <td>IP地址</td>
            <td colspan="3"><?php echo $_SERVER['REMOTE_ADDR'];?></td>
        </tr>
        <tr>
            <td width="13%">服务器操作系统</td>
            <td width="37%"><?php $os = explode(" ", php_uname()); echo $os[0];?> &nbsp;内核版本：<?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?></td>
            <td width="13%">服务器解译引擎</td>
            <td width="37%"><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
        </tr>
        <tr>
            <td>服务器语言</td>
            <td><?php echo getenv("HTTP_ACCEPT_LANGUAGE");?></td>
            <td>服务器端口</td>
            <td><?php echo $_SERVER['SERVER_PORT'];?></td>
        </tr>
        <tr>
            <td>管理员邮箱</td>
            <td><?php echo $_SERVER['SERVER_ADMIN'];?></td>
            <td>绝对路径</td>
            <td><?php echo $_SERVER['DOCUMENT_ROOT']?str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']):str_replace('\\','/',dirname(__FILE__));?></td>
        </tr>
    </table>

    <?php
    //检测PHP设置参数
    function show($varName)
    {
        switch($result = get_cfg_var($varName))
        {
            case 0:
                return '<font color="red">×</font>';
                break;

            case 1:
                return '<font color="green">√</font>';
                break;

            default:
                return $result;
                break;
        }
    }

    // 检测函数支持
    function isfun($funName = '')
    {
        if (!$funName || trim($funName) == '' || preg_match('~[^a-z0-9\_]+~i', $funName, $tmp)) return '错误';
        return (false !== function_exists($funName)) ? '<font color="green">√</font>' : '<font color="red">×</font>';
    }
    function isfun1($funName = '')
    {
        if (!$funName || trim($funName) == '' || preg_match('~[^a-z0-9\_]+~i', $funName, $tmp)) return '错误';
        return (false !== function_exists($funName)) ? '√' : '×';
    }
    ?>

<table class="layui-table">
    <tr><th colspan="4">PHP相关参数</th></tr>
    <tr>
        <td width="30%">PHP运行方式：</td>
        <td width="20%"><?php echo strtoupper(php_sapi_name());?></td>
        <td width="30%">脚本占用最大内存（memory_limit）：</td>
        <td width="20%"><?php echo show("memory_limit");?></td>
    </tr>
    <tr>
        <td>上传文件最大限制（upload_max_filesize）：</td>
        <td><?php echo show("upload_max_filesize");?></td>
        <td>POST方法提交最大限制（post_max_size）：</td>
        <td><?php echo show("post_max_size");?></td>
    </tr>
    <tr>
        <td>脚本超时时间（max_execution_time）：</td>
        <td><?php echo show("max_execution_time");?>秒</td>
        <td>socket超时时间（default_socket_timeout）：</td>
        <td><?php echo show("default_socket_timeout");?>秒</td>
    </tr>
    <tr>
        <td>打开远程文件（allow_url_fopen）：</td>
        <td><?php echo show("allow_url_fopen");?></td>
        <td>声明argv和argc变量（register_argc_argv）：</td>
        <td><?php echo show("register_argc_argv");?></td>
    </tr>
    <tr>
        <td>PDF文档支持：</td>
        <td><?php echo isfun("pdf_close");?></td>
        <td>Curl支持：</td>
        <td><?php echo isfun("curl_init");?></td>
    </tr>
    <tr>
        <td>SMTP支持：</td>
        <td><?php echo get_cfg_var("SMTP")?'<font color="green">√</font>' : '<font color="red">×</font>';?></td>
        <td>SMTP地址：</td>
        <td><?php echo get_cfg_var("SMTP")?get_cfg_var("SMTP"):'<font color="red">×</font>';?></td>
    </tr>
</table>



























@stop

@section('script')
<script>

</script>
@stop