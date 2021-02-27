<?php

namespace Parallalax\ApiClientBundle;

use App\Myvendor\ApiClientBundle\DependencyInjection\ParallalaxApiClientExtension;
use App\Myvendor\SynchroBundle\DependencyInjection\MyvendorSynchroExtension;

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