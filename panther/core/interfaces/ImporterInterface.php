<?php

namespace Panther\Core\Interfaces;

interface ImporterInterface {

    public function resolve($context, $constructor);

}