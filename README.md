# Kanye App

## Setup

1. Clone the repository:
```
git clone https://github.com/your-repo/kanye-app.git
cd kanye-app
```

2. Copy the example environment file and set the required environment variables:
```
cp .env.example .env
```

3. Install dependencies using Sail:
```
./vendor/bin/sail composer install
```

4. Generate the application key:
```
./vendor/bin/sail artisan key:generate
```

## End points
```
POST /api/login: Authenticate a user and return a token
GET /api/quotes: Fetch 5 random quotes (cached for 60 minutes)
GET /api/quotes/refresh: Refresh and fetch the next 5 random quotes
```

## Authentication
Add the api-token header with your API token to authenticate.

## Testing
1. Run feature tests using Sail:
```
./vendor/bin/sail artisan test
```

## Creating a User with an API Token
To create a user with an API token for testing or usage run the following Artisan tinker commands:
```
./vendor/bin/sail artisan tinker
```

Inside tinker, create a user with an API token:
```
\App\Models\User::create([
'name' => 'Test User',
'email' => 'test@example.com',
'password' => bcrypt('password'),
'api_token' => 'your_secure_api_token',
]);
```

Replace your_secure_api_token with the token you want to use for authentication.

## Postman
There is a Postman collection here:
[Postman Collection for Kanye app](https://www.postman.com/shaunthornburgh/workspace/kanye)
