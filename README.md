<h1 align="center">Todo List & Note Application</h1>

## Tech

-   Laravel 10
-   Laravel Turbo
-   Socialite Plugin
-   Alpine JS
-   Tailwind CSS
-   Daisy UI

## Fitur

-   Login & Register
-   Login with GitHub / Google
-   Reset Password (dikirim ke email)
-   Todo List
-   Note (bisa dikunci)
-   Enkripsi Laravel menggunakan OpenSSL untuk menyediakan enkripsi AES-256 dan AES-128

## Cara Penggunaan

-   Clone Repository

```bash
git clone https://github.com/orz14/nyatet-app.git
cd nyatet-app/
```

-   Copy .env and Modify It

```bash
cp .env.example .env
```

-   Install Vendor Using Composer

```bash
composer install
```

-   Generate Key

```bash
php artisan key:generate
```

-   Run Migration & Seeders

```bash
php artisan migrate --seed
```

-   Install Node Modules Using Yarn or NPM

```bash
# using yarn
yarn
yarn dev

# using npm
npm install
npm run dev
```

-   Serve

```bash
php artisan serve
```

## Contoh Enkripsi

<img src="https://cdn.jsdelivr.net/gh/orz14/orzcode@main/img/contoh-enkripsi.png" alt="Contoh Enkripsi">

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">Created with 💚 by <a href="https://orzproject.my.id" target="_blank">ORZCODE</a></p>
