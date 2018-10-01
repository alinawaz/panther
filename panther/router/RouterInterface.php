<?php

namespace Panther\Router;

interface RouterInterface {

    public function get($url, $callable);

}