# Currency converter

### Usage

#### 1. Install composer dependencies
```bash
composer install
```
#### 2. Copy .env.example
```bash
cp .env.example .env
```

#### 3. Boot up the application
```bash
./vendor/bin/sail up
```
#### 4. Generate application key
```bash
./vendor/bin/sail php artisan key:generate
```
Access the application at `localhost`.
