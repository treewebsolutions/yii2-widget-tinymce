<?php

namespace tws\widgets\tinymce;

use yii\web\AssetBundle;

class TinyMCEAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@vendor/tinymce/tinymce';

	/**
	 * @inheritdoc
	 */
	public $js = [
		'tinymce.min.js',
		'jquery.tinymce.min.js',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'\yii\web\JqueryAsset',
		'\yii\bootstrap\BootstrapAsset',
	];
}
