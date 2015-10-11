# WP JSON API

A WordPress plugin to expose a (currently readonly) API to garner information about posts, users, and comments.

## Execution Order

1. Initialize Plugin
2. Load Routes
3. If `REQUEST_URI` in registered routes, dispatch plugin's router
4. Run registered middlewares on request
  4.1 Check for valid X-WPJSONAPI-AUTH Header
5. Parse Request for Data Params (?page, ?limit, ?include, etc)
6. Load the information 
7. Run loaded information through Fractal to produce standardized JSON
8. Sent JSON Response to Browser