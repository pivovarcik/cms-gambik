<?php
$string = '';

$string .= 'extended_valid_elements : "';

$string .= 'iframe[src|width|height|name|align],';
$string .= 'object[classid|codebase|width|height|align],';
$string .= 'param[name|value],';
$string .= 'embed[quality|type|pluginspage|width|height|src|align]",';

print $string;
?>
