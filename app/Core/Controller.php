<?php
namespace App\Core;

use Psr\Container\ContainerInterface;
use Slim\Interfaces\RouterInterface;

class Controller {
    /**
     * @var ContainerInterface $container
     */
    protected $container;
    /**
     * Config settings
     */
    protected $settings;
    /**
     * @var RouterInterface
     */
    protected $router;
    
    /**
     * BaseController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->settings  = $this->container['settings'];
        $this->router    = $this->container['router'];
    }
}
