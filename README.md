# Phonebook Application - README

This document provides instructions on setting up, running, and testing the Phonebook application using SQLite.

## Prerequisites

Before you begin, ensure you have the following installed:

* **PHP:** Version 8.1 or higher.
* **Composer:** Dependency manager for PHP.
* **Node.js and npm:** For frontend dependencies.
* **SQLite:** For database storage.
* **Git:** (Optional, but recommended)

## Setup Instructions

1.  **Clone the Repository (if applicable):**

    ```bash
    git clone https://github.com/BaldracchiJonas/Contact-FullStack-Jonas-Baldracchi
    cd Contact-FullStack-Jonas-Baldracchi
    ```

2.  **Install PHP Dependencies:**

    ```bash
    composer install
    ```

3.  **Install Node.js Dependencies:**

    ```bash
    npm install
    ```

4.  **Copy `.env.example` to `.env`:**

    ```bash
    cp .env.example .env
    ```

5.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6.  **Database Configuration (SQLite):**

    * Create an empty `database.sqlite` file within the `database` directory:

        ```bash
        touch database/database.sqlite
        ```

7.  **Run Database Migrations:**

    ```bash
    php artisan migrate
    ```

8.  **Compile Assets:**

    ```bash
    npm run dev # or npm run build for production
    ```

## Running Locally

1.  **Start the Laravel Development Server:**

    ```bash
    php artisan serve
    ```

    * The application will be available at `http://127.0.0.1:8000`.

## Testing Endpoints

1.  **Using `php artisan test`:**

    * Run all tests:

        ```bash
        php artisan test
        ```

    * Run specific test file:

        ```bash
        php artisan test --filter ContactControllerTest
        ```

    * Run specific test method:

        ```bash
        php artisan test --filter test_can_create_a_contact
        ```

2.  **Using Postman/Insomnia/curl:**

    * **Get all contacts:** `GET http://127.0.0.1:8000/api/contacts`
    * **Create a contact:** `POST http://127.0.0.1:8000/api/contacts` with JSON body:

        ```json
        {
            "name": "John Doe",
            "phone": "123-456-7890"
        }
        ```

    * **Delete a contact:** `DELETE http://127.0.0.1:8000/api/contacts/{contact_id}` (replace `{contact_id}` with the actual ID).

## Database Creation (SQLite)

* SQLite databases are file-based, so creating the `database/database.sqlite` file as shown in the setup instructions is sufficient. No additional database creation steps are required.

## Additional Notes

* Ensure your web server (Apache or Nginx) is configured correctly to point to the `public` directory of your Laravel application.
* For production environments, use `npm run build` and configure your web server accordingly.
* Always keep your dependencies updated: `composer update` and `npm update`.
* If you encounter any issues, check the Laravel logs (`storage/logs/laravel.log`) for error messages.
