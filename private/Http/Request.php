<?php
namespace App\Http;

use stdClass;
/**
 * The request object
 *   configures the request
 *   injected into controllers
 *   exposes the following to a controller when injected as $req :
 *     $req->post
 *     $req->params
 *     $req->itemId
 *
 */
class Request {

 private
         /**
          * @var string
          */
         $method,
         /**
          * @var object
          */
         $config,
         /**
          * @var string
          */
         $pathToControllers,
         /**
          * @var string
          */
         $route;

  public
         /**
          * @var object
          */
         $params,
         /**
          * @var object
          *   the post data
          */
         $post,
         /**
          * @var string
          */
         $controller,
         /**
          * @var string
          *   the controller class
          */
         $action,
         /**
          * @var int
          *   the id in the last route fragment
          */
         $itemId;


  public function __construct() {


    //$this->config->route = realpath($this->config->route);
    $this->make();
  }

  private function make() {

    /**
     * Set method as GET POST PUT or DELETE
     */
    $this->method = $_SERVER['REQUEST_METHOD'];

    /**
     * Absolute path to the Controllers directory
     *   default is private/Http/Controllers
     *
     * After bringing a better config solution,
     *    update here and at Config/globals.php
     */
    $this->pathToControllers = $GLOBALS['controllers'];

    /**
     * @var object config stores the following:
     *   string $route -> relative path to the controller, e.g. 'products/chairs'
     *   potentially null object $params -> query params
     *
     *   $config->route represents the folder path to the controller and the
     *     controller class name. Class names must be singular, while route
     *     references must be plural, e.g. 'products/chairs' looks in
     *     private/Http/Controllers/Products for a class named Chair
     */
    $this->config = (object) $_GET;


    $this->getAjax();
    $this->makeParams();
    $this->makeRoute();
    $this->findId();
    $this->makeController();
    $this->findAction();
  }

  /**
   * Set the post data on @var post
   *  bring your own sanitization
   */
  private function getAjax() {
    $post = file_get_contents('php://input');
		$this->post = json_decode($post);
  }

  /**
   * Set query params
   *   this is the object on passed on the front as the third argument
   *     e.g. this.$get('products/42', cb, {paramOne: 'a param'})
   */
  private function makeParams() {
    $this->params = isset($this->config->params) ? json_decode($this->config->params) : new stdClass();
  }

  /**
   * Create an array of route fragments
   *   chop the final 's' from the controller,
   *     e.g. class Cactus is found by route 'desert/plants/catctuss'
   *     edge cases are awkward but this eliminates the need to explicitly
   *     define controllers
   */
  private function makeRoute() {
    $route = array_filter( explode('/', $this->config->route) );
    $this->route = array_map('ucfirst', $route);
  }

  /**
   * Set itemId four routes that end in an id
   */
  private function findId() {
    $this->itemId = ctype_digit( end($this->route) ) ?
      (int) array_pop($this->route) : null;
  }

  /**
   * Set the controller from the last fragment that is not an int

   */
  private function makeController() {
    $c = $this->route[count($this->route)-1];
    $this->route[count($this->route)-1] = substr($c, 0, strlen($c)-1);
    $this->controller = 'App\Http\Controllers\\' . implode('\\', $this->route);
  }

  /**
   * Set appropriate controller method
   *   options are all, get, post, update, destroy
   */
  private function findAction() {

      switch($this->method) {
        case 'GET':
          $this->action = $this->itemId === null ? 'all' : 'get';
          break;
        case 'POST':
          $this->action = 'post';
          break;
        case 'PUT':
          $this->action = 'update';
          break;
        case "DELETE":
          $this->action = 'destroy';
          break;
        default:
          $this->action = null;
      }

  }

}
