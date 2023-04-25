# Gravity-Forms-ACF-Field

This is an Advanced Custom Field custom field to select one or many [Fluent Forms](http://www.fluentforms.com/).

This provides a field that lets you select from a list of active Fluent Forms.

# Compatibility

This add-on will work with:

- Version 5
- Version 6

# Installation

This add-on can be treated as both a WP plugin and a theme include.

_Plugin_

1. Copy the 'Fluent-Forms-ACF-field' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

_Include_

1.  Copy the 'Fluent-Forms-ACF-field' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.  Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-fluent_forms.php file)

```
  include_once('acf-fluent_forms.php');
```

# Using the field

The field lets you pick one or many fields.

The data returned is either a Form object, an array of Form objects or false if an error occurred.

# About

Version: 1.2

Written by Mat Gargano of [StatenWeb](http://statenweb.com)

Storm Consultancy are a web design and development agency based in Staten Island, NY.

If you are looking for a [Staten Island WordPress Developer](http://statenweb.com)
