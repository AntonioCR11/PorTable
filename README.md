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

