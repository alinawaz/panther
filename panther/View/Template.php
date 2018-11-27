<?php
namespace Panther\View;

class Template
{

	/* Renders a html template file with selected renderer */
	public static function render($content, $data)
	{
		if(getEnv('VIEW_RENDERER') == '')
			return self::fallbackRenderer($content, $data);
		$renderer = resolve('view.'.getEnv('VIEW_RENDERER').'.index');
		return $renderer->render($content, $data);
	}

	/* When no renderer selected from env, plain execution will take place. */
	private static function fallbackRenderer($content, $data)
	{
		// Globalizing the passed data variables
		if ($data != NULL) {
			foreach ($data as $var => $val) {
				$$var = $val;
			}
		}

		// Reading view file
		$content = str_replace('.', '/', $content);
		$content = str_replace("'", "", $content);
		$actualFile = getEnv('VIEW_PATH') . '/' . $content . '.php';
		ob_start();
		include_once $actualFile;
		return ob_get_clean();	
	}

}