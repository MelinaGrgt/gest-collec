name: Release Workflow

on:
release:
types: [created]

jobs:
deploy:
runs-on: ubuntu-latest

steps:
- name: Checkout repository
uses: actions/checkout@v4

- name: Install Composer dependencies
run: composer install --no-dev

- name: Modify .env
run: |
sed -i 's/ENVIRONMENT = developement/ENVIRONMENT = production/g' .env
cat .env

- name: Modify App.php
run: |
sed -i "s|\$baseURL = '.*';|\$baseURL = '${{ secrets.BASE_URL }}';|g" app/Config/App.php
cat app/Config/App.php

- name: Create .htaccess for root directory
run: |
echo '<IfModule mod_rewrite.c>' > .htaccess
    echo '    RewriteEngine On' >> .htaccess
    echo "    RewriteRule ^(.*)$ public/\$1 [L]" >> .htaccess
    echo '</IfModule>' >> .htaccess
echo '' >> .htaccess
echo '<FilesMatch "^\.">' >> .htaccess
echo '    Require all denied' >> .htaccess
echo '    Satisfy All' >> .htaccess
echo '</FilesMatch>' >> .htaccess

- name: Create .htaccess for public directory
run: |
echo '<IfModule mod_rewrite.c>' > public/.htaccess
    echo '    Options +FollowSymlinks' >> public/.htaccess
    echo '    RewriteEngine On' >> public/.htaccess
    echo "    RewriteBase ${{ secrets.URL_PREFIX }}/public" >> public/.htaccess
    echo '' >> public/.htaccess
    echo '    # Redirect Trailing Slashes...' >> public/.htaccess
    echo '    RewriteCond %{REQUEST_FILENAME} !-d' >> public/.htaccess
    echo '    RewriteCond %{REQUEST_URI} (.+)/$' >> public/.htaccess
    echo '    RewriteRule ^ %1 [L,R=301]' >> public/.htaccess
    echo '' >> public/.htaccess
    echo '    # Rewrite "www.example.com" -> "example.com"' >> public/.htaccess
    echo '    RewriteCond %{HTTPS} !=on' >> public/.htaccess
    echo '    RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]' >> public/.htaccess
    echo '    RewriteRule ^ http://%1%{REQUEST_URI} [R=301,L]' >> public/.htaccess
    echo '' >> public/.htaccess
    echo '    # Checks to see if the user is attempting to access a valid file,' >> public/.htaccess
    echo '    # such as an image or css document, if this isn'"'"'t true it sends the' >> public/.htaccess
    echo '    # request to the front controller, index.php' >> public/.htaccess
    echo '    RewriteCond %{REQUEST_FILENAME} !-f' >> public/.htaccess
    echo '    RewriteCond %{REQUEST_FILENAME} !-d' >> public/.htaccess
    echo '    RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]' >> public/.htaccess
    echo '' >> public/.htaccess
    echo '    # Ensure Authorization header is passed along' >> public/.htaccess
    echo '    RewriteCond %{HTTP:Authorization} .' >> public/.htaccess
    echo '    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]' >> public/.htaccess
    echo '</IfModule>' >> public/.htaccess
echo '' >> public/.htaccess
echo '<IfModule !mod_rewrite.c>' >> public/.htaccess
    echo '    ErrorDocument 404 index.php' >> public/.htaccess
    echo '</IfModule>' >> public/.htaccess

- name: Deploy to FTP
uses: SamKirkland/FTP-Deploy-Action@v4.3.5
with:
server: ${{ secrets.FTP_SERVEUR }}
username: ${{ secrets.FTP_USERNAME }}
password: ${{ secrets.FTP_PASSWORD }}

- name: Wait for files to deploy
run: sleep 60

- name: Run Migrations
run: |
php spark migrate
