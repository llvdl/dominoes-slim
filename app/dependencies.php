<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Interop\Container\ContainerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Llvdl\Action\Lounge;
use Llvdl\Service\AccountSwitcher;
use Llvdl\View\ViewInterface;
use Llvdl\View\View;
use MongoDB\Database;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Aura\Session\Session;

function env($param, $default = null) {
    $value = filter_input(INPUT_ENV, $param);

    return $value ?: $default;
}

return [
    Capsule::class => function (ContainerInterface $container) {
        $config = $container->get('settings.mongodb');

        $capsule = new Capsule();
        $capsule->addConnection($config, 'mongodb');
        $capsule->getDatabaseManager()->extend('mongodb', function($config) {
            return new Jenssegers\Mongodb\Connection($config);
        });
        $capsule->getDatabaseManager()->setDefaultConnection('mongodb');
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    },
    Serializer::class => function (ContainerInterface $container) {
        /** @var SerializerBuilder $serializerBuilder */
        $serializerBuilder = SerializerBuilder::create();

        $serializationContextFactory = function() {
            $context = new SerializationContext();
            $context->setSerializeNull(true);

            return $context;
        };

        /** @var Serializer $serializer */
        $serializer = $serializerBuilder
            ->addMetadataDir(__DIR__ . '/serializer')
            ->setSerializationContextFactory($serializationContextFactory)
            ->build();

        return $serializer;
    },
    Lounge\MatchDetailAction::class => function (ContainerInterface $container) {
        return new Lounge\MatchDetailAction($container->get('notFoundHandler'));
    },
    LoggerInterface::class => function (ContainerInterface $container) {
        return new Logger('default_logger');
    },
    Database::class => function (ContainerInterface $container) {
        /** @var Capsule $capsule */
        $capsule = $container->get(Capsule::class);
        /** @var Jenssegers\Mongodb\Connection $connection */
        $connection = $capsule->getConnection();

        return $connection->getMongoDB();
    },
    Messages::class => function (ContainerInterface $container) {
        return new Messages();
    },
    Session::class => function (ContainerInterface $container) {
        $session_factory = new \Aura\Session\SessionFactory;
        $session = $session_factory->newInstance($_COOKIE);

        return $session;
    },
    ViewInterface::class => function(ContainerInterface $container) {
        /** @var AccountSwitcher $accountSwitcher */
        $accountSwitcher = $container->get(AccountSwitcher::class);
        /** @var Messages $messages */
        $messages = $container->get(Messages::class);

        $templatePath = $container->get('settings.view')['path'];
        $globalData = array_merge(
            [
                'currentAccount' => $accountSwitcher->getCurrentAccount(),
                'messages' => $messages
            ],
            $container->get('settings.view')['global_data']
        );

        return new View($templatePath, $globalData);
    }
];
