<h1 align="center" style="font-weight: bold;">🛠️ Listinha Vip — Event Management System</h1>

![Preview do site](https://media.byissa.dev/event-management/preview.png)

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![Docker](https://img.shields.io/badge/docker-%232496ED.svg?style=for-the-badge&logo=docker&logoColor=white) ![JavaScript](https://img.shields.io/badge/Javascript-000?style=for-the-badge&logo=javascript) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#structure">Structure</a> •
  <a href="#routes">App Routes</a> •
  <a href="#models--relationships">Models & Relationships</a> •
  <a href="#docker">Docker</a> •
  <a href="#env">Environment variables</a> •
  <a href="#started">Getting Started</a> •
  <a href="#seeders">Seeders</a> •
  <a href="#deploy">Deploy</a> •
  <a href="#testing">Testing</a> •
  <a href="#commands">Useful commands</a>
</p>

<h2 id="about">📌 About</h2>

<p>
Listinha Vip is an event management platform developed with Laravel, HTML, CSS, and JavaScript. It allows users to confirm attendance, invite guests, and check in at events through a friendly interface. The platform includes both a public area for attendees and a complete administrative panel for event managers.
</p>

<p>
Listinha Vip has role-based access, guest control, check-in functionality, and attendee management tools.
</p>

[![project](https://img.shields.io/badge/📱Visit_this_project-000?style=for-the-badge&logo=project)](https://em.byissa.dev)

<h2 id="features">✨ Features</h2>

### Public Users

- View active events on homepage.
- View detailed information about each event, with CEP-based address autofill on the admin side.
- Confirm attendance (with automatic login/register).
- Add guests to the attendance list (if allowed by event).
- Receive WhatsApp redirection after confirmation.

### Admin Panel

- Dashboard with upcoming events and stats.
- Full permission and role management.
- Admin user management with filters and exports.
- Customer management (CRUD with exports).
- Event management (CRUD, filters, exports, check-in view), with photo gallery and cover image via Spatie Media Library.
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
 ┗ 📂 Support/
   ┣ 📂 Address/
   ┃ ┗ BrazilianStates.php       # UF list used by the state <select> and by the seeders
   ┗ 📂 Seeding/                 # Content generators used by the seeders (see #seeders)

📂 database/
 ┣ 📂 factories/                 # EventFactory, CustomerFactory
 ┣ 📂 fake_media/                # Sample images consumed by EventSeeder/CurrentMonthEventSeeder
 ┣ 📂 migrations/                 # DB structure for events, customers, guests, attendance
 ┗ 📂 seeders/

📂 docker/
 ┣ 📂 php/                       # Dockerfile (dev/prod stages), php.ini overrides
 ┗ 📂 nginx/                     # nginx config + prod Dockerfile

📂 public/
 ┣ 📂 css/, js/, images/
 ┗ 📂 storage/                    # Media and uploads (symlink to storage/app/public)

📂 resources/
 ┗ 📂 views/                      # Blade templates for admin and public pages

📂 routes/
 ┗ web.php                        # All app routes
```

<h2 id="routes">📍 Application Routes</h2>

### Public

| Method | Path                                           | Description                          |
|--------|------------------------------------------------|---------------------------------------|
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
|--------|-------------------------------------|---------------------------------------|
| GET    | `/admin/`                           | Dashboard                            |
| GET    | `/admin/events/{id}/checkin`        | Check-in view for event              |
| POST   | `/admin/events-checkin/{id}/{eventID}/{action}/{type}` | Update check-in status   |
| CRUD   | `/admin/events`                     | Manage events                        |
| CRUD   | `/admin/customers`                  | Manage clients                       |
| CRUD   | `/admin/users`                      | Manage admin users                   |
| CRUD   | `/admin/roles`                      | Manage roles                         |
| CRUD   | `/admin/permissions`                | Manage permissions (read-only: index/show) |

> ⚙️ All admin routes require `auth` middleware and proper role/permission setup.

<h2 id="models--relationships">🧱 Models & Relationships</h2>

 ### `Customer`
- Fields: `name`, `surname`, `phonenumber`, `email`, `birthdate`
- Relationships:
  - `belongsToMany` `Event` (Attendance)
  - Custom method `guests()` to retrieve guest list for an event

### `Event`
- Fields: general event details (`name`, `description`, `start/end`, `capacity`, `whatsapp`, visibility controls) plus a Brazilian address: `cep`, `state` (UF), `city`, `neighborhood`, `street`, `number`. There is no `country` field — the platform targets Brazil only.
- Media fields: `photo` (gallery, 1-6 images) and `cover` (single image), both via Spatie Media Library, declared in `registerMediaCollections()`.
- Constants for event configuration:
  - `ALLOW_GUESTS_RADIO`: Sim/Não
  - `TYPE_RADIO` / `TYPE_LIMITED` / `TYPE_UNLIMITED`: Limitado/Ilimitado
  - `VISUALIZATION_RADIO`: Público/Privado
- Relationships:
  - `belongsToMany` `Customer` (Attendance)
  - Methods for:
    - Listing confirmed guests
    - Counting attendance/check-ins
    - Accessing full attendance details (with guests)

> Data serialization and formatting is handled via `Carbon` and accessor methods.

### Address & CEP autofill

The `state` field is a `<select>` populated from `App\Support\Address\BrazilianStates` (all 27 UF). The `cep` field triggers a client-side lookup against [ViaCEP](https://viacep.com.br/) on blur, auto-filling `state`, `city`, `neighborhood` and `street` — the user can still edit every field afterwards. `number` is always typed manually. This is the **only** feature in the app that depends on internet access, and only when a human is actively filling the event form.

 <h2 id="docker">🐳 Docker</h2>

The project ships with separate Docker setups for development and production — nothing else is required on the host besides Docker itself.

### Development

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
```

The app becomes available at `http://localhost:${APP_PORT}` (default `8000`).

Services:

| Service | Purpose                                                        |
|---------|------------------------------------------------------------------|
| `app`   | PHP-FPM 8.2 with the full source bind-mounted (hot reload)       |
| `nginx` | Serves the app on `${APP_PORT}`, proxies PHP to `app`            |
| `mysql` | MySQL 8.0, data persisted in the `mysql_data` volume              |
| `redis` | Cache/session store                                               |
| `node`  | Runs `npm run dev` (Vite) with HMR exposed on port `5173`         |

Logs are visible with `docker compose logs -f app` / `docker compose logs -f nginx`.

> **Performance note (Windows/Mac):** `vendor/`, `storage/` and `bootstrap/cache`
> are mounted as named Docker volumes instead of living on the bind-mounted
> source (`docker-compose.yml`). Bind-mounted I/O on Docker Desktop for
> Windows/Mac is dramatically slower than the container's own filesystem —
> since Laravel reads hundreds of vendor classes and writes compiled
> views/cache/sessions on every request, leaving those directories on the
> bind mount made simple pages take several seconds to load. None of these
> three need host hot-reload (you don't hand-edit `vendor/` or `storage/`),
> so moving them to named volumes keeps hot reload for your actual code
> while removing that overhead. After changing PHP dependencies, run
> `docker compose exec app composer install` again (the vendor volume
> starts empty on a first `docker compose up`).

### Production

```bash
cp .env.example .env   # then edit APP_ENV, APP_KEY, DB_*, APP_PORT for your VPS
docker compose -f docker-compose.prod.yml up -d --build
```

The `app` image is built from the `prod` stage of `docker/php/Dockerfile`: `composer install --no-dev --optimize-autoloader`, front-end assets pre-built with Vite, `OPcache` enabled with `validate_timestamps=0`, no source volumes (the image is immutable). On start, the container automatically runs `migrate --force`, `config:cache`, `route:cache` and `view:cache` (see `docker/entrypoint.prod.sh`). `nginx` is built from `docker/nginx/Dockerfile` and only serves static files + proxies PHP requests — uploaded media lives in the shared `storage_data` volume, exposed at `/storage/` directly by nginx.

`APP_ENV=production` and `APP_DEBUG=false` should be set in `.env` before building the production image.

<h2 id="env">🔧 Environment variables</h2>

Copy `.env.example` to `.env` and adjust as needed. Highlights:

| Variable | Purpose |
|----------|---------|
| `APP_PORT` | Port published by nginx on the host — change this only, in `docker-compose.yml` / `docker-compose.prod.yml`, to move the app to another port on a VPS. Defaults to `8000`. |
| `DB_HOST` / `REDIS_HOST` | Set to the Docker service names (`mysql` / `redis`) by default. Change to `127.0.0.1` if running without Docker. |
| `CACHE_DRIVER` / `SESSION_DRIVER` | Default to `redis`. |

<h2 id="started">▶️ Getting Started (without Docker)</h2>

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
# edit .env: DB_HOST=127.0.0.1, REDIS_HOST=127.0.0.1

# Run migrations and seeders
php artisan migrate:fresh --seed

# Link storage
php artisan storage:link

# Start the server
php artisan serve

# Access the admin panel in /admin and login with:
# Email: admin@admin.com
# Password: password
```

<h2 id="seeders">🌱 Seeders</h2>

`php artisan migrate:fresh --seed` (or `docker compose exec app php artisan migrate:fresh --seed`) is enough to get a fully populated demo system — no internet access and no manual steps required. It runs, in order:

1. **Permissions / Roles / Users** — the default admin (`admin@admin.com` / `password`) and RBAC data.
2. **`CustomerSeeder`** — 100 Brazilian customers (`Customer::factory()`), with realistic names, phone numbers, emails and birthdates.
3. **`EventSeeder`** — 36 events for the current year (`Carbon::now()->year`), 3 per month, drawn from a fixed, seasonally-coherent catalog (`App\Support\Seeding\EventCatalog`) — beach parties in the summer months, Festa Junina in June, Halloween in October, Réveillon in December, and so on. Each event gets:
   - 1 to 6 photos + 1 cover image, picked from `database/fake_media/` by matching the event's category against the image file names (`App\Support\Seeding\EventMediaSelector`), attached via Spatie Media Library with `preservingOriginal()` so the source images are never consumed;
   - a 200–600 word description and a 6–10 item rules list, generated from category-aware text blocks (`EventDescriptionGenerator`, `EventRulesGenerator`) — no lorem ipsum;
   - a real Brazilian address (`AddressCatalog`) and two WhatsApp numbers with valid DDDs (`WhatsappGenerator`);
   - varying schedule (a few hours, a full day, or a whole weekend), capacity (limited events get 10–30 slots) and event type, balanced between limited/unlimited.
4. **`EventAttendanceSeeder`** — for every event, samples a different number of customers as attendees (`customer_event`, ~30% already checked in) and, for each attendee, 0–5 guests with Brazilian names (`customer_event_guests`, also ~30% checked in). Every run of `migrate:fresh --seed` produces different combinations while keeping the data internally coherent.

Re-running the seeders (`migrate:fresh --seed`) always yields a fresh, differently-shuped but equally realistic dataset — schedules, attendees, guests, check-ins, capacities and photo selections are re-randomized each time.

### `CurrentMonthEventSeeder`

A separate, independent seeder for day-to-day development — creates only **3 events, all in the current month**, from its own small catalog pool (so names never collide with the 36 from `EventSeeder`). It is **not** part of the default `DatabaseSeeder` chain. Run it manually when you just want fresh current-month demo data:

```bash
php artisan db:seed --class=CurrentMonthEventSeeder
```

<h2 id="deploy">🚀 Deploy</h2>

1. Provision a VPS with Docker and Docker Compose installed.
2. Clone the repository and create `.env` from `.env.example`, setting `APP_ENV=production`, `APP_DEBUG=false`, a generated `APP_KEY`, real `DB_*` credentials and the desired `APP_PORT`.
3. Build and start: `docker compose -f docker-compose.prod.yml up -d --build`.
4. Point your reverse proxy / DNS to the VPS on `APP_PORT` (or put a proxy such as Caddy/Traefik in front for TLS).
5. To deploy a new version: `git pull && docker compose -f docker-compose.prod.yml up -d --build`. Migrations, config/route/view cache and `storage:link` run automatically on container start.

<h2 id="testing">🧪 Testing</h2>

The suite is PHPUnit-based (193 tests / 548 assertions as of this writing), organized by responsibility:

```txt
tests/
 ┣ 📂 Concerns/       # ActsAsAdmin / SeedsPermissions — reusable auth fixtures for Feature tests
 ┣ 📂 Unit/
 ┃ ┣ 📂 Models/       # accessors, mutators, constants, relationships, business-rule methods
 ┃ ┗ 📂 Support/      # the seeding generator classes (EventCatalog, EventMediaSelector, etc.)
 ┣ 📂 Feature/
 ┃ ┣ 📂 Public/       # homepage, event details, password-protected list/checkin views, WhatsApp redirect
 ┃ ┣ 📂 Customer/     # cookie-based registration/login/logout, confirm attendance, guests
 ┃ ┣ 📂 Admin/        # Auth, Dashboard, Events, Customers, Users, Roles, Permissions — CRUD + authorization matrix per module
 ┃ ┗ 📂 Api/          # the 5 Api/V1/Admin (Sanctum) controllers
 ┗ 📂 Integration/    # Media Library upload → conversions → storage; full confirm→capacity→checkin→dashboard pipeline
```

### Test database

Tests **never** touch the development database. `docker/mysql/init-testing-db.sql` creates a dedicated `laravel_testing` schema automatically the first time the `mysql` volume boots; `.env.testing` points at it and is loaded automatically by Laravel whenever `APP_ENV=testing` (which `phpunit.xml` sets). Every test class that touches the database uses `RefreshDatabase`. If you already had the `mysql` volume running before pulling this, create the schema once by hand:

```bash
docker compose exec mysql mysql -uroot -psecret -e "CREATE DATABASE IF NOT EXISTS laravel_testing; GRANT ALL PRIVILEGES ON laravel_testing.* TO 'laravel'@'%';"
```

### Running the suite

```bash
docker compose exec app php artisan test
# or, equivalently
docker compose exec app composer test
```

Run a single directory or file the same way `artisan test` normally supports, e.g. `docker compose exec app php artisan test tests/Feature/Admin/Events`.

### Coverage

Requires a coverage driver (Xdebug or pcov) inside the container — not installed by default in the dev image to keep it lean:

```bash
docker compose exec app php artisan test --coverage-text
```

CI (below) runs this automatically with `pcov` and won't fail the build if coverage generation itself has an issue — the actual test run is a separate, blocking step.

### CI/CD

`.github/workflows/tests.yml` runs on every push/PR to `main`: spins up a `mysql:8.0` service, installs PHP 8.2 with the same extensions as the Docker image, copies `.env.testing` to `.env`, migrates, and runs `php artisan test`. `CACHE_DRIVER`/`SESSION_DRIVER` are `array` in the testing environment, so no Redis service is needed in CI.

<h2 id="commands">🧰 Useful commands</h2>

```bash
# Tail logs
docker compose logs -f app
docker compose logs -f nginx

# Run artisan / composer / npm inside the containers
docker compose exec app php artisan tinker
docker compose exec app composer require <package>
docker compose exec node npm install <package>

# Reset the database with fresh demo data
docker compose exec app php artisan migrate:fresh --seed

# Only refresh the current month's demo events
docker compose exec app php artisan db:seed --class=CurrentMonthEventSeeder

# Run the test suite
docker compose exec app php artisan test
```
