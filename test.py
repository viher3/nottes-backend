import os

print "Testing Nottes backend ..."

# commands 
testCmds = [
	'php bin/console doctrine:schema:drop --force',
	'php bin/console doctrine:schema:create',
	'php bin/console doctrine:fixtures:load --append',
	'php vendor/bin/simple-phpunit tests'
]

# excuting commands
for cmd in testCmds:
	os.system(cmd)