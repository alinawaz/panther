<?php

namespace Panther\Core\Interfaces;

interface ImporterInterface {

    public function from($package, $constructor);

}