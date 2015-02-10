<?php
/**
 * CTreeGridView class file.
 *
 */

Yii::import('zii.widgets.grid.CGridView');

class CQTreeBsGridView extends BsGridView
{

    /**
     * Initializes the tree grid view.
     */
    public function init()
    {
		parent::init();
		foreach($this->dataProvider->data as $model) {
			$separator = '';
			for ($x=1; $x++ < $model->level;) $separator .= ' - ';
			/*
			if($model->level == 2)	{
				$model->name = '<strong>'.$separator.$model->name.'</strong>';
			}	else	{
				$model->name = $separator.$model->name;
			}
			*/
			$model->name = $separator.$model->name;
		}
    }
}
