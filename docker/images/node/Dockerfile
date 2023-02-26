FROM node:16.3.0-alpine as front

MAINTAINER CoderYooda <CoderYooda@gmail.com>

#EXPOSE 8081

COPY src/ ./application/


WORKDIR /application

RUN npm install
RUN npm run build

#RUN cd public && ls -la
#
#RUN npm install
#RUN npm run dev

CMD ["npm"]