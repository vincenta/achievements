#!/bin/bash

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

echo "get Stato framework lib..."
cd lib
svn export --force https://stato.svn.sourceforge.net/svnroot/stato/tags/rel_0-10-0/ Stato
cd ..

echo "set rights on cache and log directories..."
sudo chown -R www-data:www-data cache log
sudo chmod 700 cache cache/fragments cache/generated_code cache/templates
sudo chmod 755 log

echo "OK" 
echo ":)"
