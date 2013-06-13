#!/bin/sh
    PARENT_DIR=$(pwd);
$PARENT_DIR/vendor/bin/phpmd lib/,templates,www text codesize
#,unusedcode,naming
