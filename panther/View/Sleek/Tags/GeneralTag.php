<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class GeneralTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;		
	}

	public function render($content)
	{
		$this->tag->replace("@else", '<?php }else{ ?>');
		$this->tag->replace("@php", '<?php');
		$this->tag->replace("@endphp", '?>');
		$this->tag->replace("~", url('/public/'));
		$this->tag->replace("url:", url('/'));
		return $this->tag->render($content);
	}

}