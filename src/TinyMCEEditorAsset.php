<?php

namespace tws\widgets\tinymce;

use Yii;
use yii\web\AssetBundle;

class TinyMCEEditorAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $css = [
		'css/editor.css',
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->sourcePath = __DIR__ . '/assets';
	}
}
