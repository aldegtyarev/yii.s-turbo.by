$(function(){
	$('#myTab a[href=\"#tab1\"]').tab('show'); // Выбор вкладки по имени
    $('#myTab a').click(function(e){
		e.preventDefault();
    	$(this).tab('show');
    })
})