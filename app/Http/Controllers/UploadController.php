<?php
/**
 * FileName: UploadController.php
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    private $mimeType = ['image/jpeg', 'image/png', 'image/gif'];

    /**
     * 编辑器ajax请求上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function uploadfile(Request $request)
    {
        if ($request->isMethod('POST')) {
            //普通附件保存
            if ($request->file('file')) {
                $file = $request->file('file');
                $basePath = 'attachment';
            }
            //上传用户头像
            if ($request->file('userface')){
                $basePath = 'avatar';
                $file = $request->file('userface');
            }

            //验证文件上传是否成功
            if ($file->isValid()) {
                $mime = $file->getClientMimeType();
                $ext = $file->getClientOriginalExtension();
                $size = $file->getClientSize();
                $realPath = $file->getRealPath();    //临时文件的绝对路径

                //验证mime类型是否合法
                if (!in_array($mime, $this->mimeType)) {
                    return response()->json([
                        'code' => 1,
                        'msg' => '文件类型不合法',
                        'data' => ['src' => '']
                    ]);
                }

                //验证图片大小是否合法
                if (($size/1024) > config('app.web_config.picSize')){
                    return response()->json([
                        'code' => 1,
                        'msg' => '文件不能超过500kb',
                        'data' => ['src' => '']
                    ]);
                }

                //构造文件保存路径
                $fileName = $basePath.'/'.date('Ym/', time()) . uniqid() . '.' . $ext;
                //保存文件
                $bool = Storage::disk('upload')->put($fileName, file_get_contents($realPath));

                //判断文件保存结果
                if ($bool) {
                    return response()->json([
                        'code' => 0,
                        'msg' => '',
                        'data' => ['src' => '/uploads/' . $fileName]
                    ]);
                } else {
                    return response()->json([
                        'code' => 1,
                        'msg' => '文件上传失败',
                        'data' => ['src' => '']
                    ]);
                }
            }
        }

        return redirect('/');
    }
}