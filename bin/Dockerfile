FROM php:8.1-apache

LABEL maintainer="Sayan Muhury <sayan@consilioussystems.com>"

RUN apt-get upgrade && apt-get update && ACCEPT_EULA=Y && apt-get install --fix-missing -y \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libmemcached-dev \
        libzip-dev \
        libgeoip-dev \
        libxml2-dev \
        libxslt-dev \
        libtidy-dev \
        libssl-dev \
        zlib1g-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libaio1 \
        apt-file \
        jpegoptim optipng pngquant gifsicle \
        wget \
        vim \
        gnupg \
        gnupg2 \
        zip \
        curl \
        git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql ; \
    docker-php-ext-install pdo_sqlite ; \
    docker-php-ext-install mysqli ; \
    docker-php-ext-install curl ; \
    docker-php-ext-install tokenizer ; \
    docker-php-ext-install json ; \
    docker-php-ext-install zip ; \
    docker-php-ext-install -j$(nproc) intl ; \
    docker-php-ext-install mbstring zip exif pcntl; \
    docker-php-ext-install gettext

RUN docker-php-ext-install gd
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/

RUN a2enmod ssl; \
    a2enmod rewrite headers; \
    a2enmod proxy; \
    a2enmod proxy_http; \
    a2enmod proxy_ajp; \
    a2enmod rewrite; \
    a2enmod deflate; \
    a2enmod headers; \
    a2enmod proxy_balancer; \
    a2enmod proxy_connect; \
    a2enmod proxy_html;

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

###########################################################################
# hr non-root user:
###########################################################################

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# always run apt update when start and after add new source list, then clean up at end.
RUN apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    groupadd -g 1000 hr && \
    useradd -u 1000 -g root -m hr -G root && \
    usermod -p "*" hr

###########################################################################
# Set Timezone
###########################################################################

ARG TZ=UTC
ENV TZ ${TZ}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

###########################################################################
# User Aliases
###########################################################################

USER root

COPY ./workspace/aliases.sh /root/aliases.sh
COPY ./workspace/aliases.sh /home/hr/aliases.sh
COPY ./workspace/ports.conf /etc/apache2/ports.conf

RUN sed -i 's/\r//' /root/aliases.sh && \
    sed -i 's/\r//' /home/hr/aliases.sh && \
    chown hr:hr /home/hr/aliases.sh && \
    echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	echo "" >> ~/.bashrc

# RUN mv /etc/apache2/ports.conf /etc/apache2/ports.conf.default

USER hr

RUN echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	echo "" >> ~/.bashrc

###########################################################################
# Crontab
###########################################################################

USER root

COPY ./workspace/crontab /etc/cron.d

RUN chmod -R 644 /etc/cron.d

###########################################################################
# Node / NVM:
###########################################################################

# Check if NVM needs to be installed
ARG NODE_VERSION=node
ENV NODE_VERSION ${NODE_VERSION}
ARG INSTALL_NODE=false
ARG INSTALL_NPM_GULP=false
ARG INSTALL_NPM_BOWER=false
ARG INSTALL_NPM_VUE_CLI=false
ARG NPM_REGISTRY
ENV NPM_REGISTRY ${NPM_REGISTRY}

RUN if [ ${INSTALL_NODE} = true ]; then \
    # Install nvm (A Node Version Manager)
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash \
    && . /root/.nvm/nvm.sh \
    && nvm install ${NODE_VERSION} \
    && nvm use ${NODE_VERSION} \
    && nvm alias ${NODE_VERSION} \
    && if [ ${NPM_REGISTRY} ]; then \
    npm config set registry ${NPM_REGISTRY} \
    ;fi \
    && if [ ${INSTALL_NPM_GULP} = true ]; then \
    npm install -g gulp \
    ;fi \
    && if [ ${INSTALL_NPM_BOWER} = true ]; then \
    npm install -g bower \
    ;fi \
    && if [ ${INSTALL_NPM_VUE_CLI} = true ]; then \
    npm install -g @vue/cli \
    ;fi \
    ;fi

# Wouldn't execute when added to the RUN statement in the above block
# Source NVM when loading bash since ~/.profile isn't loaded on non-login shell
RUN if [ ${INSTALL_NODE} = true ]; then \
    echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="root/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc \
    ;fi

# Add NVM binaries to root's .bashrc
USER root

RUN if [ ${INSTALL_NODE} = true ]; then \
    echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="/home/hr/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc \
    ;fi

# Add PATH for node
ENV PATH $PATH:$NVM_DIR/versions/node/v${NODE_VERSION}/bin

RUN if [ ${NPM_REGISTRY} ]; then \
    . ~/.bashrc && npm config set registry ${NPM_REGISTRY} \
    ;fi


#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# EXPOSE 4200
# EXPOSE 80 443
EXPOSE 80 443 4200

# Set default work directory
WORKDIR /var/www/html
