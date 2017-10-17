<?php

namespace Dino\Play;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;

require __DIR__.'/../vendor/autoload.php';


$start = microtime(true);
$cachedContainer = __DIR__.'/cache/container.php';
if (!file_exists($cachedContainer))
{
	$container = new ContainerBuilder();
	$container->setParameter('root_dir', __DIR__);

	$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
	$loader->load('config.yml');


	$container->compile();
	$dumper = new PhpDumper($container);
	file_put_contents($cachedContainer, $dumper->dump());
}

require $cachedContainer;
$container = new \ProjectServiceContainer();

runApp($container);


$elapsed = round((microtime(true) - $start) * 1000);
$container->get('logger')->debug('Elapsed Time: '.$elapsed.'ms');

function runApp(ContainerInterface $container)
{
	$container->get('logger')->info('ROOOOAR');	
}