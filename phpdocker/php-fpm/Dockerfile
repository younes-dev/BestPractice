FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.4-mysql php-xdebug php7.4-xsl php-yaml php7.4-xml php7.4-pgsql pdo_sqlite \
    && docker-php-ext-install pdo pdo_mysql zip php7.4-pgsql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


#install MakeFile
RUN apt-get update && apt-get install make


#install vim Editor
RUN ["apt-get", "update"]
RUN ["apt-get", "install", "-y", "vim"]
# path : sudo vim etc/skel/.bashrc


# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get -y --no-install-recommends install  php-memcached php7.4-mysql php-xdebug php7.4-xsl php-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


#Install locate on Ubuntu and Debian
RUN apt-get update \
    && apt-get install -y \
        mlocate

#Install locate on Ubuntu and Debian
#RUN apt-get install locate

#RUN apt-get update \
#    && apt-get install -y \
#        nmap \
#        vim

# For common edit operations I prefer to install vi (vim-tiny), which uses only 1491 kB or nano which uses 1707 kB.
# In other hand vim uses 28.9 MB.
# We have to remember that in order for apt-get install to work, we have to do the update the first time, so:
#-------------------------
#apt-get update
#apt-get install vim-tiny
#-------------------------
#apt-get update
#apt-get install nano
#To start the editor in CLI we need to enter vi.

