<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class PHPEditor extends Field
{
	protected $view = 'admin.php-editor';

	protected static $css = [
		'/vendor/laravel-admin/codemirror-5.20.2/lib/codemirror.css',
	];

	protected static $js = [
		'/vendor/laravel-admin/codemirror-5.20.2/lib/codemirror.js',
		'/vendor/laravel-admin/codemirror-5.20.2/addon/edit/matchbrackets.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/htmlmixed/htmlmixed.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/xml/xml.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/javascript/javascript.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/css/css.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/clike/clike.js',
		'/vendor/laravel-admin/codemirror-5.20.2/mode/php/php.js',
	];

	public function render()
	{
		$this->script = <<<EOT

CodeMirror.fromTextArea(document.getElementById("{$this->id}"), {
    lineNumbers: true,
    mode: "text/x-php",
    extraKeys: {
        "Tab": function(cm){
            cm.replaceSelection("    " , "end");
        }
     }
});

EOT;
		return parent::render();

	}
}nbm  mj.-[