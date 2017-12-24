<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/19
 * Time: 18:40
 */

namespace frontend\controllers;



use frontend\filters\TimeFilter;
use frontend\models\Author;
use frontend\models\Book;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BookController extends Controller
{
    //验证码
    public function actions()
    {
        return[
          'captcha'=>[
              'class' => 'yii\captcha\CaptchaAction',
              'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
              'minLength' => 4,
              'maxLength' => 5,
          ]
        ];
    }
    //显示视图
    public function actionIndex()
    {
        //显示数据$models=Book::find()->all();
        //做分页
        $query=Book::find()->orderBy("id");
        //获取总的条数
        $count=$query->count();
        //得到 分页对象
        $pag=new Pagination([
            'totalCount' => $count,
            'pageSize' => 4
        ]);
        $models=$query->offset($pag->offset)->limit($pag->limit)->all();

        return $this->render("index",compact("models","pag"));
    }

    //声明一个添加方法
    public function actionAdd()
    {
        $model=new Book();
        $author=Author::find()->asArray()->all();
        $authorArray=ArrayHelper::map($author,'author_id','author');
        //创建一个request对象
        $request=new Request();
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
            //上传图片
            $model->imgFile=UploadedFile::getInstance($model,"imgFile");
            //验证
            if($model->validate()===false){
                //TODO 修改错误
                var_dump($model->getErrors());exit;
            }
            //拼装图片路径
            $imgPath="images/".uniqid().".".$model->imgFile->extension;
            //保存图片到目录下
            if($model->imgFile->saveAs($imgPath,true)){
                $model->img=$imgPath;
                //保存数据 当有验证码的时候 需要给上false
                if($model->save(false)){
                    return $this->redirect(["index"]);
                }

            }

        }


        return $this->render("add", ['authorArray' => $authorArray, 'model' => $model]);
    }



    //声明一个删除方法
    public function actionDel($id)
    {
        //找到对象
        if (Book::findOne($id)->delete()) {
            return $this->redirect(["index"]);
        }
    }

    //声明一个编辑方法
    public function actionEdit($id)
    {
        $model=Book::findOne($id);
        $author=Author::find()->asArray()->all();
        $authorArray=ArrayHelper::map($author,'author_id','author');
        //创建一个request对象
        $request=new Request();
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
            //上传图片
            $model->imgFile=UploadedFile::getInstance($model,"imgFile");
            //验证
            if($model->validate()===false){
                //TODO 修改错误
                var_dump($model->getErrors());exit;
            }
            //拼装图片路径
            $imgPath="images/".uniqid().".".$model->imgFile->extension;
            //保存图片到目录下
            if($model->imgFile->saveAs($imgPath,true)){
                $model->img=$imgPath;
                //保存数据 当有验证码的时候 需要给上false
                if($model->save(false)){
                    return $this->redirect(["index"]);
                }
            }
        }
        return $this->render("edit", ['authorArray' => $authorArray, 'model' => $model]);

    }//end edit

//    //加载过滤器
//    public function behaviors()
//    {
//        return[
//          [
//              'class'=>TimeFilter::className()
//          ]
//        ];
//    }

    public function actionFilter()
    {
        ini_set('max_execution_time',0);
        for ($i=1;$i<100000;$i++){

        }

        echo "创建日志成功了<br>";

    }
    
}