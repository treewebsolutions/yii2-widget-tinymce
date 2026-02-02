<?php

namespace tws\widgets\tinymce;

use Yii;
use yii\web\AssetBundle;

class TinyMCEExtraAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $depends = [
		'tws\widgets\tinymce\TinyMCEAsset',
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->sourcePath = __DIR__ . '/assets';

		if (file_exists($this->sourcePath . '/i18n/' . str_replace('-', '_', Yii::$app->language) . '.js')) {
			$this->js[] = 'i18n/' . str_replace('-', '_', Yii::$app->language) . '.js';
		} else if (file_exists($this->sourcePath . '/i18n/' . substr(Yii::$app->language, 0, 2) . '.js')) {
			$this->js[] = 'i18n/' . substr(Yii::$app->language, 0, 2) . '.js';
		}
	}
}
