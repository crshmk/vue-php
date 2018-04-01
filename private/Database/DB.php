<?php
namespace App\Database;

use stdClass;

/**
 * Bring your own DB
 */
class DB {


  public function all($table) {

    $table = substr( ucfirst($table), 0, strlen($table)-1 );

    $query = new stdClass();

    $query->results = [
      ['id' => 1, 'name' => 'Nice ' . $table],
      ['id' => 2, 'name' => 'Vintage ' . $table],
      ['id' => 3, 'name' => 'Smart ' . $table]
    ];

    return $query;
  }

  public function get($table, $id) {

    $query = new stdClass();

    $query->results = ['id' => $id, 'name' => 'Havana Lounge Chair'];

    return $query;

  }

}
