<?php
////////////////////////////////////////////////////////////////////////
// import-airports.php - create CKAN datasets for OurAirports.
//
// usage:
//   php import-airports.php
//
// Creates a dataset and resource for the airports in each country that
// has a corresponding group in the CKAN instance (using the ISO alpha3
// country code as the group id).  If the dataset already exists, it will
// be updated. The actual data lives at the OurAirports web site.
//
// Requirements:
// - the class ../lib/CKANClient.php must be readable
// - the file ../data/country-mapping.csv must be readable
// - the file ./config.php must exist and have correct connection
//   information for a CKAN 2.* instance (see TEMPLATE.config.php
//   for more information).
//
// Started April 2014 by David Megginson.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/../lib/CKANClient.php');
require_once(__DIR__ . '/config.php');

// The data file containing ISO alpha2:alpha3 country-code mappings and
// country names.
$country_data_file = __DIR__ . '/../data/country-mapping.csv';

// Set up the CKAN connection
$ckan = new CKANClient($ckan_base_url, $ckan_api_key, $ckan_user_agent);

// Open the CSV data file
$input = fopen($country_data_file, 'r');
if (!$input) die("Cannot open $file\n");

// Read the header row
$headers = fgetcsv($input);

// Read the data rows
while ($row = fgetcsv($input)) {
  $data = array_combine($headers, $row);

  $iso2 = $data['iso2'];
  $iso3 = strtolower($data['iso3']);
  $name = $data['name'];

  // Validate that we have the data we need
  if (!$iso2) {
    print("Skipping $iso3 ... no ISO2 code\n");
    continue;
  } else if (!$iso3) {
    print("Skipping $iso2 ... no ISO3 code\n");
    continue;
  } else if (!$name) {
    print("Skipping $iso3 ... no name\n");
    continue;
  }

  // See if the CKAN group exists; if not, skip
  $result = $ckan->group_show($iso3);
  if (!$result->success) {
    print("Skipping $iso3 ... group does not exist\n");
    continue;
  }

  $package_id = "ourairports-$iso3";

  $options = array(
    'title' => "Airports in $name",
    'notes' => "List of airports in $name, with latitude and longitude.  Unverified community data from ourairports.com.",
    'license_id' => 'other-pd',
    'url' => "http://ourairports.com/countries/$iso2/",
    'package_creator' => 'david',
    'maintainer' => 'OurAirports',
    'source' => 'OurAirports',
    'maintainer_email' => 'contact@ourairports.com',
    'groups' => [
      ['name' => $iso3]
    ],
    'tags' => [
      ['name' => 'geodata'],
      ['name' => 'transportation'],
      ['name' => 'aviation']
    ],
    'resources' => [
      [
        'package_id' => $package_id,
        'url' => "http://ourairports.com/countries/$iso2/airports.csv",
        'name' => "List of airports in $name",
        'description' => "Spreadsheet listing airport locations in $name.  Unverified community data from ourairports.com.  Note that this data comes live from the web site, and can change at any time.",
        'format' => 'csv',
        'mimetype' => 'text/csv',
      ],
    ],
  );

  // See if the CKAN package already exists
  $result = $ckan->package_show($package_id);

  if ($result->success) {
    // Update if it already exists
    print("Updating dataset $package_id in CKAN group $iso3 ... ");
    $result = $ckan->package_update($package_id, 'ourairports', $options);
  } else {
    // Create if it doesn't exist
    print("Adding dataset $package_id to CKAN group $iso3 ... ");
    $result = $ckan->package_create($package_id, 'ourairports', $options);
  }

  // Show the result
  if ($result->success) {
    print("Succeeded!\n");
  } else {
    print("FAILED!\n");
    print_r($result);
  }

}

fclose($input);

// end
