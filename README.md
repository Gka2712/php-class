1.dockerコンテナを起動する
  docker compose up -d
2.サーバに入る
  docker exec -it php-container bash
3.composerをinstallする
  cd /var/www/html
  curl -sS https://getcomposer.org/installer |php
  mv composer.phar /usr/local/bin/composer
  composer install
  
