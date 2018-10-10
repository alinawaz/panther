<?php

namespace Panther\Entity\Interfaces;

interface CollectionInterface  {

    public function push($entity);

    public function pop();

    public function count();

    public function flush();

    public function traverse($callable);

}