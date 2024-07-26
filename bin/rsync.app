#!/bin/bash

DEST_PREFIX=$1
shift

DEPLOY_DEST=${DEST_PREFIX}www/wordpress-hathitrust
DEPLOY_SRC=/htapps/test.www/wordpress-hathitrust

EXCLUDE=$(cat <<EOT
  --exclude .github
  --exclude .git
  --exclude .gitignore
  --exclude $DEPLOY_SRC/node_modules
EOT
)

/usr/bin/rsync "$@" $EXCLUDE $DEPLOY_DEST