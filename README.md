# Mini ATM Simulation

## Install

1. Copy the `.env.example` file to `.env` and set up your application.
2. Run the following command to install dependencies:

    ```bash
    composer install
    ```

3. Create tables:

    ```bash
    php artisan migrate
    ```

4. To run the application locally, use the following command:

    ```bash
    php artisan serve
    ```

5. Create default users (admin and user) and roles:

    ```bash
    php artisan db:seed
    ```

## Used Technologies

- **Laravel 12**
- **Filament  3.2**
- **MySQL**
