<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="BOMA Logo">
</p>

# BOMA (Badan Olahraga Mahasiswa) - Integrated Campus & Commercial Sports Ecosystem

An enterprise-grade web application built with **Laravel 11** and **Tailwind CSS** designed to unify campus internal sports administration with a localized commercial sports venue marketplace.

---

## 📌 Executive Summary & Background
BOMA was originally conceived as an internal campus sports organization management system for Universitas Pendidikan Indonesia (UPI) Cibiru. Its foundational pillar was to streamline student club (UKM) registrations, manage internal activities, and coordinate routine athlete training sessions.

However, to ensure organizational sustainability and achieve financial independence—reducing reliance solely on campus budget allocations or student membership iuran—BOMA expanded its architectural scope by introducing a **Commercial Ecosystem Subsystem**.

### 💼 The Business Model & Synergy
This platform acts as a bridge connecting two distinct ecosystems:
1. **Campus Operations (Non-Profit):** Managing internal student sports clubs (UKM), scheduling training practices, and managing automated student registration rosters.
2. **Commercial Ecosystem (Profit-Driven):** A localized sports venue marketplace that facilitates private court owners (Mitra) across Bandung to list their active slots, allowing the general public and students to book courts digitally.

**The Financial Pipeline:** Every successful booking transaction processed through the platform incurs a dynamic marketplace commission fee. These generated funds are automatically channeled back into the BOMA treasury to independently fund campus athletic equipment, tournament registrations, and student-athlete development programs.

---

## 🚀 Key Features

### 🏛️ Campus Operations (Internal BOMA)
* **Student Verification Engine:** Validates active student profiles using academic identification data (NIM/KTM verification pipeline).
* **UKM Training Schedule Manager:** Allows BOMA Admins to create, update, and manage regular practice routines (Futsal, Basket, Badminton, etc.) with real-time capacity capping (`max_quota`).
* **Dynamic Student Roster:** Enables verified students to join or cancel practice slots seamlessly, dynamically managing attendance logs.

### 🏟️ Commercial Ecosystem (Marketplace & Core Business)
* **Mitra Venue Onboarding:** Dedicated portal for sports facility owners in Bandung to manage multi-court scheduling and hourly pricing structures.
* **Live Booking Monitor:** Real-time administrative event stream showing active and upcoming venue reservations.
* **Dispute Ticket & Emergency Override Console:** Allows Super Admins to perform immediate transactional reversals (*Force Cancel Override*) and handle refund procedures.

---

## 🛠️ Technology Stack
* **Backend Framework:** Laravel (PHP)
* **Frontend Styling:** Tailwind CSS
* **Database:** MySQL (Structured using Eloquent ORM abstractions)
* **State Management & UI Controls:** Native JavaScript / Blade Directives

---

## ⚙️ Local Installation & Setup

1. **Clone the Repository**
   ```bash
   git clone [https://github.com/LuthfilHadi02/Boma-App.git](https://github.com/LutgfilHadi02/Boma-App.git)
   cd Boma-App
