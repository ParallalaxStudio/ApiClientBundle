<?php

namespace Parallalax\ApiClientBundle\Core;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


abstract class MainController extends AbstractController {

    protected $restClient = null;
    protected $container;

    public function __construct(ContainerInterface $container, \App\Utils\RestClientFacade $restClient)
    {
        $this->container = $container;
        $this->restClient = $restClient;
    }
}