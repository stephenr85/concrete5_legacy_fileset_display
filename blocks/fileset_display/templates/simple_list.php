<?php 
	$files = $this->controller->getFiles();
	$fh = Loader::helper('file');
	
	echo '<ul class="list-fileset simple">';
	foreach($files as $file){
		$fileSize = ($file->getFullSize() < 1048576) ? $file->getSize() : round($file->getFullSize()/1048576, 2).t('MB');		
		echo '<li data-fileId="'.$file->getFileID().'" class="'.$file->getExtension().'"><a href="'.$file->getRelativePath().'" target="'.$this->controller->getLinkTarget().'">';
		echo '<span class="file-title">'.$file->getTitle().'</span>';
		echo '</a> <span class="file-info"><span class="file-type '.$file->getExtension().'">'.$file->getType().'</span> <span class="file-size">'.$fileSize.'</span></span></li>';
	}
	if(count($files) < 1){
		echo '<li class="no-results"><span>'.t('No files to display in "%s".', $this->controller->getFileSetName()).'</span></li>';	
	}
	echo '</ul>';


?>