CodeIgniter-Breadcrumbs
=================================================================
A small and easy to use breadcrumb path management library for Code Igniter

* manages a breadcrumb list.
* data will be stored in the session

License
-----------------------------------------------------------------
This library is licensed under the MIT license

Usage
-----------------------------------------------------------------

### Setup
* place library in your library folder
* load library in your controlers or autoload via config

### Storing Breadcrumbs:
* in every controller method that should show up in the breadcrumbs path, add 
`$this -> breadcrumbs -> placeBreadcrumb ( "<controller>/<method>[/<data>}", "<Method name>" );`
* Fill in the values according to your controller and method names.
* make sure the session is started before calling placeBreadcrumb
* Tip: if you're lazy, you can always get the current function's name with `__FUNCTION__`

### Retrieving Breadcrumbs:
* to retrieve the breadcrumb list as array, ready to use, call:
`$array = $this -> retrieveBreadcrumbs();`
* this will always be an array. 
* If no breadcrumbs have been stored yet, an empty array will be generated.

### Options

#### setRemoveDuplicates( $boolean )
* default: true
* if not set, breadcrumbs will be added as they come in, allowing duplicate entries in the path
* if set, duplicates will be removed when a method is visited again
* changing the value reorganizes the existing breadcrumbs to match the new settings.

#### setMaxBreadcrumbs ( $int )
* default: 5
* the maximum number of breadcrumbs in the breadcrumb path
* changing the value reorganizes the existing breadcrumbs to match the new settings.

#### setLinkClasses( $string )
* default: "" 
* the string given will be added to all anchor links generated by placeBreadcrumb()


Version history
-----------------------------------------------------------------
###Version 1.0, 01.10.2019, Henning Lechner
* Initial release
