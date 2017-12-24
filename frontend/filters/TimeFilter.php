<?php
/**
 * Created by PhpStorm.
 * User: 蒋国兴
 * Date: 2017/12/20
 * Time: 15:12
 */

namespace frontend\filters;


use yii\base\ActionFilter;

class TimeFilter extends ActionFilter
{
    private $time;
    //在方法之前
    public function beforeAction($action)
    {
        $this->time=microtime(true);
        return parent::beforeAction($action);
    }

    //在方法执行之后执行
    public function afterAction($action, $result)
    {
        $endTime=date("Y-m-d H:i:s");
        //创建一个文件 并写入里面
        $TxtFileName=fopen('log.txt','a');
        $ip=\Yii::$app->request->userIP;
        $content= "用户".$ip."执行当前方法{$action->uniqueId}所耗时".(microtime(true)-$this->time)."写入时间为".$endTime."\n";
        fwrite($TxtFileName,$content);

        return parent::afterAction($action, $result);
    }
}