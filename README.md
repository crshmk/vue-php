# Vue-PHP

This is a REST api approach to link Vue and PHP suitable for smaller projects when a framework is overkill or when you just dig doing it yourself.

## Axios plugin

A plugin wraps Axios and exposes the following methods on a Vue instance:
```javascript
this.$get()
this.$post()
this.$put()
this.$delete()
```

Each takes the following arguments in the following order:

type | description | required
--- | --- | ---
string | route | yes
function | success callback | no
object | post payload or query params | no
function | error callback | no


A simple example in a Vue instance might read
```javascript
data: function() {
  return {
    chairs: [],
  };
},
methods: {
  setChairs: function(res) {
    this.chairs = res;
  }
},
created: function() {
  this.$get('products/chairs', this.setChairs);
}
```
This would get all the chairs (explained below) and set the response data on the chairs array.


A more involved request might read

```javascript
methods: {
  updateChairs: function(res) {
    this.chairs = res;
  },
  handleError: function(err) {
    this.message = err;
  }
},
created: function() {
  this.$put(
    'products/chairs/42',
    this.addMessage,
    {name: 'Nice Chair'},
    this.handleError
  );
}
```
This updates the name of chair with id 42 to 'Nice Chair', hands the appropriate callback the response data (success or error; explained below) and executes it.

### Route string

Each call needs a route, which is the path leading to the controller class under App/Http/Controllers.

For example, a class at App/Http/Controllers/Products titled 'Chair.php', is accessed as

```javascript
'products/chairs'
```

Edge cases occur, e.g. class Cactus is found by route
```javascript
'desert/plants/catctuss'
```
but this structure eliminates the need to explicitly define controllers.


------
The type of route determines the controller function to be called. There are five options:

Method | Route | Controller Method
--- | --- | ---
GET | products/chairs | all()
GET | products/chairs/42 | get()
POST | products/chairs | post()
PUT | products/chairs/42 | update()
DELETE | products/chairs/42 | destroy()



Controllers
------
Controllers are classes that live in App/Http/Controllers. Construct routes to account for directory structures.

Route | Path to class
--- | ---
users | Controllers/User.php
products/chairs | Controllers/Products/Chair.php

A skeleton constructor class might read as
```php
class Book {

  public function all($req, $res) {

  }

  public function get($req, $res) {

  }

  public function post($req, $res) {

  }

  public function update($req, $res) {

  }

  public function destroy($req, $res) {

  }

}
```
As noted in the above chart, controller methods are called based on the route passed.

### Request and Response objects

Public controller methods are injected with a Request and a Response object. They expose the following to the methods:

Object | Key | Type | Purpose
--- | --- | --- | ---
Request | post | object | post payload
Request | params | object | query params
Request | itemId | int | id for item when last route fragment is an int
Response | success | boolean | indicate success or error
Response | data | any | data to be returned from response
Response | message | string | error message

Basically, the controller methods read relevant data from the request, process it, and issue a response containing any data on success or a string message on error. The methods must explicitly set success = true, as the default is false. A request that reads
```javascript
'products/chairs/42'
```
will call the get() method in Products\Chair.php. The method is interested in $req->itemId, which is 42.


```php
namespace App\Http\Controllers\Products;

use App\Database\DB;

class Chair {

  public function get($req, $res) {

    $db = new DB();
    $query = $db->get('chairs', $req->itemId);
    $res->data = $query->results;
    $res->success = true;

  }

}
```

## Not Included

BYODB! Bring your own database, validations, and middleware.

## Etc

The axios object is also set on the Vue instance as
```javascript
this.$axios()
```
for use with other services.
