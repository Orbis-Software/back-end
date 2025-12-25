# Job Management Module – Backend

**Candidate:** John Mark Bolongan  
**Role:** Full Stack Web Engineer  
**Context:** Transport Management System (TMS)

---

## Overview

This repository contains the **backend implementation** of a Job Management module for a freight forwarding Transport Management System.

The backend is the **single source of truth** for all business rules, data integrity, and financial correctness.  
UI behavior is treated as untrusted, and all critical rules are enforced server-side.

Detailed system design, architecture diagrams, and the ERD are documented externally.

📄 **Full backend documentation:**  
https://app.eraser.io/workspace/34W9JTGfJfQO3H5ZsmN9#XuDiPd0CiNKeFmw2uFH4B

---

## Responsibilities

The backend is responsible for:

- Job lifecycle enforcement (Draft → In Progress → Completed)
- Locking costs and revenue after job completion
- Append-only adjustments for post-completion corrections
- Soft deletes for audit and financial safety
- Derived financial calculations (totals and gross profit)
- Long-term data integrity under real operations

---

## Architecture

The backend follows a **layered Service–Repository architecture**:

- **Controllers** – HTTP orchestration only  
- **Services** – business rules and lifecycle control  
- **Repositories** – database persistence abstraction  
- **Resources** – API response shaping  

All business rules live in the service layer.

---

## Data Integrity Guarantees

- Completed jobs are immutable
- Financial records are never hard-deleted
- Adjustments preserve original financial history
- Profit is always derived, never stored
- Integrity cannot be bypassed by the UI

---

## Out of Scope

- Authentication and authorization
- Payment execution (Stripe, PayPal, checkout flows)
- UI and presentation concerns

---

## Running the Backend

```bash
composer install
cp .env.example .env
php artisan migrate --seed
php artisan serve
