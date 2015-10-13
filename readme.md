# WP JSON API

A WordPress plugin to expose a (currently readonly) API to garner information about posts, users, and comments.

## Execution Order

1. Initialize Plugin
2. Load Routes
3. Dispatch Plugin Router
4. If `404 Not Found` is not the result, proceed
5. Run registered middlewares on request
  5.1 Check for valid X-WPJSONAPI-AUTH Header
6. Parse Request for Data Params (?page, ?limit, ?include, etc)
7. Load the information 
8. Run loaded information through Fractal to produce standardized JSON
9. Sent JSON Response to Browser