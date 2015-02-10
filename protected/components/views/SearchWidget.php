<div class="search-block floatRight">
	<form action="/" method="post">
		<input name="searchword" id="search-searchword" maxlength="20" class="inputbox searchbox" type="text" size="20" value="Поиск по каталогу" onblur="if (this.value=='') this.value='Поиск по каталогу';" onfocus="if (this.value=='Поиск по каталогу') this.value='';">
		<input type="submit" value="&nbsp;" class="search-btn" onclick="this.form.searchword.focus();">	
		<input type="hidden" name="task" value="search">
	</form>
</div>