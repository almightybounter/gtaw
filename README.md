# GTAW - Laravel Notes Application

A clean and secure notes management application built with Laravel. GTAW allows users to create, organize, and manage their personal notes with a simple and intuitive interface.

## Features

- **User Authentication**: Secure registration and login system
- **Notes Management**: Create, read, update, and delete personal notes
- **Clean Interface**: Simple and user-friendly design
- **Security First**: Built with security best practices in mind
- **Responsive Design**: Works on desktop and mobile devices

## Technology Stack

- **Framework**: Laravel 10.x
- **Database**: MySQL (Laravel Cloud)
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel Breeze
- **Testing**: Pest PHP testing framework

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/almightybounter/gtaw.git
   cd gtaw
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run database migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

The application will be available at `http://127.0.0.1:8000`

## Usage

1. **Register** a new account or **login** with existing credentials
2. **Create notes** using the simple form interface
3. **View and manage** your notes from the dashboard
4. **Edit or delete** notes as needed

## Testing

Run the test suite to ensure everything is working correctly:

```bash
php artisan test
```

## Security

This application includes comprehensive security measures:
- CSRF protection
- Input validation and sanitization
- Authentication middleware
- Secure password handling
- SQL injection prevention

## Contributing

Feel free to fork this repository and submit pull requests for any improvements.

## License

This project is open-sourced software licensed under the MIT License.
