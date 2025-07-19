# E-Jarkom API Documentation

API Backend untuk aplikasi E-Jarkom (Pembelajaran Jaringan Komputer) yang dibangun dengan Laravel 10 dan Laravel Sanctum untuk autentikasi.

## Base URL
```
http://localhost:8000/api
```

## Authentication
API menggunakan Laravel Sanctum untuk autentikasi. Setelah login, gunakan token yang diterima dalam header:
```
Authorization: Bearer {your-token}
```

## Endpoints

### Authentication

#### Register
```
POST /register
```
**Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "kelas": "XII RPL 1" // optional
}
```

#### Login
```
POST /login
```
**Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Logout
```
POST /logout
```
**Headers:** `Authorization: Bearer {token}`

#### Get Profile
```
GET /profile
```
**Headers:** `Authorization: Bearer {token}`

#### Update Profile
```
PUT /profile
```
**Headers:** `Authorization: Bearer {token}`
**Body (multipart/form-data):**
```
name: "Updated Name"
kelas: "XII RPL 2"
foto: [file] // optional
```

#### Change Password
```
PUT /change-password
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "current_password": "oldpassword",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

#### Forgot Password
```
POST /forgot-password
```
**Body:**
```json
{
    "email": "john@example.com"
}
```

#### Reset Password
```
POST /reset-password
```
**Body:**
```json
{
    "email": "john@example.com",
    "token": "reset-token",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

### Tools

#### Get All Tools
```
GET /tools?page=1&per_page=10&search=router
```
**Headers:** `Authorization: Bearer {token}`
**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 10)
- `search`: Search in nama, deskripsi, fungsi

#### Get Tool Detail
```
GET /tools/{id}
```
**Headers:** `Authorization: Bearer {token}`

### Videos

#### Get All Videos
```
GET /videos?page=1&per_page=10&search=tutorial
```
**Headers:** `Authorization: Bearer {token}`
**Query Parameters:**
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 10)
- `search`: Search in judul, deskripsi

#### Get Video Detail
```
GET /videos/{id}
```
**Headers:** `Authorization: Bearer {token}`

### Quiz

#### Get Quiz by Level
```
GET /quiz?level=mudah
```
**Headers:** `Authorization: Bearer {token}`
**Query Parameters:**
- `level`: mudah, sedang, sulit (required)

#### Submit Quiz
```
POST /quiz/submit
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "level": "mudah",
    "answers": {
        "1": "a",
        "2": "b",
        "3": "c"
    }
}
```

### Scores

#### Get User Scores
```
GET /scores?level=mudah&page=1&per_page=10
```
**Headers:** `Authorization: Bearer {token}`
**Query Parameters:**
- `level`: mudah, sedang, sulit (optional)
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 10)

#### Get Score Detail
```
GET /scores/{id}
```
**Headers:** `Authorization: Bearer {token}`

#### Save Score (Manual)
```
POST /scores
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "skor": 85,
    "total_soal": 10,
    "benar": 8,
    "salah": 2,
    "level": "mudah"
}
```

### Dashboard & Statistics

#### Get User Dashboard Stats
```
GET /dashboard/stats
```
**Headers:** `Authorization: Bearer {token}`

#### Get Leaderboard
```
GET /leaderboard?level=mudah&page=1&per_page=10
```
**Headers:** `Authorization: Bearer {token}`
**Query Parameters:**
- `level`: mudah, sedang, sulit (optional)
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 10)

#### Get App Statistics
```
GET /app/stats
```
**Headers:** `Authorization: Bearer {token}`

## Response Format

Semua response menggunakan format JSON dengan struktur:

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {
        // response data
    },
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50,
        "from": 1,
        "to": 10
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

## HTTP Status Codes

- `200`: Success
- `201`: Created
- `400`: Bad Request
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `500`: Internal Server Error

## CORS Configuration

API sudah dikonfigurasi untuk menerima request dari semua origin. Untuk production, pastikan untuk mengkonfigurasi CORS dengan lebih spesifik di `config/cors.php`.

## File Upload

Untuk upload foto profil, gunakan `multipart/form-data` dan field `foto`. File akan disimpan di `storage/app/public/profile-photos/`.

## Notes

1. Semua endpoint yang memerlukan autentikasi harus menyertakan token Bearer
2. Pagination tersedia untuk endpoint yang mengembalikan list data
3. Search functionality tersedia untuk tools dan videos
4. Quiz answers menggunakan format object dengan quiz_id sebagai key dan pilihan jawaban sebagai value
5. Level quiz: mudah, sedang, sulit
6. Foto profil bersifat opsional dan akan di-resize otomatis