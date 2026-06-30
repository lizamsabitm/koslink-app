# KosLink — Boarding House Rental Platform

A full-stack web application that connects boarding house (kos) owners with prospective tenants, featuring search & filtering, online booking, and payment proof verification — built with Laravel.

![Laravel](https://img.shields.io/badge/Laravel-Framework-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql)
![Status](https://img.shields.io/badge/Status-Deployed-success)

**Live Demo** — *https://koslink-app.onrender.com/*

---

## Problem Statement

Finding a boarding house in Indonesia is still largely word-of-mouth or limited to physical flyers — slow, unstructured, and hard to compare. Meanwhile, kos owners struggle to market their properties beyond a small local radius. KosLink bridges this gap with a centralized platform where tenants can search by location, price, and facilities, while owners manage their listings and bookings digitally.

---

## Key Features

| Role | Capabilities |
|------|-------------|
| **Tenant** | Search & filter kos by location/price, view detailed listings, submit booking requests, upload payment proof, view booking history, leave reviews |
| **Owner** | Manage property listings, track incoming bookings, manage bank account for payments, update room availability |
| **Admin** | Verify new kos listings, manage user accounts, monitor all transactions, moderate content |

---

## Preview

### Tenant Dashboard
![Dashboard Penyewa](public/image/dashboardpenyewa.png)

### Owner Dashboard
![Dashboard Pemilik](public/image/dashboardpemilik.png)

### Admin Dashboard
![Dashboard Admin](public/image/dashboardadmin.png)

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel (PHP), MVC Architecture |
| Frontend | HTML, CSS, JavaScript, Bootstrap, Blade Templating |
| Authentication | Laravel Breeze |
| Database | MySQL |
| Map Integration | Leaflet.js |
| Deployment | Render |

---

## Development Approach

This project was built using a **Prototyping** methodology — starting with wireframes and GUI mockups based on identified user needs, followed by iterative coding and feature refinement based on internal testing and evaluation.

---

## System Architecture

```
User (Tenant / Owner / Admin)
        ↓
   Web Browser
        ↓
Frontend (Blade + Bootstrap + JS)
        ↓
Backend (Laravel Controllers & Middleware)
        ↓
MySQL Database
        ↓
External Services (Leaflet Maps API, Payment Proof Upload)
```

Routes are protected with Laravel Middleware, ensuring tenants, owners, and admins can only access pages relevant to their role.

---

## Notable Implementation Details

**Multi-level authentication** — Role-based access control via middleware, separating Admin, Owner, and Tenant dashboards.

**Smart search & filtering** — Keyword search uses partial text matching, while price filtering uses `whereHas` to query through the related `rooms` table (since pricing lives at the room level, not the boarding house level). Results are deduplicated using `distinct()` when sorted by price across joined tables.

**Server-side price calculation** — Total booking price is calculated entirely on the backend by multiplying the room's database price with the requested duration, preventing price manipulation from the client side.

**Real-time stock management** — Room availability decrements immediately upon booking creation to prevent double bookings.

**Secure file uploads** — Payment proof uploads are validated for file type (image only) and size (max 2MB), and scoped to the authenticated user to prevent cross-account access.

---

## Future Improvements

- Real-time booking & payment status notifications
- E-wallet payment gateway integration
- Mobile application version
- Algorithm-based review credibility scoring
