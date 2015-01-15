########################################
#
# Author: Piotr Sroczkowski
#
########################################

cd $(dirname $(realpath $0))
cd ..
cat <<EOF > app/parameters.php
<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

class Parameters {
    /** MySQL database name */
    const DB_NAME = '$1';

    /** MySQL database username */
    const DB_USER = '$2';

    /** MySQL database password */
    const DB_PASSWORD = '$3';

    /** MySQL hostname */
    const DB_HOST = '$4';

    /** Uploads directory */
    const UPLOADS_DIR = '$5';
}
EOF
