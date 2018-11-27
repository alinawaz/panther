<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class ElseifTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;		
	}

	public function render($content)
	{
		$this->tag->findEndWith('@elseif(?)', '<?php }elseif(@replace){ ?>');
		return $this->tag->render($content);
	}

}