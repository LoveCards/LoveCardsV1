$(".dza").click(function(){
	var dzan = $(this);
	var id = dzan.attr("rel"); //对应id
	$.ajax({
		type:"POST",
		url:"api.php",
		data:"state=zan&id="+id,
		cache:false, //不缓存此页面
		success:function(data){
			dzan.parent().find('.dianzan').text('喜欢'+data);
			dzan.fadeIn(300);
		}
	});
	var dzbtn = document.getElementById($(this).find('.mdi-cards-heart').attr("id"));
	dzbtn.style.color = "#fa5c7c";
	return false;
	exit();
});