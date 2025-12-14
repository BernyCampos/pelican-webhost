#!/bin/bash

# Esperamos un segundo para asegurar que la red del contenedor esté lista
sleep 1

cd /home/container

# --- FASE 1: RESTAURAR CONFIGURACIÓN (Si se rompió o es nueva instalación) ---
# Si la carpeta nginx no existe o está vacía, copiamos la plantilla que guardamos en la imagen
if [ ! -d "/home/container/nginx" ] || [ -z "$(ls -A /home/container/nginx)" ]; then
    echo "⚙️  Configuración de Nginx no detectada. Instalando defaults..."
    mkdir -p /home/container/nginx
    cp -r /image_defaults/nginx/* /home/container/nginx/
    echo "✅ Configuración base restaurada."
fi

# --- FASE 2: GESTIÓN INTELIGENTE DE GIT (El truco del cambio de repo) ---
if [ -n "${GIT_ADDRESS}" ]; then
    echo "🔍 Verificando Repositorio Git..."
    
    # Definir directorio raíz del código (ajusta si usas subcarpeta)
    # Normalmente en Pelican/Pterodactyl es la raíz /home/container o /home/container/webroot
    # Usaremos la raíz actual para simplificar
    
    # Preparamos la URL con credenciales si las hay (Token/User)
    if [ -n "${USERNAME}" ] && [ -n "${ACCESS_TOKEN}" ]; then
        # Limpiamos https:// para evitar duplicados si el usuario lo puso
        CLEAN_URL=$(echo "${GIT_ADDRESS}" | sed 's~http[s]*://~~g')
        AUTH_GIT_ADDRESS="https://${USERNAME}:${ACCESS_TOKEN}@${CLEAN_URL}"
    else
        AUTH_GIT_ADDRESS="${GIT_ADDRESS}"
    fi

    # Comprobamos si ya existe un repositorio git (.git)
    if [ -d ".git" ]; then
        # YA EXISTE UN REPO: Verificar si la URL ha cambiado
        CURRENT_URL=$(git config --get remote.origin.url)
        
        # Comparamos la URL que hay en disco (vieja) con la del Panel (nueva)
        if [ "${CURRENT_URL}" != "${AUTH_GIT_ADDRESS}" ]; then
            echo "⚠️  CAMBIO DE REPO DETECTADO"
            echo "    Viejo: $CURRENT_URL"
            echo "    Nuevo: $AUTH_GIT_ADDRESS"
            echo "🔄 Borrando referencia vieja y forzando descarga del nuevo..."
            
            # Cambiamos el origen remoto
            git remote set-url origin "${AUTH_GIT_ADDRESS}"
            # Traemos la info del nuevo repo
            git fetch origin
            # Reset hard: Destruye los archivos locales del viejo repo y pone los del nuevo
            git reset --hard origin/${BRANCH:-main}
            
            echo "✅ Cambio de repositorio completado con éxito."
        else
            # Es el mismo repo, verificamos si está activo el Auto Update
            if [ "${AUTO_UPDATE}" = "1" ] || [ "${AUTO_UPDATE}" = "true" ]; then
                echo "🔄 Auto Update activo. Descargando últimos cambios..."
                git pull origin ${BRANCH:-main}
            else
                echo "🛑 Auto Update desactivado. Iniciando con versión actual."
            fi
        fi
    else
        # CARPETA SIN GIT: Clonamos de cero (Primera instalación)
        echo "⬇️  Clonando repositorio inicial..."
        git clone --branch ${BRANCH:-main} "${AUTH_GIT_ADDRESS}" .
    fi
fi

# --- FASE 3: DEPENDENCIAS DE PHP (Composer) ---
# Si existe composer.json, instalamos/actualizamos dependencias
if [ -f "composer.json" ] || [ -f "webroot/composer.json" ]; then
    echo "📦 Detectado composer.json. Instalando dependencias..."
    # Intentamos instalar donde esté el archivo
    if [ -f "webroot/composer.json" ]; then
        composer install --working-dir=webroot --no-dev --optimize-autoloader
    else
        composer install --no-dev --optimize-autoloader
    fi
fi

# --- FASE 4: ARRANQUE DEL SERVIDOR ---
echo "🚀 Iniciando servidor..."

# Reemplazo de variables estilo {{VAR}} que usa el panel por las variables de entorno reales $VAR
# Esto es necesario para que el comando de inicio funcione bien
MODIFIED_STARTUP=`eval echo $(echo ${STARTUP} | sed -e 's/{{/${/g' -e 's/}}/}/g')`

echo ":/home/container$ ${MODIFIED_STARTUP}"

# Ejecutar el comando final
exec ${MODIFIED_STARTUP}