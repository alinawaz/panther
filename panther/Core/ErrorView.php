<?php

namespace Panther\Core;

class ErrorView
{

	public static function render($title, $description)
	{
		echo '<link href="'.url('/public/css/bootstrap.min.css').'" rel="stylesheet"/>
				<div class="jumbotron">
                  <h1 class="display-4">'.$title.'</h1>
                  <p class="lead">'.$description.'</p>
                </div>';
        exit;
	}

}