# Plan Subscription System API Documentation

## Overview

The plan subscription system allows users to subscribe to different plans, manage their active subscriptions, and handle plan switching with user confirmation when they already have an active plan.

## Database Tables

### Plans Table
- `id` - Primary key
- `name` - Plan name
- `price` - Plan price (decimal)
- `duration_months` - Duration in months (integer)
- `description` - Plan description (text)
- `is_active` - Whether plan is active (boolean)
- Plan can have avatar images using Spatie Media Library

### User Plans Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `plan_id` - Foreign key to plans table
- `status` - Enum: 'active', 'cancelled', 'expired'
- `starts_at` - Plan start date
- `ends_at` - Plan end date
- `cancelled_at` - Cancellation date (nullable)

## API Endpoints

### Public Endpoints (No Authentication)

#### GET /api/plans
Get all available active plans.

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Basic Plan",
      "price": "29.99",
      "duration_months": 1,
      "description": "Perfect for individuals...",
      "avatar_url": null,
      "avatar_thumb_url": null
    }
  ]
}
```

#### GET /api/plans/{id}
Get specific plan details.

**Response:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "Basic Plan",
    "price": "29.99",
    "duration_months": 1,
    "description": "Perfect for individuals...",
    "avatar_url": null,
    "avatar_thumb_url": null,
    "active_subscriptions_count": 5
  }
}
```

### Protected Endpoints (Requires Authentication)

#### GET /api/user/plan-status
Get current user's plan status.

**Response (with active plan):**
```json
{
  "status": "active",
  "message": "You have an active plan.",
  "data": {
    "plan": {...},
    "user_plan": {...},
    "starts_at": "2025-08-05 11:34:22",
    "ends_at": "2025-09-05 11:34:22",
    "days_remaining": 30
  }
}
```

**Response (no plan):**
```json
{
  "status": "no_plan",
  "message": "You don't have an active plan.",
  "data": null
}
```

#### POST /api/user/subscribe
Subscribe to a plan.

**Request:**
```json
{
  "plan_id": 1
}
```

**Response (no existing plan):**
```json
{
  "status": "success",
  "message": "Successfully subscribed to the plan.",
  "data": {
    "user_plan": {...},
    "plan": {...}
  }
}
```

**Response (confirmation required):**
```json
{
  "status": "confirmation_required",
  "message": "You have an active plan that will be cancelled.",
  "data": {
    "current_plan": {
      "id": 1,
      "name": "Basic Plan",
      "ends_at": "2025-09-05 11:34:22"
    },
    "new_plan": {
      "id": 2,
      "name": "Premium Plan",
      "price": "79.99",
      "duration_months": 3
    }
  }
}
```

#### POST /api/user/confirm-subscription
Confirm plan subscription (cancels existing plan and subscribes to new one).

**Request:**
```json
{
  "plan_id": 2
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Successfully subscribed to the plan.",
  "data": {
    "user_plan": {...},
    "plan": {...}
  }
}
```

#### DELETE /api/user/cancel-plan
Cancel current active plan.

**Response:**
```json
{
  "status": "success",
  "message": "Plan cancelled successfully."
}
```

## Models and Relationships

### User Model
- `userPlans()` - HasMany relationship to UserPlan
- `activePlan()` - HasOne relationship to active UserPlan
- `hasActivePlan()` - Check if user has active plan
- `getCurrentPlan()` - Get current active plan
- `subscribeToPlan(Plan $plan, bool $cancelExisting = true)` - Subscribe to plan
- `cancelActivePlan()` - Cancel active plan

### Plan Model
- `userPlans()` - HasMany relationship to UserPlan
- `activeUserPlans()` - HasMany relationship to active UserPlans
- Avatar support using Spatie Media Library
- `active()` - Scope for active plans

### UserPlan Model
- `user()` - BelongsTo relationship to User
- `plan()` - BelongsTo relationship to Plan
- `isActive()` - Check if plan is currently active
- `isExpired()` - Check if plan has expired
- `cancel()` - Cancel the plan
- `activate()` - Activate the plan

## Plan Subscription Flow

1. **User subscribes to a plan:**
   - If no active plan exists → Subscribe immediately
   - If active plan exists → Ask for confirmation

2. **User confirms subscription:**
   - Cancel existing active plan
   - Subscribe to new plan
   - Set proper start/end dates

3. **Plan cancellation:**
   - Mark plan as 'cancelled'
   - Set cancelled_at timestamp
   - Plan remains in database for history

## Translation Keys

All messages use the translation key prefix `messages.plans.`:

- `active_plan_exists` - You have an active plan that will be cancelled.
- `subscription_successful` - Successfully subscribed to the plan.
- `subscription_failed` - Failed to subscribe to the plan.
- `no_active_plan` - You don't have an active plan.
- `cancellation_successful` - Plan cancelled successfully.
- `cancellation_failed` - Failed to cancel the plan.
- `plan_active` - You have an active plan.
- `confirmation_required` - Please confirm if you want to cancel your current plan and subscribe to the new one.

Translations are available in both English (`lang/en/messages.php`) and Arabic (`lang/ar/messages.php`).

## Sample Data

The system includes a seeder (`PlanSeeder`) that creates 4 sample plans:
- Basic Plan (1 month, $29.99)
- Premium Plan (3 months, $79.99)
- Professional Plan (6 months, $149.99)
- Enterprise Plan (12 months, $299.99)

Run the seeder with: `php artisan db:seed --class=PlanSeeder`

## Authentication

The protected endpoints use Laravel Sanctum for authentication. Include the authentication token in the Authorization header:

```
Authorization: Bearer your-api-token
```