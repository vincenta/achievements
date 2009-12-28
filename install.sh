#!/bin/bash

echo "creating database..."
php scripts/do.php migrate

echo "create cache/fragments dir..."
mkdir -p cache/fragments

echo "create cache/generated_code..."
mkdir -p cache/generated_code

echo "create cache/templates..."
mkdir -p cache/templates

echo "create log..."
mkdir -p log

echo "create lib..."
mkdir -p lib

if [ -e public/achievements -a -d public/achievements ]; then
    echo "move public/achievements to public/images/achievements..."
    sudo mv public/achievements public/images/
else
    echo "create public/images/achievements..."
    mkdir -p public/images/achievements
fi

if [ -e public/users -a -d public/users ]; then
    echo "move public/users to public/images/users..."
    sudo mv public/users public/images/
else
    echo "create public/images/users..."
    mkdir -p public/images/users
fi

echo "get Stato framework lib..."
cd lib
#svn export --force https://stato.svn.sourceforge.net/svnroot/stato/tags/rel_0-10-0/ Stato
svn export --force https://stato.svn.sourceforge.net/svnroot/stato/branches/0-10-stable/ Stato
cd ..

echo "set rights on directories..."
sudo chown -R www-data:www-data cache log public/images/achievements public/images/users public/pix
sudo chmod 700 cache cache/fragments cache/generated_code cache/templates public/images/achievements public/images/users public/pix
sudo chmod 755 log

echo "OK" 
echo ":)"
