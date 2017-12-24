<form action="" method="post">
    商品名：<input type="text" name="goods_name" value="<?=$good['goods_name']?>"><br/>
    商品编号：<input type="text" name="goods_id" value="<?=$good['goods_id']?>"><br/>
    商品价格：<input type="text" name="goods_pric" value="<?=$good['goods_pric']?>"><br/>
    <input type="hidden" name="id" value="<?=$good['id']?>">
    <input type="submit" value="提交">
</form>