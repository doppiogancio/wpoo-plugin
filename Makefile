cs-check:
	php vendor/bin/phpcs --standard=PSR12 --standard=ruleset.xml src/

cs-fix:
	php vendor/bin/phpcbf --standard=PSR12 --standard=ruleset.xml src/