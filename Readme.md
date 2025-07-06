# Setup Instructions

## Prerequisites
- PHP 8.1 or higher
- Composer
- Redis server
- Database (MySQL/PostgreSQL)
- Postman (for API testing)

## Installation Steps

### 1. Install Dependencies
```bash
composer install
```

### 2. Environment Configuration
Configure your database settings in the `.env` file and ensure the cache store is set to Redis:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_STORE=redis

# For queue, you can use either redis or database as the driver
QUEUE_CONNECTION=redis
# OR
# QUEUE_CONNECTION=database
```

### 3. Database Setup
Run the migrations and seed the database:
```bash
php artisan migrate --seed
```

### 4. Start the Application
Launch the Laravel development server:
```bash
php artisan serve
```

### 5. Queue Worker
Start the queue worker to listen for queued jobs:
```bash
php artisan queue:work
```

## API Testing

### 6. Postman Setup
1. Import the Postman collection JSON file located in the `postman-collection` directory into your Postman application
2. Read the documentation within the collection if necessary

### 7. Authentication
Before accessing the `stock-movement` endpoint:
1. Get an access token from the `login` endpoint
2. Use the received token as a Bearer token in the Authorization header in Postman

**Example:**
```
Authorization: Bearer your_access_token_here
```

## Notes
- Make sure Redis is running before starting the application
- Keep the queue worker running in a separate terminal to process background jobs