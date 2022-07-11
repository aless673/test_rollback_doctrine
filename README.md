# How to test

```
git clone git@github.com:aless673/test_rollback_doctrine.git
docker-compose up -d
composer.phar install
docker-compose do:da:cr --env=test
docker-compose do:sc:cr --env=test
docker-compose exec -T app vendor/bin/phpunit tests/WebRollbackTest.php
```
