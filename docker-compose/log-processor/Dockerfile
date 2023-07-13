FROM php:8.2-cli

# Instalar e habilitar a extensão cURL
RUN apt-get update \
    && apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Definir o diretório de trabalho
WORKDIR /script

CMD ["sh", "-c", "while :; do sleep 1; done"]
