. bin/config.inc

ls $DB_DIR_FILES | while read ligne  
do
    if [ -f $DB_DIR_INFOS/$ligne ] || [ -f $DB_DIR_SEARCH/$ligne ]
    then
        continue
    fi

    FILE=$(ls -l """$DB_DIR_FILES/$ligne""" | sed -r 's/.+-> //')
    
    if [ $(echo $FILE | grep -Ei "s[0-9]+e[0-9]+" | wc -l ) == "1" ]
    then
	continue
    fi

    NAME=$(echo $FILE | sed -r 's|^.+/||' | sed -r 's/\.[a-zA-Z0-9]+$//' | sed -r 's/[\._\-]+/ /g' | sed -r 's/[ ]+/ /g' | sed 's/^ //' | sed 's/ $//' | sed -r 's/(lol|funky|lotus|pop)$//i' | sed -r 's/(subforced|brrip|x264|ac3|720p|bluray|mhd|ftx|xvid|2t|HDrip|2hd|1080p|multi|no-tag|no tag|\([0-9a-z ]+\)|pophd|hdtv)//ig' | sed 's/(//g' | sed 's/)//g' | sed 's/\[//g' | sed 's/\]//g' | sed -r 's/[ ]+$//' | sed -r 's/[0-9]+$//' | sed -r 's/[ ]+$//')
    
    echo "Build name $ligne : $NAME"

    echo $NAME > $DB_DIR_SEARCH/$ligne
    echo "#"$FILE >> $DB_DIR_SEARCH/$ligne
done
