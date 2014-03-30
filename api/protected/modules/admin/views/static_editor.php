<?php
/**
 * @var PageController $this
 */
?>
<div class="container">
    <div class="row">
        <div class="span2">
            <div class="">
                <?php $this->widget('BSideMenu', array('items' => $this->sideMenu));?>
            </div>
        </div>
        <div class="span10">
            <?php echo $content;?>
        </div>
    </div>
</div>