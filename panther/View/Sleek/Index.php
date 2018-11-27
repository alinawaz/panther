<?php
namespace Panther\View\Sleek;

use Panther\View\Interfaces\RendererInterface;

use Panther\View\Cache;
use Panther\View\Tag;

class Index implements RendererInterface
{

	public function render($view, $data = NULL)
	{
		$content = $this->parse($view);		
		$content = $this->layouts($content, $data);
		$content = $this->renderTags($content);
		$content = $this->includes($content, $data);		
		return  Cache::render($view, $content, $data);	
	}

	private function layouts($content, $data = NULL)
	{
		$parsed_content = $content;
		$tag = new Tag;
		$layouts = $tag->match('*@layout(?)?#layout*', $content);		

		if($layouts){
			for($i=0; $i<count($layouts); $i++){
				$layout_title = $layouts[$i];
				$layout_content = $layouts[++$i];

				$layout_file = str_replace("'", '', $layout_title);
				$layout_file = str_replace('.', '/', $layout_file);
				$layout_file = getEnv('VIEW_PATH') . '/' . $layout_file . '.php';
				$layout_file_contents = file_get_contents($layout_file);
				$parsed_content = $layout_file_contents;

				$yields = $tag->match('*@yield(?)*', $layout_file_contents);			

				$sections = $tag->match('*@section(?)?@endsection', $layout_content);

				if($sections){
					for($j=0; $j<count($sections); $j++){
						$section_title = $sections[$j];
						$section_content = $sections[++$j];
						foreach($yields as $yield){
							if($yield == $section_title)
								$parsed_content = str_replace('@yield('.$yield.')', $section_content, $parsed_content);
						}
					}
				}
			}
		}
		return $parsed_content;
	}

	private function includes($content, $data = NULL)
	{
		$tag = new Tag;
		$includes = $tag->match('*@include(?)*', $content);
		if($includes){
			foreach($includes as $include){
				$included_content = $this->render($include, $data);
				$content = $tag->replace('@include('.$include.')', $included_content, $content);
			}
		}
		return $content;
	}

	private function renderTags($content)
	{
		$content = resolve('view.sleek.tags.generalTag')->render($content);
		$content = resolve('view.sleek.tags.echoTag')->render($content);
		$content = resolve('view.sleek.tags.ifTag')->render($content);
		$content = resolve('view.sleek.tags.elseifTag')->render($content);
		$content = resolve('view.sleek.tags.foreachTag')->render($content);
		$content = resolve('view.sleek.tags.forTag')->render($content);		
		return $content;
	}

	private function parse($view)
	{
		$view = str_replace('.', '/', $view);
		$view = str_replace("'", "", $view);
		$actualFile = getEnv('VIEW_PATH') . '/' . $view . '.php';
		ob_start();
		include_once $actualFile;
		return ob_get_clean();	
	}		

}