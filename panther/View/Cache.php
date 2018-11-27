<?php
namespace Panther\View;

use Panther\Security\Session;

class Cache
{
	
	private static $view_cache_path = 'app/storage/temp/views';

	public static function render($file, $content, $data = NULL)
	{
		// If view caching is disabled
		if(getEnv('VIEW_CACHING') == 'false')
			return self::reRender($file, $content, $data);

		// Full paths
		$view_file = self::viewFile(getEnv('VIEW_PATH'), $file);
		$cached_file = self::cacheFile($file);

		// Check for changes in source view file
		$stamp = Session::get('cache_stamp');
		if($stamp != FALSE){
			if(filemtime($view_file) == $stamp && file_exists($cached_file)){
				return self::read($cached_file, $data);
			}
		}

		// No change found, let's load cached version
		Session::set('cache_stamp', filemtime($view_file));
		return self::reRender($file, $content, $data);
	}

	private static function viewFile($file)
	{
		$file = str_replace("'", '', $file);
		$file = str_replace('.', '/', $file);
		return getEnv('VIEW_PATH').'/'.$file.'.php';
	}

	private static function cacheFile($file)
	{
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
		return $full_path . '/' . $last_token . "~temp.php";
	}

	private static function reRender($file, $content, $data = NULL)
	{
		// Writing contents to cache view
		$cached_file = self::cacheFile($file);
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