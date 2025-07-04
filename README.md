# Xeddo - Ride Sharing Application

A modern ride-sharing application built with Laravel, featuring separate dashboards for passengers, drivers, and administrators.

## Features

### 🚗 **Multi-Role System**
- **Passengers**: Book rides, manage profiles, view trip history
- **Drivers**: Manage availability, vehicle information, view earnings
- **Administrators**: Manage users, approve drivers, system oversight

### 🎨 **Modern UI**
- Responsive design with Tailwind CSS
- Navy blue themed dashboard cards
- Mobile-friendly navigation
- Clean and professional interface

### 🔐 **Authentication & Security**
- Role-based access control
- Secure user registration and login
- Profile management
- Driver verification system

### 📱 **Dashboard Features**
- **Passenger Dashboard**: Trip statistics, booking interface, profile management
- **Driver Dashboard**: Trip stats, availability toggle, vehicle information
- **Admin Dashboard**: User management, driver approvals, system statistics

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: SQLite (configurable)
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite
- **Testing**: PHPUnit

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- Git

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/xeddo-ride-sharing.git
   cd xeddo-ride-sharing
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Admin Account

After running the seeders, you can log in with:
- **Email**: admin@xeddo.com
- **Password**: password

## Project Structure

```
xeddo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin-specific controllers
│   │   │   ├── Auth/            # Authentication controllers
│   │   │   ├── Driver/          # Driver dashboard controllers
│   │   │   └── Passenger/       # Passenger dashboard controllers
│   │   └── Middleware/
│   └── Models/
├── resources/
│   └── views/
│       ├── admin/               # Admin dashboard views
│       ├── auth/                # Authentication views
│       ├── driver/              # Driver dashboard views
│       └── passenger/           # Passenger dashboard views
└── routes/
    └── web.php                  # Application routes
```

## Development

### Running Tests
```bash
php artisan test
```

### Building for Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Screenshots

### Passenger Dashboard
- Book rides with pickup and destination
- View trip statistics and ratings
- Manage emergency contacts and preferences

### Driver Dashboard
- Toggle availability status
- View vehicle information
- Track earnings and trip statistics

### Admin Dashboard
- Manage all users and drivers
- Approve driver applications
- View system-wide statistics

## Support

If you encounter any issues or have questions, please create an issue in the GitHub repository.
