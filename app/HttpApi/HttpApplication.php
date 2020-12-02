<?php
declare(strict_types=1);

namespace MazeChallenge\HttpApi;

use DI\ContainerBuilder;
use MazeChallenge\Application\Service\MazeSolver\MazeSolverService;
use Monolog\Logger;
use Predis\Client as RedisClient;
use Slim\Factory\AppFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;
use Slim\Routing\RouteCollectorProxy;
use MazeChallenge\Application\Handlers\HttpErrorHandler;
use MazeChallenge\Application\Handlers\ShutdownHandler;
use MazeChallenge\Domain\Model\Environment\Environment;

class HttpApplication
{
    /**
     * @var \Slim\App
     */
    private $app;

    /**
     * @var Environment
     */
    private $env;

    /**
     * @var \DI\Container
     */
    private $container_builder;

    /**
     * @var HttpErrorHandler
     */
    private $error_handler;

    /**
     * @var ShutdownHandler
     */
    private $shutdown_handler;

    public function __construct()
    {
        $this->env = new Environment($_ENV['APP_ENV']);
        // Instantiate PHP-DI ContainerBuilder
        $this->container_builder = new ContainerBuilder();

        if ($this->env->isProduction()) { // Should be set to true in production
            $this->container_builder->enableCompilation(__DIR__ . '/../var/cache');
        }

        $this->addConfigDefinitions();
        $this->addLogger();
        $this->addRepositories();
        $this->addServices();

        // Build PHP-DI Container instance
        $this->container_builder = $this->container_builder->build();

        // Instantiate the app
        AppFactory::setContainer($this->container_builder);
        $this->app = AppFactory::create();

        // Register middleware
        $this->registerMiddlewares();

        // Register routes
        $this->registerRoutes();

        /** @var bool $displayErrorDetails */
        $displayErrorDetails = $this->container_builder->get('config')['app']['displayErrorDetails'];

        // Create Request object from globals
        $serverRequestCreator = ServerRequestCreatorFactory::create();
        $request = $serverRequestCreator->createServerRequestFromGlobals();

        // Create Error Handler
        $this->error_handler = new HttpErrorHandler(
            $this->env,
            $this->app->getCallableResolver(),
            $this->app->getResponseFactory(),
            $this->container_builder->get(LoggerInterface::class)
        );

        // Create Shutdown Handler
        //$this->shutdown_handler = new ShutdownHandler($request, $this->error_handler, $displayErrorDetails);
        //register_shutdown_function($this->shutdown_handler);

        // Add Routing Middleware
        $this->app->addRoutingMiddleware();

        // Add Error Middleware
        $errorMiddleware = $this->app->addErrorMiddleware($displayErrorDetails, false, false);
        $errorMiddleware->setDefaultErrorHandler($this->error_handler);

        // Run App & Emit Response
        $response = $this->app->handle($request);
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);



    }

    private function addConfigDefinitions()
    {
        // TODO: improve the way to import the config files
        $app_config = require_once __DIR__ . "../../config/app.php";
        $logger_config = require_once __DIR__ . "../../config/logger.php";
        $redis_config = require_once __DIR__ . "../../config/redis.php";

        $this->container_builder->addDefinitions([
            'config' => [
                'app' => $app_config,
                'logger' => $logger_config,
                'redis' => $redis_config,
            ]
        ]);
    }

    private function addLogger()
    {
        $this->container_builder->addDefinitions([
            LoggerInterface::class => function (ContainerInterface $container) {
                $logger_settings = $container->get('config')['logger'];
                $logger = new Logger($logger_settings['name']);
                $processor = new UidProcessor();
                $logger->pushProcessor($processor);
                $handler = new StreamHandler(__DIR__ . $logger_settings['path'], $logger_settings['level']);
                $logger->pushHandler($handler);

                return $logger;
            },
        ]);
    }

    private function addRepositories()
    {
        //Add Repositories Here
        $this->container_builder->addDefinitions([
            "redis_client" => function (ContainerInterface $container) {
                $redis_config = $container->get('config')['redis'];
                return new RedisClient(['host' => $redis_config['host']]);
            },
        ]);
    }

    private function addServices()
    {
        $this->container_builder->addDefinitions([
            MazeSolverService::class => function (ContainerInterface $container) {
                return new MazeSolverService();
            },
        ]);
    }

    private function registerMiddlewares()
    {
        //Add Middlewares here
    }

    private function registerRoutes()
    {
        $this->app->get(
            '/service/health',
            Controller\ServiceController::class . ':health'
        );

        // API v1 routes
        $this->app->group('/api/v1', function (RouteCollectorProxy $group) {
            //Add api v1 routes here
            $group->post(
                '/maze/solve',
                Controller\MazeController::class . ':solve'
            );
        });
    }
}