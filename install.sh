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

echo "create public/achievements..."
mkdir -p public/achievements

echo "get Stato framework lib..."
cd lib
svn export --force https://stato.svn.sourceforge.net/svnroot/stato/tags/rel_0-10-0/ Stato
cd ..

echo "set rights on directories..."
sudo chown -R www-data:www-data cache log public/achievements public/pix
sudo chmod 700 cache cache/fragments cache/generated_code cache/templates public/achievements public/pix
sudo chmod 755 log

echo "OK" 
echo ":)"
