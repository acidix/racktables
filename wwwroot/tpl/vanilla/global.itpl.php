<?php

/**
 * Template for: CSS inline
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderCssInline","<style type=\"text/css\">" . "\n" . "{{code}}" . "\n</style>\n");

/**
 * Template for: CSS include
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderCssInclude","<link rel=stylesheet type='text/css' href='?module=chrome&uri={{path}}' />\n");


/**
 * Template for: JS inline
 * Usage: interface-lib.php (printPageHeaders())
 */
$this->setInMemoryTemplate("HeaderJsInline",'<script type="text/javascript">' . "\n" . "{{code}}" . "\n</script>\n");

/**
 * Template for: JS include
 * Usage: interface-lib.php (printPageHeaders())
*/
$this->setInMemoryTemplate("HeaderJsInclude","<link rel=stylesheet type='text/css' href='?module=chrome&uri={{path}}' />\n");
?>