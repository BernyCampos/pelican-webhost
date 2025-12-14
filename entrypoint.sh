#!/bin/bash
set -e

sleep 1
cd /home/container

# --- FASE 1: RESTAURAR CONFIGURACIÓN ---
if [ ! -d "/home/container/nginx" ] || [ -z "$(ls -A /home/container/nginx)" ]; then
    echo "⚙️  Configuración de Nginx no detectada. Instalando defaults..."
    mkdir -p /home/container/nginx
    cp -r /image_defaults/nginx/* /home/container/nginx/
fi

# --- FASE 2: GIT ---
if [ -n "${GIT_ADDRESS}" ]; then
    echo "🔍 Verificando Repositorio Git..."

    if [ -n "${USERNAME}" ] && [ -n "${ACCESS_TOKEN}" ]; then
        CLEAN_URL=$(echo "${GIT_ADDRESS}" | sed 's~http[s]*://~~g')
        AUTH_GIT_ADDRESS="https://${USERNAME}:${ACCESS_TOKEN}@${CLEAN_URL}"
    else
        AUTH_GIT_ADDRESS="${GIT_ADDRESS}"
    fi

    if [ -d ".git" ]; then
        if [ "${AUTO_UPDATE}" = "1" ] || [ "${AUTO_UPDATE}" = "true" ]; then
            echo "🔄 Actualizando repositorio..."
            git pull origin ${BRANCH:-main}
        fi
    else
        echo "⬇️ Clonando repositorio..."
        git clone --branch ${BRANCH:-main} "${AUTH_GIT_ADDRESS}" .
    fi
fi

# --- FASE 3: COMPOSER ---
if [ -f "composer.json" ]; then
    echo "📦 Instalando dependencias PHP..."
    composer install --no-dev --optimize-autoloader
fi

# --- FASE 4: ARRANQUE REAL ---
echo "🚀 Iniciando servidor web"
exec nginx -g "daemon off;"
