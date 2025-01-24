# Installation Guide

### Prerequisites
- Docker
- Docker Compose

### Setup Steps

1. **Install Dependencies**
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

2. **Start Docker Containers**
```bash
./vendor/bin/sail up -d
```

3. **Setup Database**
```bash
./vendor/bin/sail artisan migrate --seed
```

Your application should now be ready to use!
