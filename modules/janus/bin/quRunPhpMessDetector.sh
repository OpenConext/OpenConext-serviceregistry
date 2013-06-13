#!/bin/sh
# Runs the PHP mess detector on the most important code
PARENT_DIR=$(pwd);
$PARENT_DIR/vendor/bin/phpmd lib/,templates,www text codesize
#,unusedcode,naming
