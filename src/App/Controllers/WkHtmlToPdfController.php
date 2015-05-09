<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class WkHtmlToPdfController {

  public function generate(Request $request, Application $app) {
    /* @var \mikehaertl\wkhtmlto\Pdf $pdf_generator */
    $pdf_generator = $app['wkhtmlto.pdf'];
    $url = $request->get('url');

    if (is_string($url)) {
      $pdf_generator->addPage($url);
    }
    else {
      foreach ($url as $single_url) {
        $pdf_generator->addPage($single_url);
      }
    }
    $pdf_generator->saveAs('/tmp/new.pdf');
    if (!file_exists('/tmp/new.pdf')) {
      $app->abort(404, $pdf_generator->getError());
    }
    return $app->sendFile('/tmp/new.pdf');
  }

}
