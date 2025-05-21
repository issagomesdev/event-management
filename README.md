<h1 align="center" style="font-weight: bold;">🛠️ Listinha Vip — Event Management System</h1>

![Preview do site](https://em.byissa.tech/images/preview.png)

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![JavaScript](https://img.shields.io/badge/Javascript-000?style=for-the-badge&logo=javascript) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#structure">Structure</a> •
  <a href="#routes">App Routes</a> •
  <a href="#models--relationships">Models & Relationships</a> •
  <a href="#started">Getting Started</a>
</p>

<h2 id="about">📌 About</h2>

<p>
Listinha Vip is an event management platform developed with Laravel, HTML, CSS, and JavaScript. It allows users to confirm attendance, invite guests, and check in at events through a friendly interface. The platform includes both a public area for attendees and a complete administrative panel for event managers.
</p>

<p>
Originally developed as a freelance project, Listinha Vip includes role-based access, guest control, check-in functionality, and attendee management tools.
</p>

[![project](https://img.shields.io/badge/📱Visit_this_project-000?style=for-the-badge&logo=project)](https://em.byissa.tech)

<h2 id="features">✨ Features</h2>

### Public Users

- View active events on homepage.
- View detailed information about each event.
- Confirm attendance (with automatic login/register).
- Add guests to the attendance list (if allowed by event).
- Receive WhatsApp redirection after confirmation.

### Admin Panel

- Dashboard with upcoming events and stats.
- Full permission and role management.
- Admin user management with filters and exports.
- Customer management (CRUD with exports).
- Event management (CRUD, filters, exports, check-in view).
- Export attendance lists.
- Public links for viewing and checking in attendance (without login).
- Visual check-in interface with search and filters.

<h2 id="structure">🔖 Structure </h2>

```txt
📂 app/
 ┣ 📂 Http/
 ┃ ┣ 📂 Controllers/
 ┃ ┃ ┣ SiteController.php        # Public event views and attendance
 ┃ ┃ ┗ 📂 Admin/
 ┃ ┃   ┣ EventController.php
 ┃ ┃   ┣ CustomerController.php
 ┃ ┃   ┗ Permissions/Roles/Users
 ┣ 📂 Models/
 ┃ ┣ Customer.php
 ┃ ┗ Event.php

📂 database/
 ┣ 📂 migrations/                 # DB structure for events, customers, guests, attendance
 ┗ 📂 seeders/

📂 public/
 ┣ 📂 css/, js/, images/
 ┗ 📂 storage/                    # Media and uploads

📂 resources/
 ┗ 📂 views/                      # Blade templates for admin and public pages

📂 routes/
 ┗ web.php                        # All app routes
```

<h2 id="routes">📍 Application Routes</h2>

### Public

| Method | Path                                           | Description                          |
|--------|------------------------------------------------|--------------------------------------|
| GET    | `/`                                            | Homepage                             |
| GET    | `/event-details/{id}/{name}`                   | Event details                        |
| GET    | `/event-details/{id}/{name}/list`              | Attendance list view (protected)     |
| GET    | `/event-details/{id}/{name}/checkin`           | Check-in view (protected)            |
| POST   | `/confirm-attendance/{eventID}`                | Confirm user presence                |
| POST   | `/save-guests/{eventID}`                       | Save guest list                      |
| POST   | `/add-guest/{eventID}/{customerID}`            | Add single guest                     |
| POST   | `/delete-guest/{guestID}`                      | Delete guest                         |
| POST   | `/redirect-whatsapp`                           | Redirect user to WhatsApp            |
| POST   | `/events-checkin/{id}/{eventID}/{action}/{type}` | Public check-in logic              |
| GET    | `/customer/login`                              | Customer login                       |
| GET    | `/customer/register`                           | Customer register                    |
| GET    | `/customer/logout`                             | Customer logout                      |
| POST   | `/verify-customer`                             | Verify user existence and redirect   |
| POST   | `/customers`                                   | Store customer                       |
| GET    | `/customers/searchWithPhone/{number}`          | Search customer by phone             |

### Admin (`/admin`)

| Method | Path                                | Description                          |
|--------|-------------------------------------|--------------------------------------|
| GET    | `/admin/`                           | Dashboard                            |
| GET    | `/admin/events/{id}/checkin`        | Check-in view for event              |
| POST   | `/admin/events-checkin/{id}/{eventID}/{action}/{type}` | Update check-in status   |
| CRUD   | `/admin/events`                     | Manage events                        |
| CRUD   | `/admin/customers`                  | Manage clients                       |
| CRUD   | `/admin/users`                      | Manage admin users                   |
| CRUD   | `/admin/roles`                      | Manage roles                         |
| CRUD   | `/admin/permissions`                | Manage permissions                   |
| CRUD   | `/admin/configs`                    | General configurations               |

> ⚙️ All admin routes require `auth` middleware and proper role/permission setup.

<h2 id="models--relationships">🧱 Models & Relationships</h2>

 ### `Customer`
- Fields: `name`, `surname`, `phonenumber`, `email`, `birthdate`
- Relationships:
  - `belongsToMany` `Event` (Attendance)
  - Custom method `guests()` to retrieve guest list for an event

### `Event`
- Fields: Includes general event details like `name`, `description`, `start/end`, `location`, `capacity`, `whatsapp`, and visibility controls
- Media fields: `photo`, `cover` (via Spatie Media Library)
- Constants for event configuration: 
  - `ALLOW_GUESTS_RADIO`: Sim/Não
  - `TYPE_RADIO`: Ilimitado/Limitado
  - `VISUALIZATION_RADIO`: Público/Privado
- Relationships:
  - `belongsToMany` `Customer` (Attendance)
  - Methods for:
    - Listing confirmed guests
    - Counting attendance/check-ins
    - Accessing full attendance details (with guests)

> Data serialization and formatting is handled via `Carbon` and accessor methods.
 
 <h2 id="started">▶️ Getting Started</h2>

 ### Requirements

- PHP >= 8.1
- Laravel >= 10
- Composer
- MySQL or compatible database

### Installation

```bash
# Clone the repository
git clone https://github.com/issagomesdev/event-management.git

cd event-management

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Run migrations and seeders (optional)
php artisan migrate --seed

# Link storage
php artisan storage:link

# Start the server
php artisan serve

# Access the system and login with:
# Email: admin@admin.com
# Password: password
```