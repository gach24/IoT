FROM node:12.13.1-stretch
# MAINTAINER Germán Carreño <german@docencia.sonofe.es>

RUN apt-get update && apt-get install -y vim

WORKDIR /usr/src/app



COPY src/* ./

RUN npm install

EXPOSE 8080

CMD [ "npm", "start" ]




