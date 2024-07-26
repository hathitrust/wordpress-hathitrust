#!/bin/bash

DEST_PREFIX=$1
shift

DEPLOY_DEST=${DEST_PREFIX}www/
DEPLOY_SRC=/htapps/test.www/wordpress-hathitrust

EXCLUDE=$(cat <<EOT
  --exclude .github
  --exclude .git
  --exclude .gitignore
  --exclude node_modules
EOT
)

/usr/bin/rsync "$@" $EXCLUDE $DEPLOY_SRC $DEPLOY_DEST