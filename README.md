# Invoice PDF Generator (Laravel 8)

## 📌 Project Overview

This project is a Laravel-based invoice generation system.
It allows users to create invoices with company, customer, and item details and view them in a structured format.

---

## 🚀 Features

* Create invoices with multiple items
* GST calculation (CGST & SGST)
* Company & Customer management
*PDF generation using DomPDF

---

## 🛠️ Tech Stack

* Laravel 8
* MySQL
* Blade Templates
* DomPDF (barryvdh/laravel-dompdf)

---

## ⚙️ Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/Vyshnav-Tv/invoice-pdf-generator.git
 cd invoice-pdf-generator
```

### 2. Install dependencies

```bash
composer install

composer require barryvdh/laravel-dompdf
```

### 3. Setup environment file

```bash
cp .env.example .env
```

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Configure database

Update `.env`:

```env
DB_DATABASE=invoice_pdf
DB_USERNAME=phpuser
DB_PASSWORD=php1234
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Start server

```bash
php artisan serve
```

---

## 📡 API Endpoints

### Create Invoice

POST `/api/invoices`

### Get Invoice

GET `/api/invoice/{invoice_id}`

---


---

📁 Project Structure 
app/ 
database/migrations/||
resources/views/invoice.blade.php|| 
Services/InvoiceService||
Controller/InvoiceController||
reoutes/api.php




## ⚠️ Notes

* Ensure `company_id` and `customer_id` exist before creating invoices
* Bank details are optional

---


PDF-image
---------<img width="658" height="656" alt="iziziz" src="https://github.com/user-attachments/assets/49f53128-813d-4742-be00-7ce82a50d4c7" />




