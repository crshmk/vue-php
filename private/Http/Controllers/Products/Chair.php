<?php
namespace App\Http\Controllers\Products;

use App\Database\DB;

/**
 * Sample controller with all five available methods
 */

class Chair {


  /**
   * Queries DB using DB->all and generates response data
   *
   *  [
   *   {id: 1, name: "Nice Chair"},
   *   {id: 2, name: "Vintage Chair"},
   *   {id: 3, name: "Smart Chair"}
   *  ]
   *
   * Sets data on response object
   * Sets success status to true
   *
   * Response will send to client; no more is needed
   *
   * For errors, use $res->reject(stringMessage)
   *   success default is false; no need to set
   */
  public function all($req, $res) {

    $db = new DB();
    $query = $db->all('chairs');
    $res->data = $query->results;
    $res->success = true;

  }

  /**
   * Queries DB for an item and receives
   *
   *  {id: 42, name: "Havana Lounge Chair"}
   *
   * Sets data on response object
   * Sets success status to true
   */
  public function get($req, $res) {

    $db = new DB();
    $query = $db->get('chairs', $req->itemId);
    $res->data = $query->results;
    $res->success = true;

  }

  /**
   * Handle INSERT commands here
   * Set any relevant data on response object
   * Set success status to true
   */
  public function post($req, $res) {

    $res->data = ['message' => $req->post->name . ' created'];
    $res->success = true;

  }

  /**
   * Handle UPDATE commands here
   * Set any relevant data on response object
   * Set success status to true
   */
  public function update($req, $res) {

    $res->data = ['message' => 'chair ' . $req->itemId . ' updated'];
    $res->success = true;

  }

  /**
   * Handle DELETE commands here
   * Set any relevant data on response object
   * Set success status to true
   */
  public function destroy($req, $res) {

    $res->data = ['message' => 'chair ' . $req->itemId . ' deleted'];
    $res->success = true;

  }

}
