# SMS Gateway API

Bu loyiha `Service + Interface` yondashuvi asosida yozilgan.  
Controllerlar bevosita interfeyslarni inject qiladi va barcha biznes logika service qatlamida bajariladi.

## Ishlash oqimi

1. Tashqi tizim `POST /api/sms/send` ga so'rov yuboradi (`api_key`, `phones[]`, `message`)
2. Tizim `api_key` orqali loyihani topadi
3. Har bir telefon raqami format bo'yicha tekshiriladi (`+998XXXXXXXXX`)
4. Har bir raqam uchun `sms_messages` jadvaliga `pending` status bilan yozuv yaratiladi
5. Har bir yozuv uchun queue ga `DispatchSmsJob` qo'yiladi
6. Worker jobni olib, kerakli provider orqali yuboradi
7. Natijaga qarab `sent`/`delivered`/`failed` status yangilanadi

## O'rnatish

```bash
git clone <repository-url>
cd sms-provider
composer install
cp .env.example .env
php artisan key:generate
```

## `.env` sozlamalari

Kamida quyidagilarni to'g'rilang:

```env
DB_CONNECTION=sqlite
QUEUE_CONNECTION=database

SMS_DEFAULT_PROVIDER=fake
SMS_ESKIZ_BASE_URL=
SMS_ESKIZ_API_KEY=
SMS_PLAYMOBILE_BASE_URL=
SMS_PLAYMOBILE_LOGIN=
SMS_PLAYMOBILE_PASSWORD=
```

## Baza va queue tayyorlash

```bash
php artisan migrate
php artisan queue:work
```

## Loyihani ishga tushirish

```bash
php artisan serve
```

## API endpointlar

### 1) Loyiha yaratish

`POST /api/projects`

So'rov:

```json
{
  "name": "E-commerce",
  "description": "Asosiy sayt",
  "provider_code": "fake"
}
```

Javob:

```json
{
  "success": true,
  "data": {
    "project": {
      "id": 1,
      "name": "E-commerce",
      "description": "Asosiy sayt",
      "provider_code": "fake",
      "is_active": true
    },
    "api_key": "faqat-bir-marta-korinatigan-kalit"
  },
  "error": null,
  "meta": null
}
```

### 2) Loyiha providerini yangilash

`PATCH /api/projects/{project}/provider`

So'rov:

```json
{
  "provider_code": "playmobile"
}
```

### 3) SMS yuborish

`POST /api/sms/send`

So'rov:

```json
{
  "api_key": "loyiha-api-key",
  "phones": ["+998901112233", "+998931112233"],
  "message": "Salom! Bu test xabar."
}
```

### 4) SMS tarixi

`GET /api/sms/history?api_key=...&status=sent&phone=%2B998901112233&date_from=2026-02-01&date_to=2026-02-27&per_page=15`

Filterlar:

- `status`: `pending`, `sent`, `delivered`, `failed`
- `phone`: `+998XXXXXXXXX`
- `date_from`, `date_to`
- `per_page`: 1 dan 100 gacha

## Validatsiya qoidalari

- `phones` doim massiv bo'lishi kerak
- Har bir telefon: `+998XXXXXXXXX`
- `message` bo'sh bo'lmasligi kerak
- `api_key` mavjud va aktiv loyihaga tegishli bo'lishi kerak


## Yangi provider qo'shish

1. `app/Infrastructure/SmsProviders` ichida yangi class yozing va `SmsProviderInterface` ni implement qiling.
2. `config/sms-providers.php` ga provider konfiguratsiyasini qo'shing.
3. `ProviderResolverService` ichida mapping kiriting.
4. Provider uchun test yozing.

## Muhim eslatmalar

- Hozirgi provider integratsiyalar mock/fake ko'rinishida.
- Queue worker ishlamasa SMS `pending` holatda qoladi.
- `api_key` faqat loyiha yaratilganda ochiq ko'rinishda qaytariladi, bazada hash saqlanadi.
