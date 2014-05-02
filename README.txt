This repository contains scripts for uploading datasets to CKAN for
the Humanitarian Data Exchange (HDX) project at UN-OCHA.

data/     - data files for upload
lib/      - common library code
scripts/  - scripts for uploading datasets

Each script has usage instructions in its opening comments.

Note that the scripts require a file scripts/config.php, which is not
included in this repository. To create it, copy
scripts/TEMPLATE.config.php to scripts/config.php and edit with the
appropriate connection information for your CKAN instance.


Started April 2014 by David Megginson
