<?php
////////////////////////////////////////////////////////////////////////
// change-links.php - change all links matching a pattern.
//
// Usage:
//   php change-links.php <url-pattern> <from-string> <replace-string>
//
// url-pattern
//   A perl-format regular expression including surrounding delimiters,
//   e.g. "!/foo/bar!". Only URLs matching this regular expression
//   will be examined.
//
// from-pattern
//   The string to replace (case-sensitive).
//
// to-string
//   The replacement string (case-sensitive).
//
// Example:
//   php change-links.php 'm!^http://foo.com/!' 'foo.com' 'bar.com'
//
// Bulk changes all resource URLs matching a pattern. Useful if, for
// example, a remote data source changes the location of all its files.
//
// Requirements:
// - the class ../lib/CKANClient.php must be readable
// - the file ./config.php must exist and have correct connection
//   information for a CKAN 2.* instance (see TEMPLATE.config.php
//   for more information).
//
// Started May 2014 by David Megginson.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/../lib/CKANClient.php');
require_once(__DIR__ . '/config.php');

if (count($argv) != 4) {
  die("Usage: php {$argv[0]} <url-pattern> <from-string> <to-string>\n");
}

list($script_name, $url_pattern, $from_string, $to_string) = ($argv);

// Set up the CKAN connection with values from ./config.php
$ckan = new CKANClient($ckan_base_url, $ckan_api_key, $ckan_user_agent);

// Get all the package ids for this instance
$package_ids = $ckan->package_list();
foreach ($package_ids as $package_id) {
  $package = $ckan->package_show($package_id);
  
  // Get all the resources for this pacakge
  $resources = $package->resources;
  foreach ($resources as $resource) {
    if (preg_match($url_pattern, $resource->url)) {
      print("Match: {$resource->url}\n");
    }
  }
}

