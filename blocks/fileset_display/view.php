<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	echo '<table width="100%" class="tbl-fileset"><thead><tr><th>Date</th><th>Title</th></tr></thead><tbody>';
	foreach($files as $file){
		$fileDate = strtotime($file->getDateAdded());
		echo '<tr data-fileId="'.$file->getFileID().'" class="file-'.$file->getFileID().' '.$file->getType().'">';
		echo '<td class="file-date">'.date('Y-m-d', $fileDate).'</td>';
		echo '<td class="file-title"><a href="'.$file->getDownloadURL().'" target="'.$this->controller->getLinkTarget().'">'.$file->getTitle().'</a></td>';
		echo '</tr>';
	}
	if(count($files) < 1){
		echo '<tr class="no-results"><td colspan="2">'.t('No files to display in "%s".', $this->controller->getFileSetName()).'</td></tr>';	
	}
	echo '</tbody></table>';

?>