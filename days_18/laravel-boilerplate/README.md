1. Clone repository
    ```
    git clone https://github.com/roxyzc/tugas_msib/tree/master/days_18/laravel-boilerplat
    ```
2. Change into the working directory
    ```
    cd laravel-boilerplate
    ```
3. Copy `.env.example` to `.env` and modify according to your environment
    ```
    cp .env.example .env
    ```
4. Install composer dependencies
    ```
    composer install --prefer-dist
    ```
5. An application key can be generated with the command
    ```
    php artisan key:generate
    ```
6. Execute following commands to install other dependencies
    ```
    npm install
    ```
    ```
    npm run dev
    ```
7. Run these commands to create the tables within the defined database and populate seed data

    ```
    php artisan migrate --seed
    ```

8. Settings your Database in .env

9. php artisan serve --port=8080
