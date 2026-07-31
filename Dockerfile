FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} appuser && \
    useradd -u ${UID} -g appuser -m appuser

# 安装系统依赖（合并 GD 所需依赖）
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev

# 配置并安装 PHP 扩展（一次性完成，包括 GD）
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# 清理
RUN rm -rf /var/lib/apt/lists/*

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 设置工作目录
WORKDIR /var/www

# 复制项目文件
COPY . /var/www

# 设置权限
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && mkdir -p /tmp/.psysh && chmod 777 /tmp/.psysh

EXPOSE 9000

CMD ["php-fpm"]
