<?php

namespace Dino\Play;

// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__.'/../vendor/autoload.php';


$container = new ContainerBuilder();

/** OUTPUT TO LOG FILE **/
// $handler = new StreamHandler(__DIR__.'/dino.log');
$handlerDefinition = new Definition('Monolog\Handler\StreamHandler');
$handlerDefinition->setArguments(array(__DIR__.'/dino.log'));
// $container->set('logger.stream_handler',$handler);
$container->setDefinition('logger.stream_handler', $handlerDefinition);


/** OUTPUT TO SCREEN **/
$stdOutHandlerDefinition = new Definition('Monolog\Handler\StreamHandler');
$stdOutHandlerDefinition->setArguments(array('php://stdout'));
$container->setDefinition('logger.std_out_handler', $stdOutHandlerDefinition);


/** LOGGER DEFINITION **/
// $logger = new Logger('main',array($container->get('logger.stream_handler')));
$loggerDefinition = new Definition('Monolog\Logger');
$loggerDefinition->setArguments(array(
	'main',
	array(new Reference('logger.stream_handler'))
));
$loggerDefinition->addMethodCall('pushHandler',array(
	new Reference('logger.std_out_handler')
));
$loggerDefinition->addMethodCall('debug',array(
	'Logger has been started!'
));
// $container->set('logger',$logger);
$container->setDefinition('logger',$loggerDefinition);


runApp($container);

function runApp(ContainerBuilder $container)
{
	$container->get('logger')->info('ROOOOAR');	
}