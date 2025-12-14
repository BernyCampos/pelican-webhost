#!/bin/bash
set -e

# Pequeña espera para red
sleep 1

# Directorio raíz que usa Pelican
cd /home/container

echo "📂 Working directory: $(pwd)"

# -------------------------------------------------
# FASE 1: RESTAURAR CONFIGURACIÓN DE NGINX
# -------------------------------------------------
# Si nginx no existe o está vacío, copiamos defaults
if [ ! -d "/home/container/nginx" ] || [ -z "$(ls -A /home/container/nginx 2>/dev/null)" ]; then
    echo "⚙️  Configuración de Nginx no detectada. Restaurando defaults..."
    mkdir -p /home/container/nginx
    cp -r /image_defaults/nginx/* /home/container/nginx/
    echo "✅ Configuración base de Nginx lista."
fi

# -------------------------------------------------
# FASE 2: GIT (SIN SUBCARPETAS, /home/container)
# -------------------------------------------------
if [ -n "${GIT_ADDRESS}" ]; then
    echo "🔍 Verificando repositorio Git..."

    # Construir URL con token si existe
    if [ -n "${USERNAME}" ] && [ -n "${ACCESS_TOKEN}" ]; then
        CLEAN_URL=$(echo "${GIT_ADDRESS}" | sed 's~http[s]*://~~g')
        AUTH_GIT_ADDRESS="https://${USERNAME}:${ACCESS_TOKEN}@${CLEAN_URL}"
    else
        AUTH_GIT_ADDRESS="${GIT_ADDRESS}"
    fi

    if [ -d ".git" ]; then
        echo "📦 Repo existente detectado."

        if [ "${AUTO_UPDATE}" = "1" ] || [ "${AUTO_UPDATE}" = "true" ]; then
            echo "🔄 Auto Update activo → git pull"
            git pull origin ${BRANCH:-main}
        else
            echo "🛑 Auto Update desactivado. Usando versión actual."
        fi
    else
        echo "⬇️ Clonando repositorio por primera vez en /home/container"
        git clone --branch ${BRANCH:-main} "${AUTH_GIT_ADDRESS}" .
    fi
else
    echo "ℹ️  GIT_ADDRESS vacío. No se clonará ningún repositorio."
fi

# -------------------------------------------------
# FASE 3: DEPENDENCIAS PHP (COMPOSER)
# -------------------------------------------------
if [ -f "composer.json" ]; then
    echo "📦 composer.json detectado. Instalando dependencias..."
    composer install --no-dev --optimize-autoloader
fi

# -------------------------------------------------
# FASE 4: ARRANQUE DEL SERVIDOR (OBLIGATORIO EN FOREGROUND)
# -------------------------------------------------
echo "🚀 Iniciando Nginx en foreground (Pelican ready)"
exec nginx -g "daemon off;"
