FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.4-mysql php7.4-pgsql php7.4-sqlite3 php7.4-xdebug php7.4-xsl php7.4-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && echo "xdebug.mode = debug" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
    && echo "xdebug.mode = coverage" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini

# Enable xdebug options
#    && echo "xdebug.client_host = 127.0.0.1" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.discover_client_host=true" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.start_with_request=yes" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.remote_autostart=on" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.remote_port=9011" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.remote_connect_back=1" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini \
#    && echo "xdebug.idekey=PHPSTORM" >> /etc/php/7.4/fpm/conf.d/20-xdebug.ini


## Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


##install MakeFile
RUN apt-get update && apt-get install make


#Install locate on Ubuntu and Debian
RUN apt-get install locate


# For common edit operations I prefer to install vi (vim-tiny), which uses only 1491 kB or nano which uses 1707 kB.
# In other hand vim uses 28.9 MB.
# We have to remember that in order for apt-get install to work, we have to do the update the first time, so:
# To start the editor in CLI we need to enter vi and nano for nano.
RUN apt-get update \
    && apt-get install -y \
        vim-tiny \
        nano


##Install locate on Ubuntu and Debian
#RUN apt-get update \
#    && apt-get install -y \
#        mlocate \
#        nmap \
#        vim


##install vim Editor
#RUN ["apt-get", "update"]
#RUN ["apt-get", "install", "-y", "vim"]
## path : sudo vim etc/skel/.bashrc