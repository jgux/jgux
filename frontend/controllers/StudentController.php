<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/18
 * Time: 17:47
 */

namespace frontend\controllers;


use frontend\models\Student;
use yii\web\Controller;
use yii\web\Request;

class StudentController extends Controller
{
    //显示首页
    public function actionIndex()
    {
        $models=Student::find()->all();

        return $this->render("index", ['models'=>$models]);
    }

    //声明一个添加方法
    public function actionAdd()
    {
        $student=new Student();
        $request=new Request();
        if($request->isPost){
            $student->load($request->post());
            //验证
            if($student->validate()){
                if($student->save()){
                    //跳转
                    return $this->redirect(["student/index"]);
                }
            }else{
                //TODO 验证错误
                var_dump($student->getErrors());exit;//验证错误一定要停止
            }
        }

        return $this->render("add",compact("student"));
    }


    //声明一个删除方法
    public function actionEdit($id)
    {
        $student=Student::findOne($id);
        $request=new Request();
        if($request->isPost){
            $student->load($request->post());
            //验证
            if($student->validate()){
                if($student->save()){
                    //跳转
                    return $this->redirect(["student/index"]);
                }
            }else{
                //TODO 验证错误
                var_dump($student->getErrors());exit;//验证错误一定要停止
            }
        }
        return $this->render("add",compact("student"));
    }

    //声明一个删除方法
    public function actionDel($id)
    {
        if(Student::findOne($id)->delete()){
            return $this->redirect(["index"]);
        }
    }


}