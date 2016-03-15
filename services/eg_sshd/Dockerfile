# sshd
#
# VERSION               0.0.2

FROM ubuntu:14.04
MAINTAINER Sven Dowideit <SvenDowideit@docker.com>

RUN apt-get update && apt-get install -y openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:toor' | chpasswd
RUN sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

# Add drush to our sshd container
RUN apt-get -y install curl php5-cli php5-mysql mysql-client
RUN \
curl -sS https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer && \
ln -s /usr/local/bin/composer /usr/bin/composer && \
echo "deb http://httpredir.debian.org/debian jessie main contrib" >> /etc/apt/sources.list && \
apt-get install git -y && \
git clone --depth 1 https://github.com/drush-ops/drush.git /usr/local/src/drush && \
ln -s /usr/local/src/drush/drush /usr/bin/drush && \
cd /usr/local/src/drush && composer install

EXPOSE 22
CMD ["/usr/sbin/sshd", "-D"]

