<?php
namespace Panther\View\Sleek;

use Panther\View\Interfaces\RendererInterface;

use Panther\View\Cache;
use Panther\View\Tag;

class Index implements RendererInterface
{

	private $view_path = 'app/views';	

	public function render($view, $data = NULL)
	{
		$content = $this->parse($view);
		$content = $this->renderTags($content);
		$content = $this->includes($content, $data);
		return  Cache::render($this->view_path, $view, $content, $data);	
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
		$actualFile = $this->view_path . '/' . $view . '.php';
		ob_start();
		include_once $actualFile;
		return ob_get_clean();	
	}		

}