. bin/config.inc

ls $DB_DIR_SEARCH | while read ligne  
do
    if [ -f $DB_DIR_INFOS/$ligne ]
    then
        rm -f $DB_DIR_SEARCH/$ligne
        continue
    fi
    
    FILM_NAME=$(head -n 1 $DB_DIR_SEARCH/$ligne)
    echo "Searching info : $FILM_NAME"

    JSON=$(php bin/getJsonFilm.php "$FILM_NAME")

    if [ "$JSON" == "" ]
    then
        continue
    fi

    echo $JSON > $DB_DIR_INFOS/$ligne
    rm -f $DB_DIR_SEARCH/$ligne
done
