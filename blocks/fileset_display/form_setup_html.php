<?php  defined('C5_EXECUTE') or die("Access Denied."); ?> 

<?php

$max = $max > 0 ? $max : '';

?>

<p>
<?php echo $form->label('fsID', 'File Set'); ?> <?php echo $form->select('fsID', $this->controller->getAvailableFileSets(), $fsID)?>
</p>
<p>
<?php echo $form->label('fExts', 'File Extensions') ?> <?php echo $form->text('fExts', $fExts) ?>
<br/><small><?php echo t('A comma separated list of file extensions (e.g. "jpeg,jpg,gif,png"). All file types are shown by default.') ?></small>
</p>
<hr />
<p><?php echo t('Leave the sort options blank to sort by the library defaults.') ?></p>
<p>
<?php echo $form->label('max', 'Max Files to Display') ?> <?php echo $form->text('max', $max) ?> <small><?php echo t('Default is "0" (unlimited).') ?></small><br/>
<?php echo $form->label('sortBy', 'Sort By') ?> <?php echo $form->select('sortBy', $this->controller->getAvailableSortColumns(), $sortBy) ?><br/>
<?php echo $form->label('sortOrder', 'Sort Order') ?> <?php echo $form->select('sortOrder', $this->controller->getAvailableSortOrders(), $sortOrder) ?>
</p>

<hr />

<p>
<?php echo $form->label('linkTarget', 'Link Target') ?> <?php echo $form->text('linkTarget', $linkTarget) ?> <small><?php echo t('Default is "_blank".') ?></small>
</p>