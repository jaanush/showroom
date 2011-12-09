<?php
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
if(!file_exists(__DIR__.'/.htaccess')){
  $data = <<<EOT
<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    RewriteBase /Users/jaanus/LocalSites/showroom
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
EOT;
  try{
    file_put_contents(__DIR__.'/.htaccess', $data);
  } catch(Exception $e){
    print('fix permissions');
  };
}


$safeFiles=array('.DS_Store','.htaccess','.project','.settings','index.php','info.php','settings.inc.php','cache','showroom');
$theme='flickbook';
$themeRoot=__DIR__.'/showroom/'.$theme;
dir(__DIR__);
//require_once __DIR__.'/showroom/silex.phar';
require_once 'phar://'.__DIR__.'/showroom/silex.phar/autoload.php';
$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));
//$app->register(new Acme\DatabaseServiceProvider());
$app['debug'] = true;
$app['fileroot']=__DIR__.'/';
//require_once __DIR__.'/showroom/ShowroomUrlMatcher.php';
/*$app['url_matcher'] = $app->share(function () use ($app) {
            return new ShowroomUrlMatcher($app['routes'], $app['request_context'],$app);
        });*/
$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});
$app->get('/{path}', function ($path) use ($app) {
  if (file_exists($app['fileroot'] . $path)) {
    if(is_dir ( $app['fileroot'] . $path )){
      return 'Fallback route for directory: '.$path;
    } else {
      return 'Fallback route for file: '.$path;
    }
  } else {
    throw new ResourceNotFoundException();
  }
})->assert('path', '.*');
//print_r($app);
//echo count((array)$app);
//print_r($app['router.class']);
$app->run();

//Namespace Showroom;
die();
require_once('./settings.inc.php');


function printCurrentDirRecursively($originDirectory, $app, $safe=array()){
    
    $CurrentWorkingDirectory = dir($originDirectory);
    while($entry=$CurrentWorkingDirectory->read()){
        if($entry != "." && $entry != ".."){
            if(is_dir($originDirectory.DIRECTORY_SEPARATOR.$entry)){
              if(!in_array($entry,$safe)) {
                print('Dir: '.$originDirectory.DIRECTORY_SEPARATOR.$entry."<br/>\n");
                printCurrentDirRecursively($originDirectory.DIRECTORY_SEPARATOR.$entry, $app,(array_key_exists($entry,$safe)?$safe[$entry]:array()));
              }
             }
            else{
              if(!in_array($entry,$safe)) print('File: '.$originDirectory.DIRECTORY_SEPARATOR.$entry."<br/>\n");
            }
        }
    }
    $CurrentWorkingDirectory->close();
}

//TEST IT!
printCurrentDirRecursively(getcwd(),$app,$safeFiles);
?>