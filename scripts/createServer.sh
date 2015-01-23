########################################
#
# Author: Piotr Sroczkowski
#
########################################

searchTerm='/var/www/html/cgi'
file='/etc/apache2/apache2.conf'
grep -q "$searchTerm" "$file" ||
sudo cat <<EOF >> $file

#added automatically
<Directory "/var/www/html/cgi">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
#end added automatically

EOF
