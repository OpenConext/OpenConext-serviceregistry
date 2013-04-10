#!/bin/sh
# Application env is used in the PHP config file to overwrite the database name
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

${migrateCommand}