# Product Feedback Backend 

## Requirements
- PHP >= 8.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- JSON PHP Extension
- GD PHP Extension

##  Installation
1. Clone to your server root `gh repo clone the-dev-guy1/prod_feedback_backend`
2. Run composer install in terminal: `composer install --prefer-dist --no-scripts`. This will download all required dependencies for you.
3. Create `.env` in application root 
```cp .env.example .env```
4. Update database, smtp server, frontend_url details and optional sentry DNS in `.env`
5. Run `php artisan key:generate` to generate key
6. Run `php artisan migrate` to install the database
7. run `php artisan passport:client --personal`  then follow instructions on screen to create a password grant client
8. All right sparky! 


## Troubleshooting

**APP_KEY not getting added to .env**
- Add APP_KEY to .env
- Copy generated key from terminal
