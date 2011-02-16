#!/bin/sh
/bin/mount -o remount,usrquota,noatime {{$node.dev}}
/sbin/quotaon {{$node.dev}}
