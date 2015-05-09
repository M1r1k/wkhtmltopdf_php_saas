<?php

use App\Controllers\WkHtmlTpPdfController;
use mikehaertl\wkhtmlto\Pdf;
use Psr\Log\LogLevel;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

define("ROOT_PATH", __DIR__ . "/..");

$app['debug'] = true;
$app['log.level'] = LogLevel::DEBUG;

$app->before(function (Request $request) {
  if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
    $data = json_decode($request->getContent(), TRUE);
    $request->request->replace(is_array($data) ? $data : array());
  }
});

$app->register(new ServiceControllerServiceProvider());

$app['wkhtmlto.pdf'] = function () {
  return new Pdf([
    'no-outline',
    'margin-top' => 0,
    'margin-right' => 0,
    'margin-bottom' => 0,
    'margin-left' => 0,
    'disable-smart-shrinking',
  ]);
};

$app['rest.controller'] = function () {
  return new WkHtmlTpPdfController();
};

$app->post('/rest/pdf:q/generate', 'rest.controller:generate');

$app->get('/', function() {
  return 'Server works!!!';
});

$app->register(new MonologServiceProvider(), array(
  "monolog.logfile" => ROOT_PATH . "/storage/logs/" . date('Y-m-d', time()) . ".log",
  "monolog.level" => $app["log.level"],
  "monolog.name" => "application"
));

$app->error(function (\Exception $e, $code) use ($app) {
  $app['monolog']->addError($e->getMessage());
  $app['monolog']->addError($e->getTraceAsString());

  return new JsonResponse(array(
    "statusCode" => $code,
    "message" => $e->getMessage(),
    "stacktrace" => $e->getTraceAsString()
  ));
});

return $app;