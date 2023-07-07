#!/usr/bin/env bash

BINPATH=`dirname $0`

if ! command -v npm &>/dev/null
then
  echo "npm could not be found in PATH"
  exit
fi

cd $BINPATH/..
npm install
errVal=$?
if [ $errVal -ne 0 ]
then
  exit $errVal
fi

npm run build
errVal=$?
if [ $errVal -ne 0 ]
then
  exit $errVal
fi

echo "wordpress-hathitrust build done"
