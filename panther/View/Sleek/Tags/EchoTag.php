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

	public function render($content)
	{
		$this->tag->findAnywhere('{{?}}', '<?php echo @replace; ?>');
		return $this->tag->render($content);
	}

}