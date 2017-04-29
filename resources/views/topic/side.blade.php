

<div class="side-container">
    <div class="box-title">社区公告</div>
    <div class="box-brief announcement">
        为了创造良好的社区氛围，有效率地处理站长反馈，现对发帖规范和版规进行如下规范：发帖规范（1）发表话题，要选择对应问题的#标签#（2）描述问题，上传截图，请备注站点信息，包含问题链接，最好有站点ID（在概况里），方便问题查找追踪。快站运营人员会在两小时内给出回复，对于高频问题或需求我们会在置顶、加精话题及时给出反馈。版规公告话题和回复：1.&nbsp;符合文明健康，规范有序的网络环境2.&nbsp;符合社区定位，选择对应问题的话题标签3.&nbsp;不能损害快站利益4.&nbsp;不刻意水贴5.&nbsp;不能出现诱导分享内容馈。违规惩罚（1）不符合社...
    </div>
</div>

<div class="side-container">
    <div class="box-title">热门话题</div>
    <div class="box-brief">
        <ul class="hotopic">
            @foreach($hotTopics as $hot)
                <li><a href="{{ url('topic/'.$hot['tid']) }}" title="{{ $hot['title'] }}" target="_blank">{{ str_limit($hot['title'],60) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="side-container">
    <div class="box-title">微信关注</div>
    <div class="box-brief code-content">
        <img src="http://pic.kuaizhan.com/g2/M01/56/EE/CgpQVFiz0XiAUsvOAAFj0jOqtlE644.jpg">
        <span>关注收取回复提醒</span>
    </div>
</div>