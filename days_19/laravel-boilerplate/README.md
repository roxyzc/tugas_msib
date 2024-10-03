1. Copy `.env.example` to `.env` and modify according to your environment
    ```
    cp .env.example .env
    ```
2. Settings your Database in .env
   | Kunci | value |
   |-------------------|---------------------|
   | `DB_HOST` | localhost |
   | `DB_PORT` | 3306 |
   | `DB_DATABASE` | Your Database Name |
   | `DB_USERNAME` | Your Username |  
   | `DB_PASSWORD` | Your Password |

3. Install composer dependencies
    ```
    composer install --prefer-dist
    ```
4. An application key can be generated with the command
    ```
    php artisan key:generate
    ```
5. Execute following commands to install other dependencies
    ```
    npm install
    ```
    ```
    npm run dev
    ```
6. Run these commands to create the tables within the defined database and populate seed data

    ```
    php artisan migrate --seed
    ```

7. php artisan serve --port=8080 or php artisan serve
