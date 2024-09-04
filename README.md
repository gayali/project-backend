# Project Management System - Backend

![Project Management System Backend](https://img.shields.io/badge/Version-1.0.0-blue.svg)
![Node.js](https://img.shields.io/badge/Built%20with-Node.js-68a063.svg)
![Express.js](https://img.shields.io/badge/Built%20with-Express.js-000000.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## Table of Contents
- [About the Project](#about-the-project)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Documentation](#api-documentation)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## About the Project

This is the **Backend** for the **Project Management System** built using Node.js and Express.js. The backend serves as the API layer for the frontend application, providing endpoints for managing projects, tasks, and users. It also handles authentication, authorization, and data storage.

## Features

- **RESTful API:** Provides endpoints for managing projects, tasks, and users.
- **Authentication & Authorization:** Secure user authentication and role-based access control.
- **Database Integration:** Connects to a database for persistent storage of projects, tasks, and user data.
- **Error Handling & Logging:** Centralized error handling and logging for easy debugging and monitoring.

## Installation

To get started with the backend project locally, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/gayali/project-backend.git

2. **Navigate to the project directory:**
   ```bash
   cd project-backend

3. **Install dependencies:**
   ```bash
   composer install

## Configuration

Before running the backend server, you need to configure your environment variables. Follow these steps:

1. **Copy the `.env.example` file:**

   In the root directory of the project, you’ll find a file named `.env.example`. Copy this file and rename the copy to `.env`:

   ```bash
   cp .env.example .env

2.  **Update the `.env` file:**

    Open the newly created `.env` file and update the following environment variables with your database details:

    dotenv

    Copy code

    `DB_CONNECTION=mysql

    DB_HOST=127.0.0.1

    DB_PORT=3306

    DB_DATABASE=projects_backend

    DB_USERNAME=root

    DB_PASSWORD=`

    -   **DB_CONNECTION:** The database driver, set to `mysql` for MySQL databases.

    -   **DB_HOST:** The hostname where your database is hosted (typically `127.0.0.1` for local development).

    -   **DB_PORT:** The port on which your database is running (default is `3306` for MySQL).

    -   **DB_DATABASE:** The name of your database (e.g., `projects_backend`).

    -   **DB_USERNAME:** Your database username (e.g., `root`).

    -   **DB_PASSWORD:** Your database password (leave empty if none).

Ensure that the `.env` file is correctly configured before starting the server.


API Documentation
-----------------

The backend provides a RESTful API with the following endpoints:

-   **Authentication**

    -   `POST /api/auth/register` - Register a new user
    -   `POST /api/auth/login` - Login a user
-   **Projects**

    -   `GET /api/projects` - Get all projects
    -   `POST /api/projects` - Create a new project
    -   `PUT /api/projects/:id` - Update a project
    -   `DELETE /api/projects/:id` - Delete a project
-   **Tasks**

    -   `GET /api/projects/:projectId/tasks` - Get all tasks for a project
    -   `POST /api/projects/:projectId/tasks` - Create a new task
    -   `PUT /api/projects/:projectId/tasks/:taskId` - Update a task
    -   `DELETE /api/projects/:projectId/tasks/:taskId` - Delete a task
-   **Users**

    -   `GET /api/users` - Get all users
    -   `GET /api/users/:id` - Get a specific user
    -   `PUT /api/users/:id` - Update a user
    -   `DELETE /api/users/:id` - Delete a user
