<?php
namespace Panther\View\Sleek\Tags;

use Panther\View\Tag;

class EchoTag
{

	private $tag;

	function __construct()
	{
		$this->tag = new Tag;		
	}

	public function render($view)
	{
		$this->tag->findAnywhere('{{?}}', '<?php echo @replace; ?>');
		return $this->tag->render($view);
	}

}