# indodax-RSI-indicator-bot

Bot telegram yang menampilkan data dari indodax dengan indikator RSI.
Aplikasi web ini menggunakan metode webhook untuk terhubung dengan telegram.
Untuk melakukan webhook cukup ketik pada browser 
https://api.telegram.org/bot[token_tanpa_kurung_siku]/setWebhook?url=https://www.contoh.com/namaFIle.php

### Penginstallan :
- ubah token bot pada file bot.php
- ubah detail dari database yang digunakan pada file konek.php
- lakukan webhook dengan token bot telegram

Token bot dapat dilihat pada @BotFather, tentunya setelah membuat bot telegram terlebih dahulu
### Perhatian : untuk melakukan webhook diperlukan hosting server dengan SSL

Alternatif lain untuk menggunakan metode webhook tanpa menggunakan server hosting adalah dengan lokal server (seperti XAMPP dan MAMPP) dengan perpaduan NGROK. Turorial webhook dengan server lokal : 
https://www.youtube.com/watch?v=WTABjuxB7zM

### Referensi : 
- pembuatan bot : https://dicoffeean.com/bot-telegram-webhook/
- penghitungan Relative Strenght Index (RSI) : https://www.youtube.com/watch?v=fb5RqBtHA-k
