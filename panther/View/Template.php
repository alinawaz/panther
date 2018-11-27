<?php
namespace Panther\View;

class Template
{

	/* Renders a html template file with selected renderer */
	public static function render($view, $data)
	{
		if(getEnv('VIEW_RENDERER') == '')
			return self::fallbackRenderer($view, $data);
		$renderer = resolve('view.'.getEnv('VIEW_RENDERER').'.index');
		return $renderer->render($view, $data);
	}

	/* When no renderer selected from env, plain execution will take place. */
	private static function fallbackRenderer($view, $data)
	{
		// Globalizing the passed data variables
		if ($data != NULL) {
			foreach ($data as $var => $val) {
				$$var = $val;
			}
		}

		// Reading view file
		$view = str_replace('.', '/', $view);
		$view = str_replace("'", "", $view);
		$actualFile = getEnv('VIEW_PATH') . '/' . $view . '.php';
		ob_start();
		include_once $actualFile;
		return ob_get_clean();	
	}

}