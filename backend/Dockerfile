FROM node:12.13.1-stretch
# MAINTAINER Germán Carreño <german@docencia.sonofe.es>

WORKDIR /usr/src/app

COPY package*.json ./

RUN npm install
RUN npm install express --save

# Bundle app source
COPY src/backend/* .

EXPOSE 8080

CMD [ "node", "server.js" ]




