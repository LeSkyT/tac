default:
	echo "default"

clean:
	rm Makefile.rules
	rm -Rf build

install:
	echo "install"

java:
	apt-get install openjdk-8-jdk

apache2:
	apt-get install apache2

php:
	apt-get install php7.0 php7.0-gd php7.0-json

phalcon:
	./scripts/phalcon.deb.sh
	apt-get install php7.0-phalcon

mongodb:
	apt-get install mongodb
