<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class ForTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;		
	}

	public function render($content)
	{
		$this->tag->findEndWith('@for(?)', '<?php for(@replace){ ?>');
		$this->tag->replace("@endfor", '<?php } ?>');
		return $this->tag->render($content);
	}

}