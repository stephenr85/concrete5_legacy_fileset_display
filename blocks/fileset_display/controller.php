<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	class FileSetDisplayBlockController extends BlockController {
		
		protected $btDescription = "A block for displaying file sets.";
		protected $btName = "File Set Display";
		protected $btTable = 'btFileSetDisplay';
		protected $btInterfaceWidth = "500";
		protected $btInterfaceHeight = "300";
			
		protected $attrList = NULL;
		
		function getFileSet(){
			return $fs = FileSet::getByID($this->fsID);
		}
		
		function getFileSetName(){
			$fs = $this->getFileSet();
			if(is_object($fs)){
				return $fs->getFileSetName();	
			}
		}
		
		function getFileList(){
			Loader::model('file_list');				
			Loader::model('file_set');			
	
			$fs = $this->getFileSet();
			$fileList = new FileList();		
			$fileList->filterBySet($fs);

			return $fileList;
		}
		
		function getFiles($sortBy=NULL, $sortOrder=NULL, $max=NULL, $offset=0){			
			if (intval($this->fsID) < 1) {
				return FALSE;
			}
			$fileList = $this->getFileList();
			//$fileList->debug();
			//Filter the extensions
			$exts = $this->getFileExtensions();

			if(is_array($exts)){
				foreach($exts as $ext){
					$fileList->filterByExtension($ext);	
				}
			}
					
			//All that sorting
			if(empty($sortBy)){
				$sortBy = $this->sortBy;				
			}
			
			if(!empty($sortBy) && is_numeric($sortBy)){				
				Loader::model('file_attributes');
				//assume it's an attribute key ID
				$sortBy = intval($sortBy);
				$attr = FileAttributeKey::getByID($sortBy);
				$sortBy = 'ak_'.$attr->getKeyHandle();
			}			
			
			if(empty($sortOrder)){
				$sortOrder = !empty($this->sortOrder) ? $this->sortOrder : 'asc';	
			}
			
			if(empty($sortBy)){
				//Sort by display order
				$fileList->sortByFileSetDisplayOrder();
			}else if(is_array($sortBy)){
				//Multi sort
				call_user_func_array(array($fileList, 'sortByMultiple', $sortBy));				
			}else if(is_string($sortBy)){
				//Regular ol' sort
				$fileList->sortBy($sortBy, $sortOrder);
			}
			
			$limit = is_null($max) ? $this->max : $max;
			if(empty($limit)) $limit = 9999;
			
			//$this->pre($fileList->getQuery());
			$files = $fileList->get($limit, $offset);
			
			return $this->files = $files;
		}
		
		
		function getAvailableFileSets(){
			Loader::model('file_set');
			$sets = FileSet::getMySets();
			$options = array();
			foreach ($sets as $set){
				$options[$set->getFileSetID()] = $set->getFileSetName();
			}
			return $options;
		}
		
		
		function getAvailableSortColumns(){
			Loader::model('file_attributes');
			Loader::model('file_list');
			
			$fmcs = new FileManagerAvailableColumnSet();
			$cols = $fmcs->getColumns();
			
			$options = array(''=>'Auto');
			foreach($cols as $col){
				$options[$col->getColumnKey()] = $col->getColumnName();
			}
			
			$attrs = FileAttributeKey::getList();
			foreach($attrs as $attr){
				$options['ak_'.$attr->getAttributeKeyHandle()] = $attr->getAttributeKeyName();
			}
			
			return $options;		
		}
		
		function getAvailableSortOrders(){
			$orders = array(
				''=>t('Auto'),
				'asc'=>t('Ascending'),
				'desc'=>t('Descending')
			);
			return $orders;
		}
		
		function getLinkTarget(){
			if(!empty($this->linkTarget)){
				return $this->linkTarget;	
			}
			return '_blank';
		}
		
		function getFileExtensions(){
			if(!empty($this->fExts)){
				return explode(',', $this->fExts);	
			}
			return NULL;	
		}
		
		function view(){
			$this->set('files', $this->getFiles());
		}
		
		public function validate($args) {
			$e = Loader::helper('validation/error');
			if ($args['fsID'] < 1) {
				$e->add(t('You must select a file set.'));
			}
			//$e->add($this->pre($args, TRUE));
			return $e;
		}
		
		
		function save($data){
			
			if($data['max'] == ''){
				$data['max'] = NULL;
			}
			if($data['sortBy'] == ''){
				//$data['sortBy'] = NULL;
			}
			if($data['sortOrder'] == ''){
				//$data['sortOrder'] = NULL;
			}
			//Clean the file extensions list of spaces and periods
			if(!empty($data['fExts'])){
				$data['fExts'] = preg_replace('/\s*,\s*/',',', trim($data['fExts']));
				$data['fExts'] = str_replace('.','', $data['fExts']);
			}
			
			parent::save($data);
		}
		
		function pre($thing, $save=FALSE){
			$str = '<pre style="white-space:pre; border:1px solid #ccc; padding:8px; margin:0 0 8px 0;">'.print_r($thing, TRUE).'</pre>';
			if(!$save){
				echo $str;	
			}
			return $str;
		}
		
	}
	