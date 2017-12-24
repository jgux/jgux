#yii常用技术整理
1）controller-表单里面 提交->判定提交方式->绑定->验证
2）model-1设置属性{public $imgFile|code}-2设置规则-3设置label{别名} 
3）二级栏目 地址美化 原生sql 查询生成器 关联查询
4）添加关联数据表的下拉菜单-自身实现下拉菜单-分页-验证码-图片上传-过滤器-自动设置时间

  'timeZone'=>'PRC',
//'language'=>'zh-CN',
//'defaultRoute' =>'',
//'layout'=>'',
//public $layout =false;
##URL 地址完美化
```php
<?=\yii\helpers\Url::to(['goods/add'])?>
```
##原生sql语句对数据库操作
```php
    $query=Yii::$app->db->createCommand(“SELECT * FROM user”);
    queryAll()  queryOne()   Execute()	
    $userLists = $query->queryAll();
```
##查询生成器 $query = Query();
```php
    $userList=$query->select("*")->from('user')->where(['id'=>1])->one()|all()|join()|distinct()去重|limit()|max()|min()
```
##关联查询
```php
class Order extends ActiveRecord{
Public funcction getItems(){
Return $this->hasMany(Item::className(), [‘id’=>’item_id’]);
	}
}
```
##添加显示关联数据表的下拉菜单
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
##自身实现下拉菜单
```php
echo $form->field($model,"show")->dropDownList(
    \frontend\models\Book::find()->select(['show','id'])->indexBy('show')->column(),
    ['prompt'=>'请选择商品状态']
);
```
##分页的实现
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
##验证码
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
##实现图片的上传
```php
model中 [['imgFile'],'image','extensions' =>"jpg,gif,png",'skipOnEmpty' => false],];
controller中 
//上传图片
            $model->imgFile=UploadedFile::getInstance($model,"imgFile");
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
##自动设置创建时间和修改时间
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

#商品品牌
```
//品牌管理技术难点
  1 使用webUploader替换yii2原始的图片上传功能
  原拷贝文件参考：
  https://packagist.org/packages/bailangzhan/yii2-webuploader
  2 软删除技术的第一次使用
```

#文章-文章内容
```php
1 和文章表和文章分类表关联查询
//关联文章分类表查询 -关联查询技术 就近原则
    public function getDetail()
    {
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }
}
2 文章表自身状态栏做列表 
使用2个model技术
```

