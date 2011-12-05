#!/bin/bash
git pull
VERSION=`cat framework/runtime.php |grep VHMS_VERSION|grep -E '[.0-9]+' -o -m 1`
rm -rf /tmp/vhms-$VERSION
rm -f /tmp/kangle-vhms-$VERSION.zip
mkdir /tmp/vhms-$VERSION/upload -p
cp * /tmp/vhms-$VERSION/upload -ar
rm -rf /tmp/vhms-$VERSION/upload/readme
rm -f /tmp/vhms-$VERSION/upload/*.sh
cp readme /tmp/vhms-$VERSION -ar
cd /tmp/
zip -qr kangle-vhms-$VERSION.zip vhms-$VERSION
echo "success package to zip file : /tmp/kangle-vhms-$VERSION.zip"
