setup:
	composer install
	cp -n api/config/params-local.php.example           api/config/params-local.php|| true
	cp -n backend/config/codeception-local.php.example  backend/config/codeception-local.php|| true
	cp -n backend/config/main-local.php.example         backend/config/main-local.php|| true
	cp -n backend/config/params-local.php.example       backend/config/params-local.php|| true
	cp -n backend/config/test-local.php.example         backend/config/test-local.php|| true
	cp -n frontend/config/codeception-local.php.example frontend/config/codeception-local.php|| true
	cp -n frontend/config/main-local.php.example        frontend/config/main-local.php|| true
	cp -n frontend/config/params-local.php.example      frontend/config/params-local.php|| true
	cp -n frontend/config/test-local.php.example        frontend/config/test-local.php|| true
	cp -n common/config/codeception-local.php.example   common/config/codeception-local.php|| true
	cp -n common/config/main-local.php.example          common/config/main-local.php|| true
	cp -n common/config/params-local.php.example        common/config/params-local.php|| true
	cp -n common/config/test-local.php.example          common/config/test-local.php|| true
