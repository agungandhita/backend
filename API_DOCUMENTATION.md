# API Documentation - Enhanced Learning Management System

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require Bearer token authentication using Laravel Sanctum.

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

## Authentication Endpoints

### Register
**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "kelas": "XII RPL 1",
    "phone": "081234567890",
    "bio": "Student bio",
    "foto": "base64_image_string"
}
```

### Login
**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

### Logout
**POST** `/logout` (Protected)

### Get Profile
**GET** `/profile` (Protected)

### Update Profile
**PUT** `/profile` (Protected)

**Request Body:**
```json
{
    "name": "John Doe Updated",
    "email": "john.updated@example.com",
    "kelas": "XII RPL 2",
    "phone": "081234567891",
    "bio": "Updated bio",
    "foto": "base64_image_string"
}
```

### Change Password
**PUT** `/change-password` (Protected)

**Request Body:**
```json
{
    "current_password": "oldpassword",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

### Forgot Password
**POST** `/forgot-password`

**Request Body:**
```json
{
    "email": "john@example.com"
}
```

### Reset Password
**POST** `/reset-password`

**Request Body:**
```json
{
    "email": "john@example.com",
    "token": "reset_token",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

## Categories Endpoints

### Get All Categories
**GET** `/categories` (Protected)

**Response:**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "nama": "Pengukuran",
            "slug": "pengukuran",
            "deskripsi": "Alat-alat untuk mengukur berbagai besaran fisik",
            "icon": "ruler-icon",
            "tools_count": 5,
            "created_at": "2024-01-15 10:00:00",
            "updated_at": "2024-01-15 10:00:00"
        }
    ]
}
```

### Get Category by ID
**GET** `/categories/{id}` (Protected)

### Create Category
**POST** `/categories` (Protected)

**Request Body:**
```json
{
    "nama": "New Category",
    "deskripsi": "Category description",
    "icon": "category-icon"
}
```

### Update Category
**PUT** `/categories/{id}` (Protected)

### Delete Category
**DELETE** `/categories/{id}` (Protected)

## Tools Endpoints

### Get All Tools
**GET** `/tools` (Protected)

**Query Parameters:**
- `search`: Search in name, description, and function
- `category_id`: Filter by category ID
- `featured`: Filter featured tools (true/false)
- `sort`: Sort by (latest, popular, name)
- `per_page`: Number of items per page (default: 10)

**Example:** `/tools?search=hammer&category_id=1&featured=true&sort=popular&per_page=15`

### Get Tool by ID
**GET** `/tools/{id}` (Protected)

**Response:**
```json
{
    "success": true,
    "message": "Tool retrieved successfully",
    "data": {
        "id": 1,
        "nama": "Hammer",
        "gambar": "http://localhost:8000/storage/tools/hammer.jpg",
        "deskripsi": "Tool description",
        "fungsi": "Tool function",
        "url_video": "https://youtube.com/watch?v=example",
        "file_pdf": "http://localhost:8000/storage/pdfs/hammer-manual.pdf",
        "kategori": "Hand Tools",
        "views_count": 150,
        "is_featured": true,
        "is_active": true,
        "tags": ["construction", "manual"],
        "category_id": 1,
        "category": {
            "id": 1,
            "nama": "Pengukuran",
            "slug": "pengukuran"
        },
        "is_favorited": false,
        "created_at": "2024-01-15 10:00:00",
        "updated_at": "2024-01-15 10:00:00"
    }
}
```

### Create Tool
**POST** `/tools` (Protected)

**Request Body:**
```json
{
    "nama": "New Tool",
    "deskripsi": "Tool description",
    "fungsi": "Tool function",
    "gambar": "base64_image_string",
    "url_video": "https://youtube.com/watch?v=example",
    "file_pdf": "base64_pdf_string",
    "kategori": "Hand Tools",
    "category_id": 1,
    "is_featured": false,
    "is_active": true,
    "tags": ["construction", "manual"]
}
```

### Update Tool
**PUT** `/tools/{id}` (Protected)

### Delete Tool
**DELETE** `/tools/{id}` (Protected)

### Get Featured Tools
**GET** `/tools/featured/list` (Protected)

### Get Popular Tools
**GET** `/tools/popular/list` (Protected)

### Toggle Favorite
**POST** `/tools/{id}/favorite` (Protected)

**Response:**
```json
{
    "success": true,
    "message": "Tool added to favorites",
    "data": {
        "is_favorited": true
    }
}
```

## Favorites Endpoints

### Get User Favorites
**GET** `/favorites` (Protected)

### Add to Favorites
**POST** `/favorites` (Protected)

**Request Body:**
```json
{
    "tool_id": 1
}
```

### Remove from Favorites
**DELETE** `/favorites/{tool_id}` (Protected)

### Check if Favorited
**GET** `/favorites/{tool_id}/check` (Protected)

## Quiz Endpoints

### Get Quizzes by Level
**GET** `/quizzes/{level}` (Protected)

**Parameters:**
- `level`: easy, medium, or hard
- `limit`: Number of questions (default: 5)

**Example:** `/quizzes/easy?limit=10`

**Response:**
```json
{
    "success": true,
    "message": "Quizzes retrieved successfully",
    "data": {
        "level": "easy",
        "total_questions": 5,
        "quizzes": [
            {
                "id": 1,
                "soal": "What is a hammer used for?",
                "pilihan_a": "Cutting",
                "pilihan_b": "Hammering",
                "pilihan_c": "Measuring",
                "pilihan_d": "Drilling",
                "level": "easy"
            }
        ]
    }
}
```

### Submit Quiz
**POST** `/quizzes/submit` (Protected)

**Request Body:**
```json
{
    "level": "easy",
    "answers": [
        {
            "quiz_id": 1,
            "jawaban": "b"
        },
        {
            "quiz_id": 2,
            "jawaban": "a"
        }
    ]
}
```

**Response:**
```json
{
    "success": true,
    "message": "Quiz submitted successfully",
    "data": {
        "score_id": 1,
        "score_percentage": 80.0,
        "correct_answers": 4,
        "incorrect_answers": 1,
        "total_questions": 5,
        "level": "easy",
        "grade": "B",
        "results": [
            {
                "quiz_id": 1,
                "soal": "What is a hammer used for?",
                "jawaban_user": "b",
                "jawaban_benar": "b",
                "is_correct": true
            }
        ]
    }
}
```

### Get Quiz History
**GET** `/quizzes/history/user` (Protected)

**Query Parameters:**
- `level`: Filter by level (easy, medium, hard)
- `per_page`: Number of items per page (default: 10)

### Get Quiz Statistics
**GET** `/quizzes/stats/user` (Protected)

**Response:**
```json
{
    "success": true,
    "message": "Quiz statistics retrieved successfully",
    "data": {
        "total_quizzes_taken": 15,
        "average_score": 78.5,
        "best_score": 95.0,
        "by_level": {
            "easy": {
                "total_taken": 5,
                "average_score": 85.0,
                "best_score": 95.0,
                "total_correct": 20,
                "total_questions": 25
            },
            "medium": {
                "total_taken": 5,
                "average_score": 75.0,
                "best_score": 90.0,
                "total_correct": 18,
                "total_questions": 25
            },
            "hard": {
                "total_taken": 5,
                "average_score": 65.0,
                "best_score": 80.0,
                "total_correct": 15,
                "total_questions": 25
            }
        }
    }
}
```

## Videos Endpoints

### Get All Videos
**GET** `/videos` (Protected)

### Get Video by ID
**GET** `/videos/{id}` (Protected)

## Scores Endpoints

### Get User Scores
**GET** `/scores` (Protected)

### Create Score
**POST** `/scores` (Protected)

### Get Score by ID
**GET** `/scores/{id}` (Protected)

### Dashboard Statistics
**GET** `/dashboard/stats` (Protected)

### Leaderboard
**GET** `/leaderboard` (Protected)

### App Statistics
**GET** `/app/stats` (Protected)

## Error Responses

All endpoints return consistent error responses:

```json
{
    "success": false,
    "message": "Error message",
    "error": "Detailed error information"
}
```

### Common HTTP Status Codes
- `200`: Success
- `201`: Created
- `400`: Bad Request
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `500`: Internal Server Error

## File Upload

### Image Upload
- Supported formats: JPG, JPEG, PNG, GIF, WEBP
- Maximum size: 2MB
- Images are automatically optimized and resized

### PDF Upload
- Supported format: PDF
- Maximum size: 10MB

### Base64 Format
For file uploads, use base64 encoding:
```
data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQ...
data:application/pdf;base64,JVBERi0xLjQKJcOkw7zDssO...
```

## Grading System

- **A**: 90-100%
- **B**: 80-89%
- **C**: 70-79%
- **D**: 60-69%
- **E**: Below 60%

## Rate Limiting

API endpoints are rate limited to prevent abuse:
- Authentication endpoints: 5 requests per minute
- General endpoints: 60 requests per minute

## Pagination

Paginated responses include:
```json
{
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50
    }
}
```
