<?php
namespace App\Http;

use stdClass;

/**
 * Bring your own validations
 *
 * Call validations in App/App.php
 */
class RequestValidator {


  /**
   * @return success boolean
   * @return message string
   */
  public function auth() {
    $auth = new stdClass();
    $auth->success = true;

    //$auth->success = false;
    //$auth->message = 'failed group permissions';

    return $auth;
  }

}
