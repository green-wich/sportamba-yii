<?php
/**
 * Customized CGridView to use styles from bootstrap
 */
Yii::import('zii.widgets.grid.CGridView');
class BGridView extends CGridView
{
    public $htmlOptions = array(
        'class' => '',
    );
    public $itemsCssClass = 'table table-striped table-bordered table-condensed';
    public $summaryCssClass = 'pull-right';
    public $pagerCssClass = 'pull-right';
    public $pager = array('class' => 'BLinkPager');

}
