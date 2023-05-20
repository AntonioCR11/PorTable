## About Portable
Project - Portable is a restaurant reservation web application created with Laravel 9 Framework. It my 5'th Semester Project on Web Framework, Software Development and Mobile Development Lecture. PorTable is used for reserving tables on restaurant, it is made for 3 specific role (customer, restaurant, admin) with various features for each role.

<details>
<summary>Portable Features, Click to reveal!</summary>
<br>
    
    PorTable Application Flow :
    1. User register & login to PorTable
        Tipe User :
        a. Customer
        b. Restaurant
        c. Admin
    
         Note :
            - ketika register pada index maka user akan didaftarkan default sebagai akun customer,
              untuk membuat akun restoran maka customer perlu mendaftarkan
              kembali akun dan melengkapi syarat & ketentuan
            - akun admin bawaan adalah 1 buah akun, untuk membuat akun admin lainnya harus lewat
              akun admin lainnya atau langsung dri Database XD
    
    2. Customer's Features :
    
        <> Proposal :                                                           STATUS
        - Browse restoran (catalog)                                             -- DONE
        - Browse rekomendasi                                                    -- DONE
        - Mencari restoran (searchbar)                                          -- DONE
        - Filter restoran (Review, harga, meja tersedia)                        -- DONE
        - Membayar dengan e-money atau e-banking (API midtrans/ipayment)        -- DONE
        - Top-up e-money                                                        -- DONE
        - Favorite restoran                                                     -- DONE
        - Melakukan reservasi (Book table yang available)                       -- DONE
        - Melihat sejarah reservasi (Transaction History)                       -- DONE
        - Melihat reservasi saat ini (Active Transaction)                       -- DONE
        - Membatalkan reservasi saat ini (Uang reservasi tidak dikembalikan)    -- DONE
        - CRUD review kepada restoran yang sudah pernah direservasi             -- DONE

        <> Tambahan :
        - Register akun restoran                                                -- DONE
        - Page notifikasi                                                       -- DONE

    3. Restaurant's Features :

        <> Proposal :                                                           STATUS
        - Melihat reservasi dan transaksi                                       -- DONE
        - Mengganti jumlah atau layout dari meja                                -- DONE
        - Menambah atau mengganti deskripsi restoran                            -- DONE
        - Menambah atau mengganti waktu aktif restoran                          -- DONE
        - Mengganti jumlah yang harus dibayar di aplikasi                       -- DONE
        - Menandai review spam agar di review oleh admin                        -- DONE

        <> Tambahan :
        - Melihat dashboard/ statistic restoran                                 -- DONE
        - Edit status reservasi saat ini (meja available/ tidak)                -- DONE

    4. Admin's Features :

        <> Proposal :                                                           STATUS
        - CRUD akun restoran                                                    -- DONE
        - CRUD akun pelanggan                                                   -- DONE
        - Ban akun restoran                                                     -- DONE
        - Ban akun pelanggan                                                    -- DONE
        - Melihat semua transaksi                                               -- DONE
        - Melihat semua review di restoran                                      -- DONE
        - Mereview review spam restoran                                         -- CANCEL
        - Menambah review pada restoran                                         -- CANCEL
        - Menghilangkan review pada restoran                                    -- CANCEL
        - Membatalkan reservasi pelanggan                                       -- CANCEL

        <> Tambahan :
        - Dashboard/ Summary                                                    -- DONE
        - Developer Post/Notification                                           -- DONE
    
</details>

## Preview
<img width="1280" alt="Screenshot (3)" src="https://github.com/AntonioCR11/PorTable/assets/99940538/4ffe33a7-3d6d-4ede-8668-fbaa4ebfe1b6">
<img width="1280" alt="Screenshot (3)" src="https://github.com/AntonioCR11/PorTable/assets/99940538/94091b48-6076-49b0-8391-a34403fd165d">


## Made with
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
