########################################
#
# Author: Piotr Sroczkowski
#
########################################

# script to set up the app on any brand new debian derivative (after litte changes on any brand new linux)
# run this script with at least 1.8 GB of RAM
db=Parla
dbUser=Parla
dbPass=GAH13PVjpFwt7smCJkun
dbHost=localhost
path=cgi/examples/
project=Parla
domain=localhost
uploadsDir=web/uploads
smtp_server='
smtp_user=

#sudo apt-get update &&
toinst=(realpath curl git apache2 php5 php5-cli mysql-client mysql-server php5-mysql) &&
for i in "${toinst[@]}"; do
    echo $i &&
    echo y | sudo apt-get install $i
done &&
cd $(dirname $(realpath $0)) &&
./createParams.sh $db $dbUser $dbPass $dbHost $uploadsDir $domain $path $project &&
cd .. &&
printf "\n\nmysql:" &&
mysql -u root -p -e "grant all on $db.* to '$dbUser'@'localhost' identified by '$dbPass'; flush privileges; drop database if exists $db; create database $db" &&
mysql -u root -p $db < db/db.sql && 


#cd ~ &&
#if [ ! -f composer.phar ]; then
    #curl -sS https://getcomposer.org/installer | php
#fi &&
#cd - &&
#php ~/composer.phar update --no-scripts &&

pushd . &&
sudo chmod -R 777 . &&
while [ `pwd` != '/' ]; do
    sudo chmod 777 . &&
    cd ..
done &&
popd &&
#chmod 644 .htaccess &&
chmod 770 scripts/* &&
sudo mkdir -p /var/www/html/public/$path &&
if [ -a /var/www/html/public/$path$project ]; then
    sudo rm /var/www/html/public/$path$project
fi &&
sudo ln -s `realpath .` /var/www/html/public/$path$project
sudo /etc/init.d/apache2 restart &&
gnome-open http://$domain/public/$path$project/web/app.php
