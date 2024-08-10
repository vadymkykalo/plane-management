# Project Name

## Description

This project is a web-based management system for aircraft service requests and maintenance companies. The backend is built with Laravel, and the frontend is built using React.js. The project is containerized using Docker, ensuring a consistent development environment across different systems.

## Features

- Manage aircraft information, including model, serial number, and registration.
- Track service requests for aircraft, including priority, due date, and associated maintenance company.
- View and manage maintenance history for aircraft and companies.
- Soft-delete functionality for records.

## Prerequisites

- Docker and Docker Compose must be installed on your system.
- Basic knowledge of Docker, Laravel, and React.js is assumed.

## Installation and Setup

```bash
bash cli.sh setup 
```

This command will perform the following tasks:

* Build the Docker images.
* Install Composer dependencies.
* Set up the environment file and generate the application key.
* Update storage permissions.
* Run database migrations.
* Install NPM dependencies.

Additional Commands

The `cli.sh` script provides several commands to help manage your project:

* NPM Install: `./cli.sh npm-install` - Installs the NPM dependencies.
* Composer Install: `./cli.sh composer-install` - Installs the Composer dependencies.
* Migrate Database: `./cli.sh migrate` - Runs the database migrations.
* Load Database Seeds: `./cli.sh load-db` - Seeds the database with initial data.
* Run Artisan Commands: `./cli.sh artisan <command>` - Runs the specified Artisan command.
* Check Container Status: `./cli.sh ps` - Checks the status of the containers.
* Run test: `./cli.sh artisan test` - Run all test.

### Directory Structure

```plaintext
.
├── backend/            # Laravel application (backend)
├── frontend/           # React.js application (frontend)
├── docker-compose.yml  # Docker Compose file
├── Dockerfile          # Dockerfile for the backend
├── cli.sh              # CLI script for managing the project
└── README.md           # This README file
```

