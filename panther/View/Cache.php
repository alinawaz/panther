<?php
namespace Panther\View;

use Panther\Security\Session;

class Cache
{
	
	private static $view_cache_path = 'app/storage/temp/views';

	public static function render($view_path, $file, $content, $data = NULL)
	{
		// If view caching is disabled
		if(getEnv('VIEW_CACHING') == 'FALSE')
			return self::reRender($file, $content, $data);

		// Cahched File
		$tokens = explode('/', $file);
		$last_token = $tokens[count($tokens)-1];
		$cached_file = self::$view_cache_path . '/' . $last_token . "~temp.php";
		// View File
		$view_file = $view_path.'/'.$file.'.php';

		// Check for changes in source view file
		$stamp = Session::get('cache_stamp');
		if($stamp != FALSE){
			if(filemtime($view_file) == $stamp && file_exists($cached_file)){
				dump('cached-view');
				return self::read($cached_file, $data);
			}
		}

		// No change found, let's load cached version
		Session::set('cache_stamp', filemtime($view_file));
		dump('rendered-view');
		return self::reRender($file, $content, $data);
	}

	private static function reRender($file, $content, $data = NULL)
	{
		// Making directories if required
		$file = str_replace("'", '', $file);
		$file = str_replace('.', '/', $file);
		
		$tokens = explode('/', $file);
		$full_path = self::$view_cache_path;
		if(count($tokens)>0){
			for($i=0;$i<count($tokens)-1;$i++){
				$full_path = $full_path . '/' . $tokens[$i];
				if (!file_exists($full_path)) {					
					mkdir($full_path, 0777);					
				}
			}
		}
		$last_token = $tokens[count($tokens)-1];

		// Writing contents to cache view
		$cached_file = $full_path . '/' . $last_token . "~temp.php";
		self::write($cached_file, $content);
		
		// Reading cached view		
		return self::read($cached_file, $data);
	}

	private static function write($filename, $content)
	{
		$file = fopen($filename ,"w");
		fwrite($file,$content);
		fclose($file);		
	}

	private static function read($cached_file, $data = NULL)
	{
		// Globalizing the passed data variables
		if ($data != NULL) {
			foreach ($data as $var => $val) {
				$$var = $val;
			}
		}

		// Reading cached file
		ob_start();
		include_once $cached_file;
		return ob_get_clean();
	}

}