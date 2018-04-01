<?php
namespace App\Http;

use stdClass;

/**
 * The response object
 *
 *   Injected into constructor methods
 *
 *   When injected as $res constructor methods should:
 *     set $res->success = true for successful requests
 *     return data with $res->data
 *     return an error message with $res->message
 *
 *   The front checks for the status of $res->success
 *     when successful, it hands $res->data over to the success callback
 *     when unsussessful, it hands the error message to the error callback
 */

class Response {

  public
         /**
          * @var string
          *   string explanation for server side errors
          */
         $message,

         /**
          * @var boolean
          *   required to manually set $res->success = true in controller
          *     methods
          *   default is false
          */
         $success,

         /**
          * The response sends any data type
          * Axios converts associative arrays to objects during encoding
          */
         $data;

public function __construct() {

  $this->message = '';
  $this->success = false;
  $this->data = new stdClass();

}

/**
 * Sends message string, success boolean, and data object
 *   that were set on the injected response instance in controller methods
 *   and closes request
 */
public function send() {

  $res = new stdClass();
  $res->message = $this->message;
  $res->success = $this->success;
  $res->data = $this->data;
  echo json_encode($res);
  exit;

}

/**
 * Convenience method for errors or rejected requests
 */
public function reject($message) {
  $this->message = $message;
  $this->data = null;
  $this->send();
}

}
