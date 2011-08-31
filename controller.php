<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

/**
 * Allows a section disclaimer to be set that will prevent users from viewing section pages until the disclaimer has been agreed to.
 * @package FileSet Display
 * @author Stephen Rushing
 * @category Packages
 * @copyright  Copyright (c) 2011 Stephen Rushing. (http://www.esiteful.com)
 */
class FileSetDisplayPackage extends Package {

	protected $pkgHandle = 'fileset_display';
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("Display files from a file set.");
	}
	
	public function getPackageName() {
		return t("FileSet Display");
	}
	
	public function install() {
		$pkg = parent::install();
				
		BlockType::installBlockTypeFromPackage('fileset_display', $pkg);	
	}
	
	public function upgrade(){
		parent::upgrade();
			
	}
}