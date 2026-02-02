<?php
return [
	// Plugins
  'plugins' => 'paste autoresize code print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',

	// Toolbars
	'toolbar1' => 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',

 	// Plugins configuration
	'autoresize_on_init' => true,
	'autoresize_min_height' => 150,
	'autoresize_bottom_margin' => 5,
  'image_advtab' => true,
  'paste_data_images' => true,

	// Templates
  'templates' => [
    ['title' => 'Test template 1', 'content' => 'Test 1'],
    ['title' => 'Test template 2', 'content' => 'Test 2'],
  ],
];
