<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class IfTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;
	}

	public function render($content)
	{
		$this->tag->findEndWith('@if(?)', '<?php if(@replace){ ?>');		
		$this->tag->replace("@endif", '<?php } ?>');
		return $this->tag->render($content);
	}

}