# Worker System

A comprehensive API-based worker management system, akin to a freelance platform, catering to workers, clients, and administrators.

## Project Demo
You can view a demo of the project [here](https://drive.google.com/drive/folders/1Mn7lg70XmoIOGZOLgtLWL3zc6-UyhgBr?usp=sharing).

## Features

1. **Multi-Authentication and Multi-Guard**: 
   - Robust authentication system supporting different user roles and permissions.

2. **Post Management**: 
   - Workers can create posts.
   - Clients can place orders, provide reviews, and rate workers.

3. **Administrative Approval**: 
   - Admins can approve posts and manage payments.
   - System earns a percentage from each transaction.

4. **Data Import and Export**: 
   - Seamless import and export of worker posts for data portability and management.

5. **Filtering Capabilities**: 
   - Advanced filtering options for easy navigation and access to specific posts.

6. **Notifications**: 
   - Notification system to inform users about new posts and post approvals.

7. **SOLID Principles and Design Patterns**: 
   - Adherence to SOLID principles.
   - Implementation of design patterns such as Service and Repository for maintainable and scalable code.

8. **API Resources**: 
   - Expose data and functionality for external applications or services via API resources.

9. **Email Verification**: 
   - Incorporation of an email verification process to ensure user account legitimacy.

10. **Post Rating**: 
    - Users can rate and review posts, enhancing transparency and trust within the system.

11. **Payment Gateway Integration**: 
    - Integration of a secure payment gateway for hassle-free financial transactions.

## Prerequisites

- PHP 7.4 or higher
- MySQL
- Composer
- Mail server configuration for email verifications

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Abdo-hasen/worker-system.git
cd worker-system
```

2. Install dependencies:

```bash
composer install
```

3. Configure environment variables:

Create a `.env` file in the project root and add the following configurations:

```
APP_NAME=WorkerSystem
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=worker_system
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

4. Run database migrations:

```bash
php artisan migrate
```

5. Seed the database with initial data (optional):

```bash
php artisan db:seed
```

## Running the Application

1. Start the local development server:

```bash
php artisan serve
```

2. Open your web browser and navigate to:

```
http://localhost:8000
```

## Usage Guide

### Multi-Authentication

- Different user roles include Workers, Clients, and Administrators.
- Ensure proper role assignment during user registration.

### Post Management

- Workers create posts about their services.
- Clients can browse posts, place orders, and provide feedback.

### Administrative Controls

- Admins approve posts and oversee all transactions within the system.
- Admins can also manage user accounts and system settings.

## Project Structure

```
worker-system/
├── app/                # Core application code
│   ├── Http/           # Controllers, Middleware, and Requests
│   ├── Models/         # Eloquent Models
│   ├── Services/       # Business logic services
│   └── Repositories/   # Data access repositories
├── config/             # Configuration files
├── database/           # Migrations, Factories, and Seeders
├── public/             # Public assets
├── resources/          # Views and language files
├── routes/             # Route definitions
├── tests/              # Automated tests
├── .env                # Environment configuration
└── composer.json       # Composer dependencies
```


## Security Considerations

- Store sensitive credentials in `.env`.
- Never commit `.env` file to version control.
- Use HTTPS in production.
- Implement proper input validation.
- Add rate limiting for API endpoints.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.



