<?php

namespace Panther\Core;

interface ImporterInterface {

    public function from($package, $constructor);

}