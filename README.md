## Requirements
- Docker
- Node 20
- npm

## Setup
```
docker-compose up
```

Create .env file by copying .env.example

```
docker exec -it laravel_app bash
composer i
php artisan migrate
php artisan db:seed
```

```
node -v
npm i
npm run dev 
```