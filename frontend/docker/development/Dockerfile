FROM node:23-alpine

WORKDIR /app

COPY ./frontend .

RUN chmod -R 755 /app/docker/development/entrypoint.sh

CMD ["/bin/sh", "-c" ,"./docker/development/entrypoint.sh"]