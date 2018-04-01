<?php
namespace App\App;

use App\Http\Request;
use App\Http\Response;
use App\Http\RequestValidator;

/**
 * Initiates Request and Response Objects
 *
 * Checks route validations
 *
 * Calls appropriate Controller and method,
 *   injecting Request and Response objects
 *
 * Sends Response and closes script
 */
class App {

  public function __construct() {
    $this->run();
  }

  private function run() {

    /**
     * Instantiate Request and Response objects
     */
    $req = new Request();
    $res = new Response();

    /**
     * If validations fail, return a string message, like other errors
     */
    $v = new RequestValidator();
    $auth = $v->auth();

    if (!$auth->success) {
      $res->reject($auth->message);

    }

    // call your middleware here

    /**
     * Instantiate a controller
     */
    $ctrl = new $req->controller();

    /**
     * Call the appropriate method on the controller
     *   and inject the Request and Response
     */
    $action = $req->action;
    $ctrl->$action($req, $res);

    /**
     * Return a standard Response object to the client
     */
    $res->send();
    exit;
  }
}
