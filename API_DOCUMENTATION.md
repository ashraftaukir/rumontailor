# Tailor Backend API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

---

## Endpoints

### Authentication

#### Login
- **POST** `/api/login`
- **Body:**
  ```json
  {
    "email": "admin@example.com",
    "password": "password"
  }
  ```
- **Response:**
  ```json
  {
    "message": "Login successful",
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "1|..."
  }
  ```

#### Get Current User
- **GET** `/api/user`
- **Headers:** Authorization: Bearer {token}
- **Response:**
  ```json
  {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    }
  }
  ```

#### Logout
- **POST** `/api/logout`
- **Headers:** Authorization: Bearer {token}

---

### Dashboard

#### Get Dashboard Statistics
- **GET** `/api/dashboard`
- **Headers:** Authorization: Bearer {token}
- **Response:**
  ```json
  {
    "statistics": {
      "total_customers": 50,
      "total_orders": 100,
      "total_revenue": 69637.00,
      "average_order_value": 696.37,
      "pending_orders": 20,
      "in_progress_orders": 15,
      "completed_orders": 30,
      "delivered_orders": 35
    },
    "recent_orders": [...]
  }
  ```

---

### Customers

#### List Customers
- **GET** `/api/customers`
- **Query Parameters:**
  - `search` (optional): Search by name, email, phone, or address
  - `per_page` (optional): Items per page (default: 15)
- **Headers:** Authorization: Bearer {token}

#### Search Customers
- **GET** `/api/customers/search?query={search_term}`
- **Headers:** Authorization: Bearer {token}

#### Get Customer
- **GET** `/api/customers/{id}`
- **Headers:** Authorization: Bearer {token}

#### Create Customer
- **POST** `/api/customers`
- **Headers:** Authorization: Bearer {token}
- **Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "01712345678",
    "address": "Dhaka, Bangladesh"
  }
  ```

#### Update Customer
- **PUT/PATCH** `/api/customers/{id}`
- **Headers:** Authorization: Bearer {token}
- **Body:** Same as create

#### Delete Customer
- **DELETE** `/api/customers/{id}`
- **Headers:** Authorization: Bearer {token}

#### Get Customer Measurements
- **GET** `/api/customers/{id}/measurements`
- **Query Parameters:**
  - `garment_type` (optional): Filter by garment type (shirt, pant, suit). If not provided, returns all measurements.
- **Headers:** Authorization: Bearer {token}
- **Response:**
  ```json
  {
    "measurements": [
      {
        "id": 1,
        "customer_id": 1,
        "garment_type": "shirt",
        "chest": 38.5,
        "waist": 32.0,
        "shoulder_width": 17.5,
        "sleeve_length": 24.5,
        "shirt_length": 28.5,
        "neck": 15.0,
        "armhole": 18.5,
        "bicep": 12.5,
        "wrist": 7.5,
        "notes": null,
        "created_at": "2026-01-05T10:00:00.000000Z",
        "updated_at": "2026-01-05T10:00:00.000000Z"
      }
    ]
  }
  ```
- **Note:** When creating or updating an order, measurements are automatically saved to the customer's measurement profile for future use.

---

### Orders

#### List Orders
- **GET** `/api/orders`
- **Query Parameters:**
  - `search` (optional): Search by order number or customer
  - `status` (optional): Filter by status (pending, in_progress, completed, delivered, cancelled)
  - `garment_type` (optional): Filter by garment type (shirt, pant, suit)
  - `date_from` (optional): Filter orders from date (YYYY-MM-DD)
  - `date_to` (optional): Filter orders to date (YYYY-MM-DD)
  - `per_page` (optional): Items per page (default: 15)
- **Headers:** Authorization: Bearer {token}

#### Search Orders
- **GET** `/api/orders/search?query={search_term}`
- **Headers:** Authorization: Bearer {token}

#### Get Order
- **GET** `/api/orders/{id}`
- **Headers:** Authorization: Bearer {token}

#### Create Order
- **POST** `/api/orders`
- **Headers:** Authorization: Bearer {token}
- **Note:** When an order is created, measurements are automatically saved to the customer's measurement profile for future use. You can retrieve these measurements using `/api/customers/{id}/measurements`.
- **Body:**
  ```json
  {
    "customer_id": 1,
    "order_date": "2026-01-05",
    "status": "pending",
    "delivery_date": "2026-01-15",
    "description": "Order description",
    "notes": "Special notes",
    "items": [
      {
        "garment_type": "shirt",
        "price": 700.00,
        "description": "Custom shirt",
        "notes": "Special instructions",
        "chest": 38.5,
        "waist": 32.0,
        "shoulder_width": 17.5,
        "sleeve_length": 24.5,
        "shirt_length": 28.5,
        "neck": 15.0,
        "armhole": 18.5,
        "bicep": 12.5,
        "wrist": 7.5
      }
    ]
  }
  ```

#### Update Order
- **PUT/PATCH** `/api/orders/{id}`
- **Headers:** Authorization: Bearer {token}
- **Body:** Same as create (include item IDs for existing items)

#### Update Order Status
- **PATCH** `/api/orders/{id}/status`
- **Headers:** Authorization: Bearer {token}
- **Body:**
  ```json
  {
    "status": "in_progress"
  }
  ```

#### Delete Order
- **DELETE** `/api/orders/{id}`
- **Headers:** Authorization: Bearer {token}

---

### Reports

#### Get Full Reports
- **GET** `/api/reports`
- **Headers:** Authorization: Bearer {token}
- **Response:** Comprehensive report data including:
  - Overall statistics
  - Orders by status
  - Revenue by month (last 12 months)
  - Orders by month (last 12 months)
  - Top customers by revenue
  - Orders by garment type
  - Revenue growth metrics

#### Get Quick Statistics
- **GET** `/api/reports/statistics`
- **Headers:** Authorization: Bearer {token}
- **Response:** Quick statistics summary

---

## Measurement Fields by Garment Type

### Shirt
- chest, waist, shoulder_width, sleeve_length, shirt_length, neck, armhole, bicep, wrist

### Pant
- waist, hip, inseam, outseam, thigh, knee, ankle, pant_length

### Suit
- chest, waist, shoulder_width, sleeve_length, jacket_length, hip, inseam, outseam, thigh, knee, ankle, pant_length

---

## Error Responses

All errors follow this format:
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Error details"]
  }
}
```

**Status Codes:**
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Server Error

