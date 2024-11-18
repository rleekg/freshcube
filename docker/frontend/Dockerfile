FROM node:22.11.0-slim

USER root

RUN userdel --force --remove node

RUN groupadd --gid 1000 user \
  && useradd --uid 1000 --gid user --shell /bin/bash --create-home user

USER user
WORKDIR /app

# Запускаем приложение
CMD ["npm", "run", "dev"]
