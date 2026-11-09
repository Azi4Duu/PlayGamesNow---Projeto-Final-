# Play Games Now — Web Application

## Description

Play Games Now is a digital game key store developed with Laravel.

The project includes a complete Web application, a REST API used by the Android application and a MySQL database shared between both clients.

Users can create an account, browse games, filter the catalogue, manage a shopping cart, apply discount coupons, complete purchases and receive the purchased game keys.

After a successful purchase, the backend automatically generates a purchase receipt in PDF format and sends it to the customer's email.

The application also includes an administrative area for managing users, games, platforms, publishers, categories, coupons, game keys and sales.

---

## Main Features

### Authentication

The application includes:

- User registration and login;
- Email verification;
- Password recovery and reset;
- Two-factor authentication using a temporary code sent by email;
- Google authentication using OAuth 2.0 and Laravel Socialite;
- Customer and Admin roles;
- Access control using Spatie Laravel Permission.

Passwords are stored using Laravel's hashing mechanisms and sensitive credentials are configured through environment variables.

---

### Game Catalogue

The store catalogue allows users to browse available games and filter them by different criteria.

Available features include:

- Search by game title;
- Filter by platform;
- Filter by category;
- Filter by stock availability;
- Price ordering;
- Pagination;
- Individual game detail pages;
- Related games.

A commercial product is represented by a `GamePlatform`, which associates a game with a specific platform and stores information such as price and availability.

---

### Shopping Cart

Authenticated customers can add products to their shopping cart and change or remove quantities.

Stock availability is based on the number of `GameKey` records with status `available`.

The backend validates stock whenever products are added or updated, preventing the requested quantity from exceeding the available keys.

---

### Coupons

Discount coupons can be created and managed through the Admin area.

Coupons can use:

- Percentage discounts;
- Fixed-value discounts;
- Start and expiration dates;
- Usage limits;
- Active or inactive status.

Customers can apply a coupon code in the shopping cart.

The backend validates the coupon before applying it and calculates the resulting:

- Subtotal;
- Discount;
- Final total.

The coupon is validated again during checkout before the sale is created.

---

### Checkout and Sales

The checkout supports simulated payment methods:

- Card;
- PayPal;
- MB Way.

No real payment provider is currently integrated.

After the checkout is successfully completed, the application creates a `Sale` and the corresponding `SaleItem` records.

Available game keys are then assigned to the purchased items using `SaleKey`, and the corresponding `GameKey` records are marked as sold.

The cart is subsequently marked as converted.

If a coupon was used, the sale also stores the applied coupon and the final discount.

---

### Purchase Receipt PDF

After a purchase is completed, the backend automatically generates a purchase receipt using Dompdf.

The PDF includes information such as:

- Order number;
- Customer;
- Purchase date;
- Payment method;
- Purchased games;
- Platforms;
- Quantities;
- Unit prices;
- Game keys;
- Subtotal;
- Applied coupon;
- Discount;
- Final total.

The PDF is attached to an email and automatically sent to the customer.

The same process is used for purchases made through the Web application and through the Android application.

---

### Purchase History

Customers can access their purchase history and view detailed information about each order.

Purchase details include:

- Purchased games;
- Platforms;
- Quantities;
- Unit prices;
- Game keys;
- Coupon used;
- Discount;
- Total paid.

---

### User Profile

Customers can update their:

- Name;
- Username;
- Email;
- Password.

Changing the password requires confirmation of the current password.

---

## Admin Area

Administrators have access to a dedicated management interface.

The Admin area includes management of:

- Users;
- Games;
- Platforms;
- Publishers;
- Categories;
- Coupons;
- Game keys;
- Sales.

Several entities support Soft Deletes, allowing deleted records to be restored.

Administrative lists also include search, filters and pagination.

The dashboard provides general information such as users, games, sales, revenue and recent purchases.

---

## REST API

The Laravel project includes a REST API used by the Android application.

The API provides endpoints for:

- Authentication;
- User profile;
- Game catalogue;
- Game details;
- Shopping cart;
- Coupons;
- Checkout;
- Sales;
- Purchase history.

Laravel API Resources are used to structure JSON responses.

Protected endpoints use Laravel Sanctum authentication.

---

## Technologies

### Backend

- PHP
- Laravel
- Eloquent ORM
- Laravel Migrations
- Laravel Sanctum
- Laravel Socialite
- Spatie Laravel Permission
- Dompdf

### Database

- MySQL

### Frontend

- Blade
- HTML
- CSS / Sass
- Bootstrap
- JavaScript
- Vite
- npm

### External Services

- Google OAuth 2.0
- Gmail SMTP

### Development Tools

- Composer
- Git
- Bruno

---

## Requirements

Before running the project, make sure the following software is installed:

- PHP;
- Composer;
- MySQL;
- Node.js;
- npm.

---

## Installation

Clone or copy the project and open the project directory.

Install the PHP dependencies:

```bash
composer install
```

Install the frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

On Windows, the `.env.example` file can also be copied manually and renamed to `.env`.

Generate the Laravel application key:

```bash
php artisan key:generate
```

---

## Database Configuration

Configure the MySQL connection in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=play_games_now
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Create the database and run:

```bash
php artisan migrate
```

If the project includes seeders:

```bash
php artisan db:seed
```

---

## Storage

Create the symbolic link required for publicly accessible uploaded files:

```bash
php artisan storage:link
```

Uploaded game images and platform icons are stored using Laravel's public storage disk.

---

## Email Configuration

The application uses Gmail SMTP for transactional emails.

Configure the required values in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Play Games Now"
```

A Gmail App Password should be used instead of the normal account password.

The application uses email for:

- Email verification;
- Password reset;
- Two-factor authentication;
- Purchase receipts.

Never commit real email credentials or App Passwords to Git.

---

## Google OAuth Configuration

Google authentication requires an OAuth Client configured in Google Cloud.

Add the corresponding credentials to `.env`:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

The redirect URI must exactly match the Authorized Redirect URI configured in Google Cloud.

Never commit the real Client Secret to Git.

---

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

Start the frontend development server:

```bash
npm run dev
```

By default, the Web application can then be accessed at:

```text
http://127.0.0.1:8000
```

If the Android emulator also needs to access the Laravel API, the Laravel server can be started with:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## API Authentication

The Android application authenticates through Laravel Sanctum.

After a successful API login, the backend returns an authentication token.

The Android application sends this token with protected requests using the Bearer authentication scheme.

Logging out removes the current token.

---

## Project Architecture

The Web application follows Laravel's MVC architecture:

```text
Browser
   ↓
Routes
   ↓
Controllers
   ↓
Models / Eloquent
   ↓
MySQL
```

The Android application communicates through the REST API:

```text
Android Application
   ↓
Retrofit
   ↓
Laravel REST API
   ↓
Models / Eloquent
   ↓
MySQL
```

Business logic such as stock validation, coupon validation, sale creation, game key assignment, PDF generation and email delivery remains centralized in the Laravel backend.

---

## Limitations

The current project uses simulated payment methods and does not integrate with a real payment provider.

The `payment_reference` field is prepared for a future external transaction identifier but currently remains empty.

Possible future improvements include database transactions during checkout, additional reporting, reviews and integration with a real payment provider.

---

## Security Notes

The following information must never be committed to a public repository:

- Database passwords;
- Gmail App Passwords;
- Google OAuth Client Secret;
- Production API tokens;
- Other private credentials.

Use `.env` for sensitive configuration and keep the real environment file outside version control.

---

## Author

Developed as the final project of the Técnico Especialista em Tecnologias e Programação de Sistemas de Informação course.

**Author:** João Francisco Lopes Marques Correia Mateus  
**Class:** TPSI-CAS-0226  
**Year:** 2026
