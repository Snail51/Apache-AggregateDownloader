#!/bin/bash

source=$1;
destination=$2;
dirname=$3;

# Check if the input contains a semicolon, ampersand, or newline character
if [[ $source =~ ";" ]] || [[ $destination =~ ";" ]] || [[ $dirname =~ ";" ]] || [[ $source =~ "&" ]] || [[ $destination =~ "&" ]] || [[ $dirname =~ "&" ]] || [[ $source =~ $'\n' ]] || [[ $destination =~ $'\n' ]] || [[ $dirname =~ $'\n' ]]; then
   #"Invalid input. Semicolon, ampersand, or newline characters are not allowed."
   return 1
fi


cd "$source";
cd "..";
zip -0 -r -n .zip:.mp4:.mov:.7z:.7zip "$destination" "./$dirname";