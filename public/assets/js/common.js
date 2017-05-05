window.onload = function () {

    isLogin();
    selectCategory();

    layui.use('layedit', function () {
        var layedit = layui.layedit;
        layedit.set({
            uploadImage: {
                url: '/attachment/upload'
            }
        });
        var editor_status = $('#single').attr('long');
        var e_height = editor_status ? 400 : 200;
        layedit.build('editor-content', {
            height: e_height
        });
    });

    /*登陆状态*/
    function isLogin() {
        var userObj = document.getElementById('user-status');
        if (userObj) {
            var menuObj = document.getElementById('user-menu');
            var arrowObj = document.getElementById('user-arrow');
            userObj.onmouseover = function () {
                menuObj.style.display = 'block';
                arrowObj.className = 'header-worra';
            };
            userObj.onmouseout = function () {
                menuObj.style.display = 'none';
                arrowObj.className = 'header-arrow';
            };
        }
    }

    /*选择分类*/
    function selectCategory() {
        var cateogryObj = document.getElementById('cateogry');
        if (cateogryObj) {
            var cateCurrent = document.getElementById('cate-current');
            var cateIds = document.getElementById('cate-ids');
            var aTags = cateIds.getElementsByTagName('a');
            var flag = true;

            cateCurrent.onclick = function () {
                cateIds.style.display = 'block';
                flag = !flag;
            };

            for (var v in aTags) {
                aTags[v].onclick = function () {
                    var attrVal = this.getAttribute('data-cid');
                    cateogryObj.value = attrVal;
                    cateCurrent.innerText = this.innerText;
                    cateIds.style.display = 'none';
                };
            }
            ;
        }
    }
};

$(function () {
    $('.commentListItem-reply').click(function () {
        var place = $(this).closest('.comtop').find('.reply-editor');
        var openVal = $(this).attr('isopen');
        var usid = $(this).attr('data-uid');
        var tid = $(this).attr('data-tid');
        var username = $(this).attr('data-username') ? '@' + $(this).attr('data-username') + ':' : '';
        var comid = place.attr('data-comid');
        var sendUrl = $('.editor-main form').prop('action');
        var _token = $('.editor-main input[name=_token]').val();
        var geetest = $('#geetest_div').html();

        var str = '<div class="editor-content" style="padding: 20px 0 0;"><form action="' + sendUrl + '" method="post"><input type="hidden" name="_token" value="' + _token + '"><div class="editor-pub-content"><input type="hidden" name="tid" value="' + tid + '" /><input type="hidden" class="usid" name="at_uid" value="' + usid + '" /><input type="hidden" class="comid" name="pid" value="' + comid + '" /><textarea class="tinyce-editor" name="comment" id="editor-content-' + comid + '">' + username + '</textarea></div>'+geetest+'<button class="editor-pub-button" type="submit" id="send-editor-content"><i class="k-i-edit"></i><span class="pub-text">发表回复</span></button></form></div>';

        if (openVal == 'off') {
            $('.reply-editor').empty();
            $('.commentListItem-reply').attr('isopen', 'off');
            $(place).html(str);
            /*loading editor*/
            layui.use('layedit', function () {
                var layedits = layui.layedit;
                layedits.set({
                    uploadImage: {
                        url: '/attachment/upload'
                    }
                });
                layedits.build('editor-content-' + comid, {height: 140});
            });
            $(this).attr('isopen', 'on')
        } else {
            place.empty();
            $(this).attr('isopen', 'off')
        }
    });

    //关闭提示信息
    $('.Huialert .icon-remove').on('click', function () {
        $(this).closest('.message-tips').remove();
    });
});