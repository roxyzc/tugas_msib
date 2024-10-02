1. Copy `.env.example` to `.env` and modify according to your environment
    ```
    cp .env.example .env
    ```
2. Install composer dependencies
    ```
    composer install --prefer-dist
    ```
3. An application key can be generated with the command
    ```
    php artisan key:generate
    ```
4. Execute following commands to install other dependencies
    ```
    npm install
    ```
    ```
    npm run dev
    ```
5. Run these commands to create the tables within the defined database and populate seed data

    ```
    php artisan migrate --seed
    ```

6. Settings your Database in .env

7. php artisan serve --port=8080
