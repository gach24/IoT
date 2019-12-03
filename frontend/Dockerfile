FROM httpd
# MAINTAINER Germán Carreño <german@docencia.sonofe.es>

WORKDIR /usr/local/apache2/htdocs/

COPY src/* .

EXPOSE 8080

CMD [ "node", "server.js" ]




