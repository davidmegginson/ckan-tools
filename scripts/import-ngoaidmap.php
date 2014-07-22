<?php
////////////////////////////////////////////////////////////////////////
// import-ngoaidmap.php - create CKAN datasets for NGO Aid Map countries.
//
// usage:
//   php import-ngoaidmap.php
//
// Requirements:
// - the class ../lib/CKANClient.php must be readable
// - the file ../data/ngoaidmap.csv must be readable
// - the file ./config.php must exist and have correct connection
//   information for a CKAN 2.* instance (see TEMPLATE.config.php
//   for more information).
//
// Started July 2014 by David Megginson.
////////////////////////////////////////////////////////////////////////

require_once(__DIR__ . '/../lib/CKANClient.php');
require_once(__DIR__ . '/config.php');

// The data file containing ISO alpha2:alpha3 country-code mappings and
// country names.
$country_data_file = __DIR__ . '/../data/ngoaidmap.csv';

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

  $id = 0 + $data['id'];
  $name = $data['name'];
  $iso3 = strtolower($data['iso3']);

  // See if the CKAN group exists; if not, skip
  $result = $ckan->group_show($iso3);
  if (!$result->success) {
    print("Skipping $iso3 ... group does not exist\n");
    continue;
  }

  $package_id = "ngoaidmap-$iso3";

  $options = array(
    'title' => "InterAction member activities in $name",
    'notes' => "List of aid activities by InterAction members in $name.  Source: http://ngoaidmap.org/location/$id",
    'license_id' => 'other-pd',
    'url' => "http://ngoaidmap.org/location/$id",
    'package_creator' => 'david',
    'maintainer' => 'InterAction',
    'dataset_source' => 'InterAction NGO Aid Map',
    'methodology' => 'Other',
    'method_other' => 'InterAction member-contributed data.',
    'caveats' => 'Unverified live data. May change at any time. For information on data limitations, visit http://ngoaidmap.org/p/data',
    'maintainer_email' => 'MappingInfo@InterAction.org',
    'groups' => [
      ['name' => $iso3]
    ],
    'tags' => [
      ['name' => '3w'],
      ['name' => 'ngo'],
    ],
    'resources' => [
      [
        'package_id' => $package_id,
        'url' => "http://ngoaidmap.org/location/$id?format=csv",
        'name' => "List of InterAction member aid activities in $name",
        'description' => "Spreadsheet listing InterAction member activities in $name.  Unverified member-uploaded data.  Note that this data comes live from the web site, and can change at any time.",
        'format' => 'csv',
        'mimetype' => 'text/csv',
      ],
      [
        'package_id' => $package_id,
        'url' => "http://ngoaidmap.org/location/$id?format=xls",
        'name' => "List of InterAction member aid activities in $name",
        'description' => "Spreadsheet listing InterAction member activities in $name.  Unverified member-uploaded data.  Note that this data comes live from the web site, and can change at any time.",
        'format' => 'xls',
        'mimetype' => 'application/vnd.ms-excel',
      ],
      [
        'package_id' => $package_id,
        'url' => "http://ngoaidmap.org/location/$id?format=kml",
        'name' => "List of InterAction member aid activities in $name",
        'description' => "Map data showing InterAction member activities in $name.  Unverified member-uploaded data.  Note that this data comes live from the web site, and can change at any time.",
        'format' => 'kml',
        'mimetype' => 'application/vnd.google-earth.kml+xml',
      ],
    ],
  );

  // See if the CKAN package already exists
  $result = $ckan->package_show($package_id);

  if ($result->success) {
    // Update if it already exists
    print("Updating dataset $package_id in CKAN group $iso3 ... ");
    $result = $ckan->package_update($package_id, 'interaction', $options);
  } else {
    // Create if it doesn't exist
    print("Adding dataset $package_id to CKAN group $iso3 ... ");
    $result = $ckan->package_create($package_id, 'interaction', $options);
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
