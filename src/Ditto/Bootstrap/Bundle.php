<?php
namespace Ditto\Bootstrap;
use \Ditto\Core\Engine;

class Bundle extends \Ditto\Core\Bundle {
	protected $bundle_name = 'Bootstrap';
	protected $bundle_type = 'CSS and JavaScript Library';
	public $module_requires = array(
		'jQuery'
	);

	private $dependencies = array(
		'responsive' => array(
			'layout'
		),
		'tooltips' => array(
			'componentanimations',
			'transitions'
		),
		'popovers' => array(
			'componentanimations',
			'transitions',
			'tooltips'
		),
		'modals' => array(
			'componentanimations',
			'transitions'
		),
		'dropdowns' => array(
			'componentanimations',
			'transitions'
		),
		'collapse' => array(
			'componentanimations',
			'transitions'
		),
		'carousel' => array(
			'componentanimations',
			'transitions'
		),
		'scrollspy' => array(
			'transitions'
		),
		'togglabletabs' => array(
			'transitions'
		),
		'affix' => array(
			'transitions'
		),
		'alerts' => array(
			'transitions',
			'closeicon'
		),
		'buttons' => array(
			'transitions'
		),
		'collapse' => array(
			'transitions'
		),
		'typeahead' => array(
			'transitions'
		),
	);
	private $loaded = array(
		'base'
	);

	public function construct() {}

	private function loadDependencies($module) {
		if (isset($this->dependencies[$module])) {
			foreach ($this->dependencies[$module] as $dependency) {
				$result = array_search($dependency, $this->loaded);
				if ($result === false)
					array_push($this->loaded, $dependency);
			}
		}
		return $this;
	}

	public function load($modules = null) {
		if (\Ditto\Core\Engine::getEnvironment() == 1)
			$pathAffix = '';
		else $pathAffix = 'min.';

		if (is_null($modules)) {
			\Ditto\Core\Engine::addGlobalScript(
				self::$root ."js/bootstrap-full.{$pathAffix}js"
			);
			\Ditto\Core\Engine::addGlobalStyle(
				self::$root ."css/bootstrap-full.{$pathAffix}css"
			);
			return $this;
		}

		foreach ($modules as $module) {
			$this->loadDependencies($module);
			array_push($this->loaded, $module);
		}
		foreach ($this->loaded as $module) {
			switch ($module) {
				case 'tooltips':
				case 'popovers':
				case 'modals':
				case 'dropdowns':
				case 'collapse':
				case 'carousel':
				case 'buttons':
				case 'alerts':
					if (file_exists(
						self::$root_abs .
						"js/bootstrap-{$module}.{$pathAffix}js"
					) and file_exists(
						self::$root_abs .
						"css/bootstrap-{$module}.{$pathAffix}css"
					)) {
						\Ditto\Core\Engine::addGlobalScript(
							self::$root .
							"js/bootstrap-{$module}.{$pathAffix}js"
						);
						\Ditto\Core\Engine::addGlobalStyle(
							self::$root .
							"css/bootstrap-{$module}.{$pathAffix}css"
						);
					} else
						trigger_error("Ditto\Bootstrap cannot load $module, as it does not exist.");
					break;

				case 'scrollspy':
				case 'togglabletabs':
				case 'tooltips':
				case 'affix':
				case 'typeahead':
				case 'transitions':
					if (file_exists(
						self::$root_abs .
						"js/bootstrap-{$module}.{$pathAffix}js"
					)) {
						\Ditto\Core\Engine::addGlobalScript(
							self::$root .
							"js/bootstrap-{$module}.{$pathAffix}js"
						);
					} else
						trigger_error("Ditto\Bootstrap cannot load $module, as it does not exist.");
					break;
				
				default:
					if (file_exists(
						self::$root_abs .
						"css/bootstrap-{$module}.{$pathAffix}css"
					)) {
						\Ditto\Core\Engine::addGlobalStyle(
							self::$root .
							"css/bootstrap-{$module}.{$pathAffix}css"
						);
					} else
						trigger_error("Ditto\Bootstrap cannot load $module, as it does not exist.");
					break;
			}
		}
		return $this;
	} 
}