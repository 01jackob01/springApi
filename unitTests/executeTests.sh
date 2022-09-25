#!bin/sh

echo "Execute tests"

phpUnitDir=/var/www/html

if [ -z $1 ]; then
    folder=tests
else
    echo "Execute directory $1"
    folder=tests/$1
fi

if [ -z $2 ]; then
    script=''
else
    echo "Execute file $2"
    script=/$2
fi

$phpUnitDir/vendor/bin/phpunit $folder$script