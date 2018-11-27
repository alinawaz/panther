<?php
namespace Panther\View;

class Template
{

	/* Renders a html template file with default renderer */
	public static function render($view, $data)
	{
		$renderer = resolve('view.'.getEnv('VIEW_RENDERER').'.index');
		return $renderer->render($view, $data);
	}

}