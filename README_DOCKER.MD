# Docker Configuration for Laravel Project

This comprehensive guide outlines the steps to configure and use Docker for a Makita ERP Project. It includes Dockerfile, docker-compose configuration, and essential commands to ensure seamless setup and management.

---

## **Setup Instructions**

### Step 1: Install WSL 2 on Windows

- Open PowerShell as Administrator and execute:
  ```powershell
  wsl --install
  ```
- Restart your system if required.
- Set WSL version to 2:
  ```powershell
  wsl --set-default-version 2
  ```

### Step 2: Install Docker Desktop

- Download and install Docker Desktop from [Docker’s official website](https://www.docker.com/products/docker-desktop/).
- During installation, enable the WSL 2 integration.

### Step 3: Enable WSL Integration in Docker

- Open Docker Desktop settings.
- Navigate to **Settings > Resources > WSL Integration**.
- Enable integration for your preferred Linux distribution.

### Step 4: Verify Docker Installation

- Open a terminal and check the Docker version:
  ```bash
  docker --version
  ```
- Ensure Docker is running:
  ```bash
  docker info
  ```

### Step 5: Clone the Repository

```bash
git clone https://github.com/MakitaB2B/MakitaB2B.git
cd MakitaB2B
```

### Step 6: Create the Dockerfile

Add the following `Dockerfile` to the root directory of the project:

```dockerfile
# Base image
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    curl \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo_mysql bcmath mbstring curl xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer and install dependencies
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
COPY . /var/www

# Set permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

### Step 7: Create the Docker-Compose File

Add the following `docker-compose.yml` to the root directory:

```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: makita_erp_app
    volumes:
      - .:/var/www
    networks:
      - makita_net
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=${DB_DATABASE}
      - DB_USERNAME=${DB_USERNAME}
      - DB_PASSWORD=${DB_PASSWORD}
    ports:
      - "9000:9000"

  nginx:
    image: nginx:latest
    container_name: makita_erp_nginx
    ports:
      - "80:80"
    volumes:
      - .:/var/www
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - makita_net

  db:
    image: mysql:8.0
    container_name: makita_erp_db
    environment:
      MYSQL_ROOT_PASSWORD: password_of_your_choice
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    networks:
      - makita_net
    ports:
      - "3306:3306"

networks:
  makita_net:
    driver: bridge

volumes:
  db_data:
    driver: local
```

### Step 8: Configure Nginx

Create a directory named `nginx` and inside it, add a file `default.conf` with the following content:

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### Step 9: Build and Start the Containers

```bash
docker-compose up -d --build
```

### Step 10: Access the PHP Container

```bash
docker-compose exec -it app bash
```

### Step 11: Install Laravel Dependencies

```bash
composer install
php artisan key:generate
```

### Step 12: Restore the Database

- Copy the database backup:
  ```bash
  docker cp makita_erp_db:/tmp/database_backup.sql ./database_backup.sql
  ```
- Access the MySQL container:
  ```bash
  docker exec -it makita_erp_db mysql -u root -p
  ```
- Restore the database:
  ```sql
  USE <database_backup.sql>;
  SOURCE </tmp/database_backup.sql>;
  ```

---

## **Useful Docker Commands**

### Container Management

- Start containers:
  ```bash
  docker-compose up -d
  ```
- Stop containers:
  ```bash
  docker-compose down
  ```
- Rebuild containers:
  ```bash
  docker-compose up -d --build
  ```
- Prune unused resources:
  ```bash
  docker system prune -f
  ```
- Prune everything (volumes, networks, and images):
  ```bash
  docker system prune -a -f
  ```

### Logs and Debugging

- View logs:
  ```bash
  docker-compose logs
  ```
- Execute commands in PHP container:
  ```bash
  docker-compose exec app php artisan <command>
  ```
- Stop and remove all running containers:
  ```bash
  docker stop $(docker ps -q) && docker rm $(docker ps -aq)
  ```
- Remove all images:
  ```bash
  docker rmi $(docker images -q) -f
  ```

---

This guide provides a structured and detailed setup for running a Laravel application with PHP, MySQL, and Nginx using Docker. Follow the steps to configure, build, and manage the environment efficiently.

