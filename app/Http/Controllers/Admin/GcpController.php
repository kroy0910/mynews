<?php
# includes the autoloader for libraries installed with composer
namespace App\Http\Controllers\Admin;

# 最初にterminalで下記コマンドを実行（環境変数のjsonファイルを設定）
# export GOOGLE_APPLICATION_CREDENTIALS="vision_api_key.json"
# terminalではなくphpのコード内で環境変数の変更
putenv('GOOGLE_APPLICATION_CREDENTIALS=storage/json/vision_api_key.json');

# require __DIR__ . '/vendor/autoload.php'; #error になる
require base_path() . '/vendor/autoload.php';

# imports the Google Cloud client library
# use vendor\google\cloudvision\src\V1\ImageAnnotatorClient; method not foundになる
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GcpController extends Controller
{
    # 画像をアップロードするページを表示
    public function imageUp (){
        return view("admin.gcp.imageUp");
    }
    
    // 受け取った画像をgcpの機械学習に判定させる
    // 機械学習の答えを返す（画像、名前、信頼度）
    public function imageAnno (Request $request){
        # instantiates a client
        $imageAnnotator = new ImageAnnotatorClient(
#        'credentials' => 'storage/json/vision_api_key.json'
        );

        # the name of the image file to annotate(requestから読み込む)
        $image = $imageAnnotator->createImageObject(file_get_contents($request->image));
         # 直接読み込む方法(テスト用)
         # $image = $imageAnnotator->createImageObject(file_get_contents(public_path('/pic/data/de-7017.jpg')));

         # prepare the image to be annotated(googleのdefault文だが上記で処理を繋げたので不要)
         # $image = file_get_contents($fileName);

        # performs label detection on the image file
        $response = $imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        if(!is_null($$response->getError())){
            return ['result' => false];
        }
        
        $annotations = $response->getLabelAnnotations();
        
# labelとscoreを全て取得
#        foreach($annotations as $description){
#            $description = $annotations->getDescription();
#             \Debugbar::info($description);
#            $score       = $annotations->getScore();
#             \Debugbar::info($score);
#        }
 
# labelとscoreの上位1つを取得
            $description = $annotations[0]->getDescription();
             \Debugbar::info($description);
            $score       = $annotations[0]->getScore();
             \Debugbar::info($score);
             
# フォームから送信されてきた_tokenを削除する
            unset($form['_token']);
# フォームから送信されてきたimageを削除する
            unset($form['image']);
            
# viewに配列で値を返す
        return view("admin.gcp.imageAnno",[
            "label"  => $description,
            "score"  => $score,
            ]);
        
    }
}
