# Subscription Status Synchronization Service

The Subscription Status Synchronization Service is a Laravel-based application that synchronizes users' subscription statuses for various apps on different platforms. It checks the subscription status for each user's app on app markets (iOS and Android) and keeps the status updated based on the results obtained from the app markets.

## Objective

The primary objective of this project is to implement a subscription status synchronization service that ensures users' subscription statuses are always up-to-date. The service performs regular checks for active, expired, or pending subscriptions on the app markets' APIs, and accordingly updates the database with the latest status.

## Business Logic

- There are multiple apps, each belonging to a specific platform (iOS, Android).
- Supported platforms are: iOS and Android.
- Each platform has a dedicated HTTP service to check subscription status.
- Each app is uniquely identified by its ID and has a name.
- Subscription status can be one of the following: active, expired, or pending.
- For Google Play subscriptions, if a non-200 status code is returned, the service retries the check after 1 hour to get the result.
- For Apple Store subscriptions, if a non-200 status code is returned, the service retries the check after 2 hours to get the result.
- Any change in subscription status from 'active' to 'expired' is reported to the admin via email.
- The subscription status checking process runs every weekend.
- An API is available for the admin to retrieve the latest record of expired subscriptions (no authentication required).

## Features

- Migration, factories, and seeders are provided for the `apps`, `subscriptions`, and `platforms` tables.
- Relationships are established based on the business logic.
- Mock subscription services are implemented for both iOS and Android platforms.
- Comprehensive unit tests are written to ensure the reliability of the subscription status checks.
- Appropriate design patterns are used to ensure extensibility for adding new markets in the future.
- SOLID principles are followed to enhance the maintainability and flexibility of the codebase.

## Installation

Follow these steps to get the project up and running:

1. Clone the repository:
```bash
git clone https://hrgit.abrha.net/younes/subscription-sync-parspack.git
````

2. Install composer requirements:
```bash 
composer install
```
3. Create a .env file by copying the .env.example:
```bash
cp .env.example .env
```

4. Then create the new app key using this command:
```bash
php artisan key:generate
```
5. Setup database in .env file:
```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

```
6. After that run migration and seeders:

```bash
php artisan migrate --seed
```
7. Start it using:
```bash
php artisan serve
```
Then you can use api/expired-subscriptions to get all expired subs or just use platform parameter in your GET request to specify between android and ios.

Or use this command on your server to run the service to check subs status on weekends:
```bash
* * * * * cd /path-to-the-project && php artisan schedule:run >> /dev/null 2>&1
```
OR to run it instantly use the below command:
```bash
php artisan subscription:check
```