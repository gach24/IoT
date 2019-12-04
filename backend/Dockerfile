FROM node:12.13.1-stretch
# MAINTAINER Germán Carreño <german@docencia.sonofe.es>

WORKDIR /usr/src/app


COPY src/* ./

RUN npm install

EXPOSE 8080

CMD [ "node", "server.js" ]




