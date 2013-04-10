#!/bin/sh
export PHP_IDE_CONFIG="serverName=serviceregistry.demo.openconext.org"
export XDEBUG_CONFIG="idekey=PhpStorm, remote_connect_back=0, remote_host=172.18.5.1"

export APPLICATION_ENV="dbtest"

@todo improve this sometime
# Fill in correct credentials here
dbUser=""
dbPass=""
dbName="serviceregistry"
dbNameTest="serviceregistry_test"
dbCredentials=" -u${dbUser} -p${dbPass}"

currentDir=`pwd`
mysqlCommand="mysql ${dbCredentials}"
migrateCommand="${currentDir}/bin/migrate"

# @todo see if some data can be provisioned
echo 'Test patches against base install'

# Create test database
echo "DROP DATABASE IF EXISTS ${dbNameTest};" | ${mysqlCommand}
echo "CREATE DATABASE ${dbNameTest};" | ${mysqlCommand}

# Run migrate scripts note that the first script actually creates the database structure
${migrateCommand}

echo 'Test patches against real database'

exportFile="/tmp/serviceregistry-export.sql"

# Export Serviceregistry database
mysqldump ${dbCredentials} ${dbName} > ${exportFile}

# Create test database
echo "DROP DATABASE IF EXISTS ${dbNameTest};" | ${mysqlCommand}
echo "CREATE DATABASE ${dbNameTest};" | ${mysqlCommand}

#Import export in testdatabase
${mysqlCommand} ${dbNameTest} < ${exportFile}

#echo "DELETE FROM ${dbNameTest}.db_changelog WHERE patch_number = 16;" | ${mysqlCommand}

${migrateCommand}