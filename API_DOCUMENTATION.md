# API Documentation - Android App

Dokumentasi API untuk aplikasi Android Ensiklopedia Alat Teknik SMK.

## Base URL
```
http://your-domain.com/api
```

## Authentication
Semua endpoint yang memerlukan autentikasi menggunakan Laravel Sanctum dengan Bearer Token.

### Headers
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

## Endpoints

### 1. Authentication

#### Register
```
POST /register
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "kelas": "XII TKJ 1"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "kelas": "XII TKJ 1"
        },
        "token": "1|abc123..."
    }
}
```

#### Login
```
POST /login
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "kelas": "XII TKJ 1"
        },
        "token": "1|abc123..."
    }
}
```

#### Logout
```
POST /logout
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

### 2. Categories (Read-Only)

#### Get All Categories
```
GET /categories
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "nama": "Alat Ukur",
            "slug": "alat-ukur",
            "deskripsi": "Alat untuk mengukur",
            "icon": "fas fa-ruler",
            "tools_count": 5
        }
    ]
}
```

#### Get Category Detail
```
GET /categories/{id}
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "id": 1,
        "nama": "Alat Ukur",
        "slug": "alat-ukur",
        "deskripsi": "Alat untuk mengukur",
        "icon": "fas fa-ruler",
        "tools": [
            {
                "id": 1,
                "nama": "Mistar",
                "gambar": "tools/mistar.jpg",
                "deskripsi": "Alat ukur panjang",
                "fungsi": "Mengukur panjang benda"
            }
        ]
    }
}
```

### 3. Tools (Read-Only)

#### Get All Tools
```
GET /tools
```
*Requires Authentication*

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search by name, description, or function
- `category` (optional): Filter by category name
- `category_id` (optional): Filter by category ID

- `sort_by` (optional): Sort by 'latest', 'name' (default: 'latest')

**Response:**
```json
{
    "success": true,
    "message": "Tools retrieved successfully",
    "data": [
        {
            "id": 1,
            "nama": "Mistar",
            "gambar": "tools/mistar.jpg",
            "deskripsi": "Alat ukur panjang",
            "fungsi": "Mengukur panjang benda",
            "url_video": "https://youtube.com/watch?v=abc",
            "file_pdf": "tools/pdfs/mistar.pdf",
            "kategori": "Alat Ukur",

            "is_active": true,
            "tags": ["ukur", "panjang"],
            "category": {
                "id": 1,
                "nama": "Alat Ukur",
                "slug": "alat-ukur"
            }
        }
    ],
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

#### Get Tool Detail
```
GET /tools/{id}
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Tool retrieved successfully",
    "data": {
        "id": 1,
        "nama": "Mistar",
        "gambar": "tools/mistar.jpg",
        "deskripsi": "Alat ukur panjang",
        "fungsi": "Mengukur panjang benda",
        "url_video": "https://youtube.com/watch?v=abc",
        "file_pdf": "tools/pdfs/mistar.pdf",
        "kategori": "Alat Ukur",

        "is_active": true,
        "tags": ["ukur", "panjang"],
        "category": {
            "id": 1,
            "nama": "Alat Ukur",
            "slug": "alat-ukur"
        }
    }
}
```



### 4. Videos

#### Get All Videos
```
GET /videos
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Videos retrieved successfully",
    "data": [
        {
            "id": 1,
            "judul": "Tutorial Penggunaan Mistar",
            "deskripsi": "Video tutorial cara menggunakan mistar",
            "url_video": "https://youtube.com/watch?v=abc",
            "thumbnail": "videos/thumbnail1.jpg",
            "durasi": "05:30"
        }
    ]
}
```

#### Get Video Detail
```
GET /videos/{id}
```
*Requires Authentication*

**Response:**
```json
{
    "success": true,
    "message": "Video retrieved successfully",
    "data": {
        "id": 1,
        "judul": "Tutorial Penggunaan Mistar",
        "deskripsi": "Video tutorial cara menggunakan mistar",
        "url_video": "https://youtube.com/watch?v=abc",
        "thumbnail": "videos/thumbnail1.jpg",
        "durasi": "05:30"
    }
}
```

### 5. Quiz

#### Get Quizzes by Level
```
GET /quizzes/{level}
```
*Requires Authentication*

**Parameters:**
- `level`: easy, medium, hard

**Response:**
```json
{
    "success": true,
    "message": "Quizzes retrieved successfully",
    "data": [
        {
            "id": 1,
            "pertanyaan": "Apa fungsi mistar?",
            "pilihan_a": "Mengukur panjang",
            "pilihan_b": "Mengukur berat",
            "pilihan_c": "Mengukur suhu",
            "pilihan_d": "Mengukur waktu",
            "level": "easy"
        }
    ]
}
```

#### Submit Quiz
```
POST /quizzes/submit
```
*Requires Authentication*

**Request Body:**
```json
{
    "quiz_id": 1,
    "jawaban": "a",
    "level": "easy"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Quiz submitted successfully",
    "data": {
        "is_correct": true,
        "correct_answer": "a",
        "score": 10
    }
}
```

### 6. Scores

#### Get User Scores
```
GET /scores
```
*Requires Authentication*

**Query Parameters:**
- `level` (optional): Filter by level (mudah, sedang, sulit)

**Response:**
```json
{
    "success": true,
    "message": "Scores retrieved successfully",
    "data": [
        {
            "id": 1,
            "quiz_id": 1,
            "score": 10,
            "level": "mudah",
            "created_at": "2024-01-15T10:30:00Z"
        }
    ]
}
```

#### Store Score
```
POST /scores
```
*Requires Authentication*

**Request Body:**
```json
{
    "quiz_id": 1,
    "score": 10,
    "level": "mudah"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Score saved successfully",
    "data": {
        "id": 1,
        "quiz_id": 1,
        "score": 10,
        "level": "mudah"
    }
}
```

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### Unauthorized (401)
```json
{
    "success": false,
    "message": "Unauthenticated."
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Resource not found"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Internal server error",
    "error": "Error details"
}
```

## Notes

1. **Read-Only API**: API ini hanya menyediakan endpoint untuk membaca data (GET). Semua operasi CRUD (Create, Update, Delete) untuk tools dan categories dilakukan melalui web admin panel.

2. **No Favorites**: Fitur favorites telah dihapus dari API Android. Data tools ditampilkan sesuai dengan yang ada di database.

3. **No View Count**: Fitur view count telah dihapus. API tidak lagi melacak jumlah views untuk setiap tool.

4. **Data Management**: Semua pengelolaan data (tools, categories, videos, quizzes) dilakukan melalui web admin panel, bukan melalui aplikasi Android.

5. **Authentication Required**: Semua endpoint kecuali register dan login memerlukan autentikasi menggunakan Bearer Token.
