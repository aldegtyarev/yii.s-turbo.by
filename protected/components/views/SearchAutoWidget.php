<div class="search-auto-block clearfix">
	<form id="searchautoform" action="" method="post">
		<div class="search-auto-block-title">Поиск по автомобилю</div>
		<div id="search-auto-form" class="search-auto-form">
			<a href="javascript:void(0)" id="clear-search-auto" class="clear-search-auto">Сбросить фильтр автомобиля</a>
			<input type="hidden" name="clear-search-auto" value="0" />
			<div class="step1 step-wr">
				<span class="step-num">1</span>
				<? echo CHtml::dropDownList('select-marka', $select_marka, $markaDropDown, array('empty' => 'Выберите марку')) ?>
			</div>
			<div class="step2 step-wr">
				<span class="step-num">2</span>
				<span id="select-model-wr">
					<? echo CHtml::dropDownList('select-model', $select_model, $modelDropDown, array('empty' => 'Выберите модель')) ?>
				<?/*
				<select name="select-model" id="select-model">
					<option value="">Выберите модель</option>	
				</select>
				*/ ?>
				</span>
			</div>
			<div class="step3 step-wr">
				<span class="step-num">3</span>
				<span id="select-year-wr">
					<? echo CHtml::dropDownList('select-year', $select_year, $yearDropDown, array('empty' => 'Выберите год')) ?>
					<?/*
					<select name="select-year" id="select-year">
						<option value="">Выберите год</option>	
					</select>
					*/ ?>
				</span>
			</div>

			<button class="search-auto-button"> </button>		
		</div>
	</form>
	
	
</div>