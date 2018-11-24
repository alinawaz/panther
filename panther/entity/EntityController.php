<?php

namespace Panther\Entity;

use \Panther\Entity\Interfaces\EntityControllerInterface;

class EntityController implements EntityControllerInterface {
	
	public function toJson($data){
		return json_encode($data);
	}

	public function view($viewFile, $data = null, $renderable = true) {
		$output = '';
		$viewFile = str_replace('.', '/', $viewFile);
		$viewFile = str_replace("'", "", $viewFile);
		$actualFile = 'app/views/' . $viewFile . '.php';
		ob_start();
		include_once $actualFile;
		$output = ob_get_clean();		
        $includes = match($output,'*@include(?)*',TRUE);
        $phpShortEchos = match($output,'*{{?}}*',TRUE);
		$phpIf = match($output,'*@if(?)',TRUE);
		$phpFor = match($output,'*@for(?)',TRUE);
		$phpForEach = match($output,'*@foreach(?)',TRUE);
		$phpElseIf = match($output,'*@elseif(?)',TRUE);
        
        $output = str_replace("~", config('url') . '/public/', $output);
        $output = str_replace("url:", config('url') ."/", $output);
        if(is_array($includes)){
	        foreach($includes as $inc){
	        	$output = str_replace("@include(".$inc.")", self::view($inc,null,false), $output);
			}
		}
	    if(is_array($phpIf)){
	        for($i=0;$i<count($phpIf);$i++){
	        	$temp = $phpIf[$i];
	        	$output = str_replace("@if(".$temp.")", "<?php if(".$temp."){ ?>", $output);
			}
		}
		if(is_array($phpElseIf)){
	        for($i=0;$i<count($phpElseIf);$i++){
	        	$temp = $phpElseIf[$i];
	        	$output = str_replace("@elseif(".$temp.")", "<?php }elseif(".$temp."){ ?>", $output);
			}
		}
		if(is_array($phpFor)){
	        for($i=0;$i<count($phpFor);$i++){
	        	$temp = $phpFor[$i];
	        	$output = str_replace("@for(".$temp.")", "<?php for(".$temp."){ ?>", $output);
			} 
		}
		if(is_array($phpForEach)){
	        for($i=0;$i<count($phpForEach);$i++){
	        	$temp = $phpForEach[$i];
	        	$output = str_replace("@foreach(".$temp.")", "<?php foreach(".$temp."){ ?>", $output);
			}
		}
	    if(is_array($phpShortEchos)){
	        foreach($phpShortEchos as $pse){
	        	$code = '<?php echo '.$pse.'; ?>';
	        	$output = str_replace("{{".$pse."}}", $code, $output);
			}
		}
		// Few Replacements
		$output = str_replace("@endif", '<?php } ?>', $output);
		$output = str_replace("@endforeach", '<?php } ?>', $output);
		$output = str_replace("@endfor", '<?php } ?>', $output);
		$output = str_replace("@else", '<?php }else{ ?>', $output);		
		$output = str_replace("@php", '<?php ', $output);
		$output = str_replace("@endphp", ' ?>', $output);
		if(!$renderable)
			return $output;
			return self::loadViewFromCache($viewFile,$output,$data);
	}
	private static function renderViewToFile($actualFile,$output){
		$file = fopen($actualFile ,"w");
		fwrite($file,$output);
		fclose($file);
	}
	
	private static function loadViewFromCache($viewFile,$output,$data){
		// Includings by default
		$output = '<?php use System\Libs\Lang; use System\Libs\URL; ?>' . $output;
		// Passed Data Declaration
		if ($data != null) {
			foreach ($data as $var => $val) {
				$$var = $val;
			}
		}

		// Outputting into file
		$fileArray = explode('/',$viewFile);
		$root_path = 'app/storage/temp/views';
		if(count($fileArray)>0){
			for($i=0;$i<count($fileArray)-1;$i++){
				$root_path = $root_path . '/' . $fileArray[$i];
				if (!file_exists($root_path)) {					
					mkdir($root_path, 0777);					
				}
			}
		}
		
		$actualFile = $root_path . '/' . $fileArray[count($fileArray)-1] . "~temp.php";
		// Re-rendering view
		self::renderViewToFile($actualFile,$output);
		// Grabing Content from cache	
		ob_start();
		include_once $actualFile;
		$output = ob_get_clean();
		return $output;
	}

}