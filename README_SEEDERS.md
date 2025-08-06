# Database Seeders

This document explains the database seeders created for customers, posts, comments, and likes.

## Seeders Created

### 1. CustomerSeeder
- **File**: `database/seeders/CustomerSeeder.php`
- **Purpose**: Creates 30 customer users with random countries
- **Features**:
  - Arabic names for realistic data
  - Random country assignment
  - All customers have type 'customer'
  - Default password: 'password123'

### 2. PostSeederUpdated
- **File**: `database/seeders/PostSeederUpdated.php`
- **Purpose**: Creates 15 pharmaceutical posts for random customers
- **Features**:
  - Arabic descriptions for pharmaceutical products
  - Random assignment to customer users
  - Random cities and countries
  - Different post statuses (published/draft)
  - Realistic pricing and contact information

### 3. CommentSeeder
- **File**: `database/seeders/CommentSeeder.php`
- **Purpose**: Creates 2-5 comments for each post
- **Features**:
  - Arabic comments related to pharmaceutical products
  - Random customer assignment
  - Random timestamps (last 30 days)

### 4. LikeSeeder
- **File**: `database/seeders/LikeSeeder.php`
- **Purpose**: Creates likes for posts (30%-80% of users like each post)
- **Features**:
  - Realistic like distribution
  - Prevents duplicate likes
  - Random timestamps

## How to Run

### Option 1: Run All Seeders
```bash
php artisan db:seed
```

### Option 2: Run Individual Seeders
```bash
# Run in this order:
php artisan db:seed --class=CountriesSeeder
php artisan db:seed --class=DepartmentSeeder  
php artisan db:seed --class=CustomerSeeder
php artisan db:seed --class=PostSeederUpdated
php artisan db:seed --class=CommentSeeder
php artisan db:seed --class=LikeSeeder
```

### Option 3: Fresh Migration with Seeders
```bash
php artisan migrate:fresh --seed
```

## Dependencies

Make sure these seeders are run first:
1. `CountriesSeeder` - Required for customer countries
2. `DepartmentSeeder` - Required for post departments

## Updated DatabaseSeeder

The `DatabaseSeeder.php` has been updated to include all new seeders in the correct order:

```php
$this->call([
    CountriesSeeder::class,
    AdminSeeder::class,
    DepartmentSeeder::class,
    CustomerSeeder::class,
    PostSeederUpdated::class,
    CommentSeeder::class,
    LikeSeeder::class,
]);
```

## Data Created

- **30 customers** with random countries
- **15 pharmaceutical posts** assigned to random customers
- **30-75 comments** (2-5 per post) from random customers
- **Hundreds of likes** distributed across posts

All data includes Arabic content and realistic relationships between models.