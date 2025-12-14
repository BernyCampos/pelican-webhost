# Usamos Alpine 3.20
FROM alpine:3.20

# ------------------------
# FASE 1: INSTALACIÓN (Como ROOT)
# ------------------------

# 1. Instalamos herramientas y PHP 8.3
RUN apk --update --no-cache add \
    bash \
    curl \
    git \
    openssh \
    ca-certificates \
    nginx \
    php83 \
    php83-fpm \
    php83-common \
    php83-xml php83-exif php83-session php83-soap php83-openssl \
    php83-gmp php83-pdo_odbc php83-dom php83-pdo php83-zip \
    php83-mysqli php83-sqlite3 php83-pdo_pgsql php83-bcmath php83-gd \
    php83-odbc php83-pdo_mysql php83-pdo_sqlite php83-gettext php83-xmlreader \
    php83-bz2 php83-iconv php83-pdo_dblib php83-curl php83-ctype \
    php83-phar php83-fileinfo php83-mbstring php83-tokenizer php83-simplexml

# 2. Creamos enlaces simbólicos para compatibilidad
RUN ln -sf /usr/bin/php83 /usr/bin/php && \
    ln -sf /usr/sbin/php-fpm83 /usr/sbin/php-fpm8

# 3. Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Creamos el usuario 'container'
RUN adduser -D -h /home/container container

# ------------------------
# FASE 2: COPIA DE ARCHIVOS
# ------------------------

# Copiamos los archivos (Aún pertenecen a Root)
COPY ./entrypoint.sh /entrypoint.sh
COPY ./start.sh /home/container/start.sh
COPY ./nginx /image_defaults/nginx

# ------------------------
# FASE 3: CORRECCIONES Y PERMISOS (Como ROOT)
# ------------------------

# 1. Corregimos formato Windows (sed)
# 2. Damos permisos de ejecución (chmod)
# 3. Transferimos la propiedad de todo al usuario 'container' (chown)
RUN sed -i 's/\r$//' /entrypoint.sh && \
    sed -i 's/\r$//' /home/container/start.sh && \
    chmod +x /entrypoint.sh /home/container/start.sh && \
    chown -R container:container /home/container /entrypoint.sh /image_defaults

# ------------------------
# FASE 4: FINALIZACIÓN
# ------------------------

# AHORA SÍ cambiamos al usuario limitado
USER container
ENV USER=container HOME=/home/container
WORKDIR /home/container

CMD ["/bin/bash", "/entrypoint.sh"]