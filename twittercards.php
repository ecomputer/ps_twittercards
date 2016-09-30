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
		$this->displayName = $this->l('Twitter cards');
		$this->description = $this->l('');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function install() {
		return parent::install() && $this->registerHook('displayHeader');
	}

	public function hookDisplayHeader() {
		// ProductController
		// CategoryController
		// generañ
		
		$output = ''; 
		
		$meta = Meta::getMetaByPage(Tools::getValue('controller'), (int)Context::getContext()->language->id);
		
		if ($this->context->controller instanceof ProductController) {

		} else if ($this->context->controller instanceof CategoryController) {

		} else {
			$output .= '<meta name="twitter:card" content="summary" />'.PHP_EOL;
			$output .= '<meta name="twitter:title" content="'.$meta['title'].'" />'.PHP_EOL;
			$output .= '<meta name="twitter:description" content="'.$meta['description'].'" />'.PHP_EOL;
			$output .= '<meta name="twitter:image" content="'.__PS_BASE_URI__.'/img/favicon.ico" />'.PHP_EOL; 						// TODO: make it dynamic
		}

		if (!empty(Configuration::get('twittercards_site')))
			$output .= '<meta name="twitter:site" content="@'.Configuration::get('twittercards_site').'" />'.PHP_EOL;

		return $output;
	}

	/**
	 * Configuration page
	 */
	
	public function getContent() {
		$output = '';

		if (Tools::isSubmit('submit'.$this->name)) {
			Configuration::updateValue('twittercards_site', Tools::getValue('twitter_site'));
			$output .= $this->displayConfirmation($this->l('Settings updated'));
		}

		return $output.$this->displayForm();
	}

	public function displayForm() {
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings')
			),
			'input' => array(
				array(
					'type'     => 'text',
					'label'    => $this->l('Twitter site'),
					'name'     => 'twitter_site',
					'prefix' => '@',
					'size'     => 20,
					'required' => false
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'btn btn-default pull-right'
			)
		);

		$helper = new HelperForm();

		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

		$helper->title = $this->displayName;
		$helper->show_toolbar = false;
		$helper->submit_action = 'submit'.$this->name;
		$helper->toolbar_btn = array(
			'save' => array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules')
			), 'back' => array(
				'desc' => $this->l('Back to list'),
				'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
			)
		);

		$helper->fields_value['twitter_site'] = Configuration::get('twittercards_site');

		return $helper->generateForm($fields_form);
	}
}