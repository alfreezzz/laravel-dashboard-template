# Laravel Dashboard Template

This repository is a Laravel-based dashboard template designed to help you quickly start building modern admin panels and data-driven applications. It combines Laravel, Livewire, Tailwind CSS, and Vite to provide a clean and productive foundation for your next project.

## Features

- Modern dashboard layout with separate admin and user-oriented views
- Authentication-ready structure for user management
- Example modules for categories, items, transactions, and notifications
- Livewire components for interactive UI behavior
- Tailwind CSS and Vite for a fast frontend workflow
- Real-time notification support with Laravel Echo and Pusher

## Tech Stack

- PHP 8.3+
- Laravel 12
- Livewire 4
- Tailwind CSS 4
- Vite
- Pest for testing

## Getting Started

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy the environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run database migrations:
   ```bash
   php artisan migrate
   ```
5. Install frontend dependencies and build assets:
   ```bash
   npm install
   npm run build
   ```
6. Start the development environment:
   ```bash
   composer run dev
   ```

## Project Structure

- app/Models: application models such as users, categories, items, transactions, and notifications
- app/Http: controllers and middleware
- resources/views: Blade templates and UI components
- routes: web routes and application endpoints
- database: migrations, factories, and seeders

## License

This project is open-source and licensed under the MIT license.
