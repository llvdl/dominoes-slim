APP_ENV=test php ./cli/drop-database.php
APP_ENV=test php ./cli/migrate.php
php bin/codecept.phar run "$@"
