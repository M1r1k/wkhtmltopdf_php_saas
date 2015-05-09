<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WkHtmlTpPdfController {

  public function generate(Request $request, Application $app) {
    /* @var \mikehaertl\wkhtmlto\Pdf $pdf_generator */
    $pdf_generator = $app['wkhtmlto.pdf'];
    $url = $request->get('url');

    $pdf_generator->addPage($url);
    $pdf_generator->saveAs('/tmp/new.pdf');
    if (!file_exists('/tmp/new.pdf')) {
      $app->abort(404);
    }
    return $app->sendFile('/tmp/new.pdf');
  }

}
