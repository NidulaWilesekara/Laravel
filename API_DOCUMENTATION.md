# Laravel Posts API Documentation

This API allows users to manage their posts with authentication using Laravel Sanctum.

## Base URL
```
http://localhost:8000/api
```

## Authentication

### Register a new user
**POST** `/api/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    },
    "token": "1|abc123..."
}
```

### Login
**POST** `/api/login`

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
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "1|abc123..."
}
```

### Logout
**POST** `/api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Successfully logged out"
}
```

## Posts Endpoints

All posts endpoints require authentication. Include the token in the Authorization header:
```
Authorization: Bearer {token}
```

### Get all posts (for authenticated user)
**GET** `/api/posts`

**Response:**
```json
{
    "message": "Posts retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "My First Post",
            "content": "This is the content of my first post.",
            "image": "post_images/abc123.jpg",
            "image_url": "http://localhost:8000/storage/post_images/abc123.jpg",
            "user_id": 1,
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z"
        }
    ]
}
```

### Create a new post
**POST** `/api/posts`

**Request Body (multipart/form-data):**
```
title: My New Post
content: This is the content of my new post.
image: [file] (optional)
```

**Response:**
```json
{
    "message": "Post created successfully",
    "data": {
        "id": 2,
        "title": "My New Post",
        "content": "This is the content of my new post.",
        "image": "post_images/def456.jpg",
        "image_url": "http://localhost:8000/storage/post_images/def456.jpg",
        "user_id": 1,
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### Get a specific post
**GET** `/api/posts/{id}`

**Response:**
```json
{
    "message": "Post retrieved successfully",
    "data": {
        "id": 1,
        "title": "My First Post",
        "content": "This is the content of my first post.",
        "image": "post_images/abc123.jpg",
        "image_url": "http://localhost:8000/storage/post_images/abc123.jpg",
        "user_id": 1,
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### Update a post
**PUT** `/api/posts/{id}`

**Request Body (multipart/form-data):**
```
title: Updated Post Title
content: Updated content for the post.
image: [file] (optional)
remove_image: true (optional, to remove existing image)
```

**Response:**
```json
{
    "message": "Post updated successfully",
    "data": {
        "id": 1,
        "title": "Updated Post Title",
        "content": "Updated content for the post.",
        "image": "post_images/ghi789.jpg",
        "image_url": "http://localhost:8000/storage/post_images/ghi789.jpg",
        "user_id": 1,
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### Delete a post
**DELETE** `/api/posts/{id}`

**Response:**
```json
{
    "message": "Post deleted successfully"
}
```

## Error Responses

### Validation Error (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": ["The title field is required."],
        "content": ["The content field is required."]
    }
}
```

### Unauthorized (401)
```json
{
    "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
    "message": "Unauthorized access"
}
```

### Not Found (404)
```json
{
    "message": "No query results for model [App\\Models\\Post] {id}"
}
```

## Testing with cURL

### Register a user:
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login:
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Create a post (replace {token} with actual token):
```bash
curl -X POST http://localhost:8000/api/posts \
  -H "Authorization: Bearer {token}" \
  -F "title=My First Post" \
  -F "content=This is my first post content"
```

### Get all posts:
```bash
curl -X GET http://localhost:8000/api/posts \
  -H "Authorization: Bearer {token}"
```

## Testing with Postman

1. Set the base URL to `http://localhost:8000/api`
2. For authentication endpoints, use `Content-Type: application/json`
3. For post endpoints, use `multipart/form-data` for file uploads
4. Add the token to the Authorization header: `Bearer {token}` 