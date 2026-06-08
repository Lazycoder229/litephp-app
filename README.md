# LitePHP

LitePHP is a lightweight, MVC-based PHP framework designed for simplicity, performance, and zero runtime dependencies.

---

## Introduction

LitePHP provides a clean and minimal foundation for building modern PHP applications. It follows a structured architecture that promotes separation of concerns, making development maintainable and scalable.

---

## System Requirements

- PHP 8.1 or higher  
- Composer  
- Web server (Apache, Nginx, or PHP built-in server)  
- MySQL or MariaDB (optional)  

---

## Installation

Create a new LitePHP project using Composer:

composer create-project litephp/app my-app  
cd my-app  

Initialize environment configuration:

cp .env.example .env  

Start the development server:

php -S localhost:3000  

---
## Directory Structure

---

app/
    Controllers/   - Handles HTTP requests and returns responses
    Helpers/       - Custom helper functions specific to the application
    Middleware/    - Request filters (authentication, security, etc.)
        Api/       - Middleware for API routes
        Global/    - Middleware applied to all requests
        Web/       - Middleware for web routes
    Models/        - Database models and ORM logic
    Routes/        - Application route definitions
    Services/      - Business logic and service classes
    views/         - Application templates (UI layer)
        layouts/    - Shared layout templates
        partials/   - Shared partial templates
        errors/    - Error pages (403, 404, 500)
        layout/    - Shared layout templates
    home.php       - Application entry point


Bootstrap/         - Application bootstrapping and initialization
config/            - Configuration files
storage/           - Logs, cache, sessions, and runtime data

autoload.php       - Registers application namespaces and autoloading
index.php          - Application entry point
lite               - CLI tool for framework commands
.env               - Environment configuration file
composer.json      - Project dependencies and metadata


---

## Configuration

All configuration is managed through the `.env` file.

- Environment variables control application behavior  
- Configuration files are stored in `config/`  
- Values are accessible globally throughout the application  

---

## Application Lifecycle

Every request follows this lifecycle:

1. Bootstrapping the framework  
2. Loading environment variables  
3. Loading configuration files  
4. Initializing the service container  
5. Processing middleware  
6. Resolving routes  
7. Executing controllers  
8. Returning a response  

---

## Routing

Routes define how your application responds to HTTP requests.

Features:

- HTTP method routing  
- Route parameters  
- Named routes  
- Middleware support  
- Route grouping  

All routes are defined in:

app/Routes/web.php  

---

## Controllers

Controllers handle incoming requests and return responses.

Responsibilities:

- Process request data  
- Validate input  
- Interact with models and services  
- Return views, JSON, or redirects  

---

## Models & Database

Models represent database tables and handle data operations.

Capabilities:

- ORM-based queries  
- Relationships  
- Transactions  
- Pagination  

---

## Authentication

LitePHP includes built-in authentication features:

- Session-based authentication  
- JWT-based authentication  
- User session handling  

Configuration file:

config/auth.php  

---

## Middleware

Middleware filters incoming HTTP requests.

### Groups

- global — runs on every request  
- web — for web routes  
- api — for API routes  

### Responsibilities

- Authentication  
- CSRF protection  
- Rate limiting  
- Logging  
- CORS handling  

---

## Console (CLI)

The `lite` CLI tool provides development utilities:

- Code generation  
- Database migrations  
- Seeding  
- Cache management  
- Queue processing  

---

## Views

Views are located in:

app/views/  

Features:

- Layouts and templates  
- Partial includes  
- Safe output rendering  
- Dynamic data binding  

---

## Helper Functions

Global helpers are available for:

- Paths and directories  
- Configuration access  
- Request and response handling  
- Sessions and authentication  
- Security utilities  
- String and date operations  
- Caching and logging  

---

## Error Handling

Custom error pages:

- 403 — Forbidden  
- 404 — Not Found  
- 500 — Server Error  

Location:

app/views/errors/  

---

## Deployment

Before deploying:

- Set APP_ENV=production  
- Set APP_DEBUG=false  
- Configure application keys  
- Set correct APP_URL  
- Restrict CORS origins  
- Cache routes  
- Ensure storage is writable  
- Secure `.env` file  
- Run migrations  

---

## License

This project is open-sourced software licensed under the MIT License.






nabago, jwt,secret sa comman sonolse
nabago din yun route cache