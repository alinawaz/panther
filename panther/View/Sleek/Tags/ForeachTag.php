<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class ForeachTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;		
	}

	public function render($content)
	{
		$this->tag->findEndWith('@foreach(?)', '<?php foreach(@replace){ ?>');
		$this->tag->replace("@endforeach", '<?php } ?>');
		return $this->tag->render($content);
	}

}