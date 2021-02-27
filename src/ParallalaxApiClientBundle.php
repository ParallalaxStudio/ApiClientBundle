<?php

namespace Parallalax\ApiClientBundle;

use Parallalax\ApiClientBundle\DependencyInjection\ParallalaxApiClientExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ParallalaxApiClientBundle extends Bundle {

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ParallalaxApiClientExtension();
        }
        return $this->extension;
    }

}