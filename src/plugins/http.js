var axios = require('axios');

/**
 * Default options to be overridden in main.js
 *
 *   @var string baseURL
 *     path from the public folder to the entry point for php
 *
 *   @var function httpError
 *     default function to call in the catch
 *     handle network errors
 *
 *   @var function defaultError
 *     default function to call for logic errors on the server
 *     overridden in each call by the fourth parameter
 *
 *   @var function defaultSuccess
 *     default function to call after a successful request
 *     overridden in each call by the second parameter
 */

var log = res => {
  console.log(res)
};

var opts = {
  baseURL: 'api/',
  httpError: log,
  defaultError: log,
  defaultSuccess: log
};

/**
 * Schema for the GET and DELETE params
 */
var GetDeleteConfig = function(route, qp) {

  this.params = {};
  this.params.route = route;
  this.params.params = qp || {};

}


/**
 * The request handler
 *
 *   Reads default config and overrides
 *   Executes request type
 *   Executes appropriate callback
 *
 *   Callback routine for successful network requests (then):
 *     receives a Response object with the following schema:
 *     {
 *       data: any,
 *       message: string,
 *       success: boolean
 *     }
 *
 *     Checks the status of res.success
 *
 *     When sucessful, hands res.data to the success callback
 *
 *     When unsuccessful, hands res.message to the error callback
 */
var request = function(route, cb, data, errCb, type) {


  /**
   * Axios has different signatures for GET/DELETE and POST/PUT, respectively
   */
  var getDelete = type === 'get' || type === 'delete';

  /**
   * Check for passed callbacks
   * If none, use defaults
   */
  var cbFn  = cb    || opts.defaultSuccess;
  var errFn = errCb || opts.defaultError;

  /**
   * This setup passes the route as a query param
   * If GET/DELETE, stick it on the query param object
   * If POST/PUT, concatenate to route path param
   */
  var rte = getDelete ? '' : '?route=' + route;

  /**
   * If GET/DELETE, create appropriate schema for query params
   * If POST/PUT, pass the payload
   */
  var config = getDelete ? new GetDeleteConfig(route, data) : data;

  /**
   * Execute request and callbacks
   */
  axios[type](rte, config)
    .then( res => {
      res.data.success ? cbFn(res.data.data) : errFn(res.data.message);
    })
    .catch( err => { errFn(err) } );

}


exports.install = function(Vue, options) {

  for (k in options) {
    opts[k] = options[k];
  }

  axios.defaults.baseURL = opts.baseURL;

  Vue.prototype.$get = function(route, cb, data, errCb) {
    var type = 'get';
    request(route, cb, data, errCb, type);
  };
  Vue.prototype.$post = function(route, cb, data, errCb) {
    var type = 'post';
    request(route, cb, data, errCb, type);
  };
  Vue.prototype.$put = function(route, cb, data, errCb) {
    var type = 'put';
    request(route, cb, data, errCb, type);
  };
  Vue.prototype.$delete = function(route, cb, data, errCb) {
    var type = 'delete';
    request(route, cb, data, errCb, type);
  };

  /**
   * Expose axios on the instance
   *   for access to other services; will not work with App
   */
  Vue.prototype.$axios = axios;

  };
