#!/bin/bash

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${BLUE}=====================================${NC}"
echo -e "${BLUE}  Instalación de UDONE Foro  ${NC}"
echo -e "${BLUE}=====================================${NC}\n"

# Verificar PHP
echo -e "${YELLOW}Verificando PHP...${NC}"
if ! command -v php &> /dev/null; then
    echo -e "${RED}Error: PHP no está instalado${NC}"
    exit 1
fi
echo -e "${GREEN}✓ PHP encontrado: $(php -v | head -n 1)${NC}\n"

# Verificar Composer
echo -e "${YELLOW}Verificando Composer...${NC}"
if ! command -v composer &> /dev/null; then
    echo -e "${RED}Error: Composer no está instalado${NC}"
    echo -e "${YELLOW}Descarga Composer desde: https://getcomposer.org/${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Composer encontrado: $(composer --version | head -n 1)${NC}\n"

# Instalar dependencias
echo -e "${YELLOW}Instalando dependencias de Composer...${NC}"
composer install --no-interaction --prefer-dist --optimize-autoloader || {
    echo -e "${RED}Error al instalar dependencias${NC}"
    exit 1
}
echo -e "${GREEN}✓ Dependencias instaladas${NC}\n"

# Configurar archivo .env
if [ ! -f .env ]; then
    echo -e "${YELLOW}Creando archivo .env...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ Archivo .env creado${NC}\n"
else
    echo -e "${GREEN}✓ Archivo .env ya existe${NC}\n"
fi

# Generar clave de aplicación
echo -e "${YELLOW}Generando clave de aplicación...${NC}"
php artisan key:generate --ansi
echo -e "${GREEN}✓ Clave generada${NC}\n"

# Configurar permisos
echo -e "${YELLOW}Configurando permisos...${NC}"
chmod -R 755 storage bootstrap/cache
echo -e "${GREEN}✓ Permisos configurados${NC}\n"

# Crear enlace simbólico de storage
echo -e "${YELLOW}Creando enlace simbólico de storage...${NC}"
php artisan storage:link || echo -e "${YELLOW}⚠ El enlace ya existe o no se pudo crear${NC}\n"

# Instrucciones para base de datos
echo -e "\n${BLUE}=====================================${NC}"
echo -e "${BLUE}  Configuración de Base de Datos  ${NC}"
echo -e "${BLUE}=====================================${NC}\n"

echo -e "${YELLOW}Por favor, configura tu base de datos:${NC}"
echo -e "1. Edita el archivo ${GREEN}.env${NC}"
echo -e "2. Configura las siguientes variables:\n"
echo -e "   ${GREEN}DB_CONNECTION${NC}=mysql"
echo -e "   ${GREEN}DB_HOST${NC}=127.0.0.1"
echo -e "   ${GREEN}DB_PORT${NC}=3306"
echo -e "   ${GREEN}DB_DATABASE${NC}=udone_foro"
echo -e "   ${GREEN}DB_USERNAME${NC}=tu_usuario"
echo -e "   ${GREEN}DB_PASSWORD${NC}=tu_contraseña\n"

echo -e "${YELLOW}3. Crea la base de datos:${NC}"
echo -e "   ${GREEN}mysql -u root -p${NC}"
echo -e "   ${GREEN}CREATE DATABASE udone_foro;${NC}"
echo -e "   ${GREEN}EXIT;${NC}\n"

read -p "¿Has configurado la base de datos? (s/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    echo -e "\n${YELLOW}Ejecutando migraciones...${NC}"
    php artisan migrate --force || {
        echo -e "${RED}Error al ejecutar migraciones${NC}"
        echo -e "${YELLOW}Verifica tu configuración de base de datos${NC}"
        exit 1
    }
    echo -e "${GREEN}✓ Migraciones completadas${NC}\n"
    
    read -p "¿Deseas poblar la base de datos con datos de ejemplo? (s/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Ss]$ ]]; then
        echo -e "\n${YELLOW}Ejecutando seeders...${NC}"
        php artisan db:seed --force
        echo -e "${GREEN}✓ Datos de ejemplo creados${NC}\n"
        
        echo -e "${BLUE}=====================================${NC}"
        echo -e "${GREEN}  Usuarios de Prueba  ${NC}"
        echo -e "${BLUE}=====================================${NC}\n"
        echo -e "Administrador:"
        echo -e "  Email: ${GREEN}admin@udone.edu.ve${NC}"
        echo -e "  Password: ${GREEN}password${NC}\n"
        echo -e "Moderador:"
        echo -e "  Email: ${GREEN}moderador@udone.edu.ve${NC}"
        echo -e "  Password: ${GREEN}password${NC}\n"
        echo -e "Usuario:"
        echo -e "  Email: ${GREEN}maria@udone.edu.ve${NC}"
        echo -e "  Password: ${GREEN}password${NC}\n"
    fi
fi

echo -e "\n${BLUE}=====================================${NC}"
echo -e "${GREEN}  ¡Instalación Completada!  ${NC}"
echo -e "${BLUE}=====================================${NC}\n"

echo -e "${YELLOW}Para iniciar el servidor de desarrollo:${NC}"
echo -e "  ${GREEN}php artisan serve${NC}\n"

echo -e "${YELLOW}Luego visita:${NC}"
echo -e "  ${GREEN}http://localhost:8000${NC}\n"

echo -e "${BLUE}¡Disfruta del Foro UDONE!${NC}\n"
