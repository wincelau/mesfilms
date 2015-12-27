#!/bin/bash

. bin/config.inc

ls $DB_DIR_FILES | while read ligne  
do
    FILE=$(ls -l """$DB_DIR_FILES/$ligne""" | sed -r 's/.+-> //')
    if [ ! -f """$FILE""" ]
    then
        rm -f """$DB_DIR_FILES/$ligne"""
    fi
done

find $MEDIA_DIR -iname "*.avi" -o -iname "*.mkv" -o -iname "*.mp4" -o -iname "*.vob" | while read ligne  
do
    if [ $(ls -l $DB_DIR_FILES | grep -F "$ligne" | wc -l) != "0" ]
    then
        continue
    fi
    echo $ligne
    MD5SUM=$(md5sum """$ligne""" | cut -d " " -f 1)
    if [ ! -f $DB_DIR_FILES/$MD5SUM ] 
    then
        echo "Referencing file $ligne"
        ln -s """$ligne""" $DB_DIR_FILES/$MD5SUM
    fi
done
