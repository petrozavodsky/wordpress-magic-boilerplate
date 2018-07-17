#!/bin/bash

if [[ $1 = '' ]]
then
echo "Please enter plugin slug (use CamelCase)"
else

find . -depth -type d -path '*WordpressMagicBoilerplate' | sed 'p;s:WordpressMagicBoilerplate:'$1':' | xargs -n2 mv

find . -depth -type f -name 'WordpressMagicBoilerplate*' | sed 'p;s:WordpressMagicBoilerplate:'$1':' | xargs -n2 mv

find . -depth -type f -name 'wordpress-magic-boilerplate*' | sed 'p;s:wordpress-magic-boilerplate:'$1':' | xargs -n2 mv

find . -depth -type f \( -name "*.js" -o -name "*.php" -o -name "*.css" -o -name "*.less" -o -name "*.json" -o -name "*.pot" \) -exec sed -i -r    's/WordpressMagicBoilerplate/'$1'/g' {} \;

find . -depth -type f \( -name "*.js" -o -name "*.php" -o -name "*.css" -o -name "*.less" -o -name "*.json" -o -name "*.pot" \) -exec sed -i -r    's/wordpress-magic-boilerplate/'$1'/g' {} \;

rm -rf .git

mv -f $(pwd) "$(dirname "$(pwd)")/$1"

rm -- "$0"
fi