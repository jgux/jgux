
<script type="text/css">
    ul,li{
        margin:0;
        padding:0;
    }
    ul{
        width:100px;
        /*height:300px;*/
        background:red;
        list-style: none;
    }
    ul>.operate{
        display:none;
    }

    ul:hover>.operate{
        display:block;
    }

</script>

<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['add'])?>">添加</a>
<!--<a class="btn btn-success" href="<?/*=\yii\helpers\Url::to(['show'])*/?>">回收站</a>-->
<table class="table table-bordered">
    <tr>
        <td>展示|隐藏</td>
        <td>id</td>
        <td>名称</td>
        <td>左值</td>
        <td>右值</td>
        <td>parent_id</td>
        <td>深度</td>
        <td>树</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($models as $model): ?>
        <tr lft="<?=$model->lft?>" rgt="<?=$model->rgt?>" tree="<?=$model->tree?>">
            <td><span class="glyphicon glyphicon-plus cate"></span></td>
            <td><?=$model['id']?></td>
            <td><?=str_repeat("&nbsp;",$model->depth*5).$model['name']?></td>
            <td><?=$model['lft']?></td>
            <td><?=$model['rgt']?></td>
            <td><?=$model['parent_id']?></td>
            <td><?=$model['depth']?></td>
            <td><?=$model['tree']?></td>
            <td><?=$model['intro']?></td>

            <td>
                <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['edit','id'=>$model->id])?>" role="button">编辑</a>
                <!--<a class="btn btn-success" href="<?/*=\yii\helpers\Url::to(['callback','id'=>$model->id])*/?>" role="button">隐藏</a>-->
                <a class="btn btn-danger" href="<?=\yii\helpers\Url::to(['del','id'=>$model->id])?>" role="button">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
/* @var $this yii\web\View */
    $js=<<<js
    $(".cate").click(function(){
        //换图片
       $(this).toggleClass("glyphicon-minus-sign");
       $(this).toggleClass("glyphicon-plus-sign");
        //找到对应的tr
        var tr=$(this).parent().parent();
        var lft=tr.attr('lft');
        var rgt=tr.attr('rgt');
        var tree=tr.attr('tree');
        //console.dir(lft);
        //得到所有的tr
        var trs=$("tr");
        //根据左值右值来判定 左边好判断（递增） 右边（反之） 还要满足一颗树
        $.each(trs,function(k,v){
            var lftPer=$(v).attr('lft');
            var rgtPer=$(v).attr('rgt');
            var treePer=$(v).attr('tree');            
         if(lftPer - lft>0 && rgtPer - rgt<0 && tree==treePer){
            //这里有问题 不能用这种方法 $(v).toggle();
            //判定父类是不是展开状态
            if(tr.find('span').hasClass('glyphicon-minus-sign')){
                $(v).find('span').removeClass('glyphicon-plus-sign');
                $(v).find('span').addClass('glyphicon-minus-sign');
                $(v).hide();
            }else{//闭合状态
                $(v).find('span').removeClass('glyphicon-minus-sign');
                $(v).find('span').addClass('glyphicon-plus-sign');
                $(v).show();
            }           
          } 
            
        })
        
    });

js;
$this->registerJs($js);
?>



