<h1 align="center">Todo List & Note Application</h1>

## Tech

-   Laravel 10
-   Laravel Turbo
-   Alpine JS
-   Tailwind CSS
-   Daisy UI
-   Feather Icons

## Fitur

-   Login & Register
-   Reset Password (dikirim ke email)
-   Todo List
-   Note (bisa dikunci)
-   Enkripsi Laravel menggunakan OpenSSL untuk menyediakan enkripsi AES-256 dan AES-128

## Cara Penggunaan

```bash
# clone repository
git clone https://github.com/orz14/nyatet-app.git
cd nyatet-app/

# install php package using composer
composer install

# copy .env and modify it
cp .env.example .env

# generate key
php artisan key:generate

# run migration & seeders
php artisan migrate --seed

# install package, using yarn or npm
# using yarn
yarn
yarn dev

# using npm
npm install
npm run dev

# serve
php artisan serve
```

## Contoh Enkripsi

<img src="https://cdn.jsdelivr.net/gh/orz14/orzcode@main/img/contoh-enkripsi.png" alt="Contoh Enkripsi">

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">Created with 💚 by <a href="https://orzproject.my.id" target="_blank">ORZCODE</a></p>
