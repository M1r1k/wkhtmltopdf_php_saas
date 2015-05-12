<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class WkHtmlToPdfController {

  /* @var Application */
  protected $app;
  /* @var Request; */
  protected $request;
  /* @var \mikehaertl\wkhtmlto\Pdf */
  protected $pdf;
  /* @var \m1r1k\SejdaConsole\Sejda */
  protected $sejda;
  /* @var string */
  protected $tmpFileName;

  public function generate(Request $request, Application $app) {
    $this->app = $app;
    $this->request = $request;

    $url = $request->get('url');
    $this->tmpFileName = '/tmp/' . substr(md5(rand()), 0, 15) . '.pdf';

    if (is_string($url)) {
      $this->processSinglePage($url);
    }
    else {
      $this->processMultiplePages($url);
    }

    return $app->sendFile($this->tmpFileName);
  }

  protected function processMultiplePages($urls) {
    $this->initPdf();
    $this->initSejda();
    $dir_name = '/tmp/' . substr(md5(rand()), 0, 10);
    mkdir($dir_name, 0700);
    foreach ($urls as $key => $single_url) {
      $this->pdf->addPage($single_url);
      $this->pdf->saveAs($dir_name . '/' . $key . '.pdf');
      if ($error = $this->pdf->getError()) {
        $this->app['monolog']->addError($this->pdf->getCommand()->getOutput());
        $this->app['monolog']->addError($error);
      }
      $this->pdf->cleanBuffer();
    }
    $this->sejda->addDirectories($dir_name);
    $this->sejda->saveAs($this->tmpFileName);
    if (!file_exists($this->tmpFileName)) {
      $this->app['monolog']->addError($this->sejda->getCommand()->getOutput());
      $this->app['monolog']->addError($this->sejda->getError());
      $this->app->abort(404, $this->sejda->getError());
    }
  }

  protected function processSinglePage($url) {
    $this->initPdf();
    $this->pdf->addPage($url);
    $this->pdf->saveAs($this->tmpFileName);
    if (!file_exists($this->tmpFileName)) {
      $this->app->abort(404, $this->pdf->getError());
    }
  }

  protected function initPdf() {
    $this->pdf = $this->app['wkhtmlto.pdf'];
  }

  protected function initSejda() {
    $this->sejda = $this->app['sejda'];
  }

}
