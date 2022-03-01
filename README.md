# 1. Clone Project
run comman "git clone {url}"

# 2. Install Vendor
run command composer install

# 3. Setting DB
tambahkah file dengan nama .env diroot folder copy seluruh isi file dari .env.example ke file .env, ubah nama DB_DATABASE menjadi interview, DB_HOST menjadi localhost, DB_USERNAME menjadi root (jika menggunakan phpmyadmin) dan kosongkan DB_PASSWORD (jika menggunakan phpmyadmin)

# 4. Run Migrasi
run command "php artisan migrate --seed"

# 5. Optimize
run command "php artisan optimize"

# 6. View Documentation
jalankan index web "/" dan akan diarahkan didokumentasi API secara otomatis
