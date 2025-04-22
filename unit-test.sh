#!/bin/bash

app_path=appservice
app_directory=/appservice/

echo "****************************"
echo "** Runing Unit Test ***"
echo "****************************"

docker exec -t $app_path bash  -c  "${app_directory};  vendor/bin/phpunit"