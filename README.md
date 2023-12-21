# Fullstack Laravel + Vue + Inertia template

## Overview

This project is a web application built with a modern stack that combines the power of Laravel, Vue.js, and Inertia.js. This stack provides a seamless and efficient development experience, allowing for the creation of dynamic and responsive single-page applications (SPAs).

## Prerequisites

Before you begin, make sure you have the following prerequisites installed on your development machine:

### Backend Requirements

1. **PHP >= 8.1:** Ensure that you have PHP >= 8.1 installed on your system. You can download it from [php.net](https://www.php.net/).

2. **Composer:** Composer is a dependency manager for PHP. Install it by following the instructions at [getcomposer.org](https://getcomposer.org/).

## Frontend Requirements

1. **Node.js and NPM:** Node.js is required for running JavaScript on the server side, and NPM is used for managing JavaScript packages. Download and install Node.js from [nodejs.org](https://nodejs.org/), and NPM will be included.



## Getting Started

Follow these steps to set up and run the project locally:

1. **Clone the repository**
   ```bash
   git clone https://github.com/ardmgtm/fullstack-laravel.git project-name
   cd project-name
   rm -rf .git
   ```

2. **Install Dependencies**
   ```bash
   npm install
   composer install
    ```

3. **Configure Environment Variables**

   ```bash
   cp .env.example .env
   ```
   configure your database connection in .env
   ```javascript
   DB_CONNECTION=<your-db-connection>
   DB_HOST=<your-db-host>
   DB_PORT=<your-db-port>
   DB_DATABASE=<your-db-name>
   DB_USERNAME=<your-db-connection-username>
   DB_PASSWORD=<your-db-connection-password>
   ```
4. **Start development server**

   Start Laravel development Server
   ```bash
   php artisan serve
   ```
   Compile js assets and watch change
   ```bash
   npm run dev
   ```

## Contributing

We welcome contributions from the community! If you would like to contribute to this project, please follow these guidelines:

### Issues

Before submitting a new issue, please check the existing issues to ensure that the topic has not already been reported or discussed. If you find your issue, feel free to add any additional information or context.

If you're reporting a bug, please provide:

- A clear and descriptive title.
- A detailed description of the issue, including steps to reproduce.
- Information about your environment (e.g., operating system, browser, version).

### Pull Requests

We encourage you to contribute to the project by submitting pull requests. Follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix: `git checkout -b feature-name`.
3. Make your changes and commit them: `git commit -m 'Description of changes'`.
4. Push your changes to your fork: `git push origin feature-name`.
5. Submit a pull request to the main repository.

In your pull request:

- Provide a clear and descriptive title.
- Explain the purpose of the changes.
- Reference any related issues.

### Coding Standards

Please follow the coding standards and conventions used in the project. This includes code formatting, naming conventions, and other best practices.

Thank you for contributing to our project!