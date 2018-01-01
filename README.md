# 1品牌
## 需求
1.品牌表的CURD  
2.使用逻辑删除
## 流程
建表-增删改查-回收站
## 设计要点
logo,sort,status
## 难点及解决方案
1.逻辑删除只改变status属性,不删除记录  
2.图片上传使用能够webuploader插件    
3.使用composer下载和安装webuploader 
4.图片上传到七牛云oss对象存储
# 2文章-文章内容
## 需求
1.文章分类,文章表,文章内容表的增删改查  
2.要有文章分类表,文章详情表
## 流程
1.先设计文章分类表  
2.通过分类表创建文章表  
3.通过文章表建立内容表  
4.所有表的增删改查
## 设计要点
采用分表技术
## 难点及解决方案
```php
1 和文章表和文章分类表关联查询
//关联文章分类表查询 -关联查询技术 就近原则
2 文章表自身状态栏做列表 
使用2个model技术
```
# 3商品分类表
## 需求
商品分类表的CURD
## 流程
1.composer下载安装nested 插件  
2.利用左值|右值技术建表,添加数据  
3.composer下载安装ztree插件  
4.页面实现无限极分类展示
## 设计要点
无限极分类
## 难点及解决方案
1.利用nested插件 左值|右值来实现无限极分类  
2.多树的时候一定要记得开启'treeAttribute' => 'tree'  
3.利用ztree插件 来展现无限极分类  
4.多图的上传和搜索功能的实现
# yii2-富文本框[git搜索 - yii2 qiniu]

https://github.com/search?utf8=%E2%9C%93&q=yii2+uedit&type=
controller中
public function actions()
{
    return [
        'upload' => [
            'class' => 'kucha\ueditor\UEditorAction', //图片处理
        ]
    ];
}
view中
echo $form->field($model,'colum')->widget('kucha\ueditor\UEditor',[]);
	
# yii2-七牛云{CDN技术}[git搜索 - yii2 uedit]

https://github.com/flyok666/yii2-qiniu
controller中
$config = [

            'accessKey' => 'EAd29Qrh05q78_cZhajAWcbB1wYCBLyHLqkanjOG',//AK
            'secretKey' => '_R5o3ZZpPJvz8bNGBWO9YWSaNbxIhpsedbiUtHjW',//SK
            'domain' => 'http://p1ht4b07w.bkt.clouddn.com',//临时域名
            'bucket' => 'php0830',//空间名称
            'area' => Qiniu::AREA_HUADONG//区域
        ];
$qiniu = new Qiniu($config);//实例化对象
//var_dump($qiniu);exit;
        $key = time();//上传后的文件名  多文件上传有坑      
        $qiniu->uploadFile($_FILES['file']["tmp_name"], $key);//调用上传方法上传文件
        $url = $qiniu->getLink($key);//得到上传后的地址       
//返回的结果
        $result = [
            'code' => 0,
            'url' => $url,
            'attachment' => $url

        ];
        return json_encode($result);               
# 分类-左值|右值

github-搜索 yii2-nested
https://github.com/creocoder/yii2-nested-sets
注意事项：多树的时候记得一定要开始 'treeAttribute' => 'tree',
添加子类的时候 1->找到父类 2->新建一个子类 3->追加到父类

# ztree-树插件
github-搜索 yii2-ztree
https://github.com/liyuze/yii2-ztree
开启所有的分类展示 view中
<?php
    $js=<<<EOF
    //console.dir(111);
    var treeObj = $.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);
    
EOF;
    $this->registerJs($js);
?>

# yii常用技术整理
1）controller-表单里面 提交->判定提交方式->绑定->验证
2）model-1设置属性{public $imgFile|code}-2设置规则-3设置label{别名} 
3）二级栏目 地址美化 原生sql 查询生成器 关联查询
4）添加关联数据表的下拉菜单-自身实现下拉菜单-分页-验证码-图片上传-过滤器-自动设置时间

  'timeZone'=>'PRC',
//'language'=>'zh-CN',
//'defaultRoute' =>'',
//'layout'=>'',
//public $layout =false;
## URL 地址完美化
```php
<?=\yii\helpers\Url::to(['goods/add'])?>
```
## 原生sql语句对数据库操作
```php
    $query=Yii::$app->db->createCommand(“SELECT * FROM user”);
    queryAll()  queryOne()   Execute()	
    $userLists = $query->queryAll();
```
## 查询生成器 $query = Query();
```php
    $userList=$query->select("*")->from('user')->where(['id'=>1])->one()|all()|join()|distinct()去重|limit()|max()|min()
```
## 关联查询
```php
class Order extends ActiveRecord{
Public funcction getItems(){
Return $this->hasMany(Item::className(), [‘id’=>’item_id’]);
	}
}
```
## 认证user组件-RBAC授权
http://www.yiichina.com/doc/guide/2.0/security-authorization#rbac
RBAC授权 1公共文件中配置 2建立RBAC需要的表-5张基本表 3创建角色 4判定权限
```php
 //1. 添加角色
    public function actionRole($name)
    {
        //实例化组件对象
        $auth = \Yii::$app->authManager;
        //创建一个角色对象
        $role=$auth->createRole($name);
        $role->description="角色名".$name;
        //添加角色入库
        $auth->add($role);
    }
    //2. 添加权限
    public function actionPer($name){
        //实例化组件对象
        $auth = \Yii::$app->authManager;
        //创建一个权限对象
        $per=$auth->createPermission($name);
        //添加权限入库
        $auth->add($per);
    }
    //3. 给角色添加权限   权限的名称通常是路由 goods/index
    public function actionRolePer($roleName,$perName){
        //实例化组件对象
        $auth = \Yii::$app->authManager;
        //3.1 找到角色
        $role=$auth->getRole($roleName);
        //3.2 找到权限
        $per=$auth->getPermission($perName);
        //3.3. 关联角色和权限
        $auth->addChild($role,$per);
    }
    //4. 把用户分配到角色
    public function actionAdminRole($id,$roleName){
        //实例化组件对象
        $auth = \Yii::$app->authManager;
        //4.1 找到用户Id
        //4.2 找到角色对象
        $role=$auth->getRole($roleName);
        //4.3 把用户放到角色中
        $auth->assign($role,$id);
    }
    //判断当前用户有没有权限
    public function actionHasPer($name){
        //实例化组件对象
      //  $auth = \Yii::$app->authManager;
        //判断用户有没有权限

        var_dump(\Yii::$app->user->can($name));
    }
```
## 添加显示关联数据表的下拉菜单
```php
//得到所有分类的数组数据
        $cates = Category::find()->asArray()->all();
        //把数组转化键值对
        $catesArray = ArrayHelper::map($cates, 'id', 'name');
插入add页面
	echo $form->field($good,'cate_id')->dropDownList($catesArray);
index页面
<td><?=\backend\models\Article::findOne($model['id'])->detail{方法名}->content?></td>
```
## 自身实现下拉菜单
```php
echo $form->field($model,"show")->dropDownList(
    \frontend\models\Book::find()->select(['show','id'])->indexBy('show')->column(),
    ['prompt'=>'请选择商品状态']
);
```
## 分页的实现
```php
//controller中
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
//view中
	<?=\yii\widgets\LinkPager::widget(['pagination' => $pag])?>
```
## 验证码
```php
//验证码：在 config-man.php-action方法里面
controller中声明一个action方法  中model中需要添加一个code属性来临时存放验证码
 return[
          'captcha'=>[
              'class' => 'yii\captcha\CaptchaAction',
              'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
              'minLength' => 4,
              'maxLength' => 5,
          ]
        ];
//view中 原yii模板在views-site-contact
echo $form->field($model,"code")->widget(
    yii\captcha\Captcha::className(),[
        'captchaAction' => 'book/captcha',
        'template' =>'<div class="row"><div class="col-lg-1">{input}</div><div class="col-lg-1">{image}</div></div>',
    ]
);
```
## 实现图片的上传
```php
model中 [['imgFile'],'image','extensions' =>"jpg,gif,png",'skipOnEmpty' => false],];
controller中 
//上传图片           $model->imgFile=UploadedFile::getInstance($model,"imgFile");
//拼装图片路径
            $imgPath="images/".uniqid().".".$model->imgFile->extension;
            //保存图片到目录下
            if($model->imgFile->saveAs($imgPath,true)){
            $model->img=$imgPath;
//视图中
	<?=\yii\bootstrap\Html::img("/".$model->img,["height"=>40])?>
//过滤器
	namespace-命名空间 过滤继承ActionFilter
	在方法之前自动执行-beforeAction-后执行-afterAction
	return parent::berfor|after 一定不能少
	获取当前的路由{$action->uniqueId}v  
```
## 自动设置创建时间和修改时间
```php
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    //插入的时候需要自动创建的时间 create_time 表中创建的时间  update_time 更新时间
                    ActiveRecord::EVENT_BEFORE_INSERT=>['create_time','update_time'],
                    //修改的时候需要自动修改的时间
                    ActiveRecord::EVENT_BEFORE_UPDATE=>['update_time']
                ]
            ]
        ];
    }
```
