#!/bin/bash
git pull
VERSION=`cat framework/runtime.php |grep VHMS_VERSION|grep -E '[.0-9]+' -o -m 1`
rm -rf /tmp/vhms-$VERSION
rm -f /tmp/vhms-$VERSION.zip
mkdir /tmp/vhms-$VERSION/upload -p
cp * /tmp/vhms-$VERSION/upload -ar
rm -rf /tmp/vhms-$VERSION/upload/readme
rm -f /tmp/vhms-$VERSION/upload/*.sh
cp readme /tmp/vhms-$VERSION -ar
zip -qr /tmp/vhms-$VERSION.zip /tmp/vhms-$VERSION
echo "success package to zip file : /tmp/vhms-$VERSION.zip"
