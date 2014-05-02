<?php
////////////////////////////////////////////////////////////////////////
// test-ckan-client.php - simple access test for a CKAN client.
//
// usage:
//   php test-ckan-client.php
//
// Attempts to list all of the datasets (packages) on a remote CKAN
// site. Tests whether config.php is set up correctly, and whether
// the remote CKAN site is reachable.
//
// Requirements:
// - the class ../lib/CKANClient.php must be readable
// - the file ./config.php must exist and have correct connection
//   information for a CKAN 2.* instance (see TEMPLATE.config.php
//   for more information).
//
// Started April 2014 by David Megginson.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/../lib/CKANClient.php');
require_once(__DIR__ . '/config.php');

// Connect to CKAN
$ckan = new CKANClient($ckan_base_url, $ckan_api_key, $ckan_user_agent);

// Print a formatted version of the list of datasets.
print_r($ckan->package_list());

// end





