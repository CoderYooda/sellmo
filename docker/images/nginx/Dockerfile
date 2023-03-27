FROM node:16.13.0-alpine AS node-base

WORKDIR /application

FROM node-base AS front-builder

COPY src/package.json src/package-lock.json ./
RUN NODE_ENV=production npm ci

COPY src/resources/ ./resources/
COPY src/public/ ./public/
COPY src/webpack.*.js ./

RUN touch artisan \
    && npm run build

FROM nginx:alpine AS nginx-base

WORKDIR /application

COPY docker/nginx/sellmo.conf /etc/nginx/conf.d/sellmo.conf

FROM nginx-base AS nginx

COPY --from=front-builder --chown=www-data:www-data /application/public/ public/
