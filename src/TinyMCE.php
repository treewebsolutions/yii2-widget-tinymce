<?php

namespace tws\widgets\tinymce;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Class TinyMCE
 *
 * @package tws\widgets\tinymce
 * @author Alin Hort <alinhort@gmail.com>
 * @link https://www.tinymce.com/docs/demo/full-featured/
 */
class TinyMCE extends InputWidget
{
	const PRESET_BASIC = 'basic';
	const PRESET_STANDARD = 'standard';
	const PRESET_FULL = 'full';

	/**
	 * @var string|null The current preset.
	 */
	public $preset = self::PRESET_STANDARD;

	/**
	 * @var array The client (JS) options.
	 */
	public $clientOptions = [];

	/**
	 * @var array The client (JS) events.
	 */
	public $clientEvents = [];

	/**
	 * @var string The client (JS) selector.
	 */
	private $_clientSelector;

	/**
	 * @var string The global widget JS hash variable.
	 */
	private $_hashVar;

	/**
	 * @inheritdoc
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init()
	{
		// Call the parent
		parent::init();
		// Set properties
		$this->setupProperties();
		// Register assets
		$this->registerAssets();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->hasModel()) {
			return Html::activeTextarea($this->model, $this->attribute, $this->options);
		}
		return Html::textarea($this->name, $this->value, $this->options);
	}

	/**
	 * Gets the client selector.
	 *
	 * @return string
	 */
	public function getClientSelector()
	{
		if (!$this->_clientSelector) {
			$this->_clientSelector = '#' . $this->options['id'] ?: $this->getId();
		}
		return $this->_clientSelector;
	}

	/**
	 * Gets the hash variable.
	 *
	 * @return string
	 */
	public function getHashVar()
	{
		if (!$this->_hashVar) {
			$this->_hashVar = 'tinymce_' . hash('crc32', $this->buildClientOptions());
		}
		return $this->_hashVar;
	}

	/**
	 * Sets the widget properties.
	 */
	protected function setupProperties()
	{
		// Merge input options
		$this->options = ArrayHelper::merge([
			'class' => 'form-control',
			'autocomplete' => 'off',
			'data' => [
				'tinymce-options' => $this->getHashVar(),
			],
		], $this->options);
	}

	/**
	 * Builds the client options.
	 *
	 * @return string
	 */
	protected function buildClientOptions()
	{
		// Ensure default values
		$defaultClientOptions = [
			'branding' => false,
			'theme' => 'modern', // TODO: check for mobile device and change theme dynamically to 'mobile'
			'content_css' => [
				Yii::$app->getAssetManager()->getBundle(\yii\bootstrap\BootstrapPluginAsset::class)->baseUrl . '/css/bootstrap.css',
				Yii::$app->getAssetManager()->getBundle(TinyMCEEditorAsset::class)->baseUrl . '/css/editor.css'
			],
		];
		// Preset configuration
		$presetClientOptions = [];
		// Check if the preset is set
		if ($this->preset) {
			// Get preset configuration
			$presetClientOptions = require __DIR__ . "/presets/{$this->preset}.php";
		}
		// Merge client options
		$clientOptions = ArrayHelper::merge($defaultClientOptions, $presetClientOptions, $this->clientOptions);

		// Return options as JSON
		return Json::encode($clientOptions);
	}

	/**
	 * Registers the widget assets.
	 */
	protected function registerAssets()
	{
		// Get the view
		$view = $this->getView();
		// Register assets
		TinyMCEAsset::register($view);
		TinyMCEExtraAsset::register($view);
		// Register widget hash JavaScript variable
		$view->registerJs("var {$this->getHashVar()} = {$this->buildClientOptions()};", View::POS_HEAD);
		// Build client script
		$js = "if (jQuery('{$this->getClientSelector()}').tinymce()) { jQuery('{$this->getClientSelector()}').tinymce().remove(); }\n";
		$js .= "jQuery('{$this->getClientSelector()}').tinymce({$this->getHashVar()})";
		// Build client events
		if (!empty($this->clientEvents)) {
			foreach ($this->clientEvents as $clientEvent => $eventHandler) {
				if (!($eventHandler instanceof JsExpression)) {
					$eventHandler = new JsExpression($eventHandler);
				}
				$js .= ".on('{$clientEvent}', {$eventHandler})";
			}
		}
		// Register widget JavaScript
		$view->registerJs("{$js};");
	}
}
