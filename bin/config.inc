DB_DIR=$(cat config/config.json | jq '.db_dir' | sed 's/"//g')
DB_DIR_FILES=$DB_DIR/files
DB_DIR_INFOS=$DB_DIR/infos
DB_DIR_SEARCH=$DB_DIR/search
MEDIA_DIR=$(cat config/config.json | jq '.media_dir' | sed 's/"//g')
