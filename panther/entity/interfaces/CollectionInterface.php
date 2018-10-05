<?php

namespace Panther\Entity\Interfaces;

interface CollectionInterface  {

    public function push($entity);

    public function pop();

    public function traverse($callable);

}