# admin-photobooth-text

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install admin-photobooth-text
```
## Konfigurasi

Tambahkan konfigurasi seperti di bawah pada aplikasi untuk
menentukan teks yang akan digunakan untuk konten body sms:

```php
return [
    'adminPhotoBoothText' => [
        'text' => 'Silahkan download gambar Anda di (:url)'
    ]
];
```

Parameter `(:key)` yang disuport adalah `fullname`, `phone`, dan `url`.