FROM nginx

RUN apt-get update &&  \
    apt-get install -y nginx && \
    mkdir -p /app/public && \
    echo "<?php die('done!');" > /app/public/index.php

EXPOSE 80
