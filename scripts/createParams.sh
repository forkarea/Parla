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

    /** Domain name */
    const DOMAIN_NAME = '$6';

    /** Path to project on server */
    const PATH = '$7';

    /** Name of project on server */
    const PROJECT_NAME = '$8';

    /** SMTP user */
    const SMTP_SERVER = '$9';

    /** SMTP user */
    const SMTP_USER = '${10}';

    /** SMTP password */
    const SMTP_PASSWORD = '${11}';
}
EOF
