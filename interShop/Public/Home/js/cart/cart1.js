$(function(){
// 减少
    $(".btn-dec").on("click",function(){
        var parent = $(this).parent().parent();
        var inpNum = parent.find("input");
        var num = parent.find("input").val();
        var tr = parent.parent();
        if(num>1) num--;
        else num=1;
        parent.find("input").val(num);
        // 执行ajax
        // 找到所在的tr标签
        var goodsId = tr.attr("goods_id");
        var goodsAttrId = tr.attr("goods_attr_id_list");
        updataCartGoodsNum(goodsId,goodsAttrId,$(inpNum).val());
        // 小计
        var subtotal = parseFloat($(tr).find("#onepace span").text()) * parseInt($(inpNum).val());
        $(tr).find(".amount span").text(subtotal.toFixed(2));
        // 总计
        var total = 0;
        $(".amount span").each(function(){
            total += parseFloat($(this).text());
        });
        $(".cart-total").text(total.toFixed(2));

    });
    // 增加
    $(".btn-add").on("click",function(){
        var parent = $(this).parent().parent();
        var inpNum = parent.find("input");
        var num = parent.find("input").val();
        var tr = parent.parent();
        num++;
        parent.find("input").val(num);
        // 执行ajax
        // 找到所在的tr标签
        var goodsId = tr.attr("goods_id");
        var goodsAttrId = tr.attr("goods_attr_id_list");
        updataCartGoodsNum(goodsId,goodsAttrId,$(inpNum).val());
        // 小计
        var subtotal = parseFloat($(tr).find("#onepace span").text()) * parseInt($(inpNum).val());
        $(tr).find(".amount span").text(subtotal.toFixed(2));
        // 总计
        var total = 0;
        $(".amount span").each(function(){
            total += parseFloat($(this).text());
        });
        $(".cart-total").text(total.toFixed(2));
    });
    //  直接输入
    $(".buy-num-bar input").on("change",function(){
        var num = parseInt($(this).val());
        if(num < 1){
            alert("商品数量最少为1");
            $(this).val(1);
        }
        var parent = $(this).parent().parent();
        var tr = parent.parent();
        var goodsId = tr.attr("goods_id");
        var goodsAttrId = tr.attr("goods_attr_id_list");
        updataCartGoodsNum(goodsId,goodsAttrId,$(this).val());
        // 小计
        var subtotal = parseFloat($(tr).find("#onepace span").text()) * parseInt($(this).val());
        $(tr).find(".amount span").text(subtotal.toFixed(2));
        // 总计
        var total = 0;
        $(".amount span").each(function(){
            total += parseFloat($(this).text());
        });
        $(".cart-total").text(total.toFixed(2));

    });
});