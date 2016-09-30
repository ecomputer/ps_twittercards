<?php
if (!defined('_PS_VERSION_'))
	exit;
class TwitterCards extends Module {
	public function __construct() {
		$this->name = 'twittercards';
		$this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Internet Ecomputer';
		$this->need_instance = 0;
		$this->ps_versions_compilancy = array('min' => '1.5', 'max' => '1.6');
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Módulo vacío por Ecompuer para Prestashop');
		$this->description = $this->l('');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function install() {
		return parent::install() && $this->registerHook('displayHeader');
	}

	public function hookDisplayHeader() {
		
	}
}