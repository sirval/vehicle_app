# Vehicle Lookup

This repository contains a Laravel and React project that you can clone and install on your local machine.

## Prerequisites

Before getting started, ensure that you have the following softwares installed on your system:

- PHP (>= 8.1)
- Composer
- MySQL
- Git

## Clone the Repository

1. Open your terminal or command prompt.

2. Change to the directory where you want to clone the project.

3. Run the following command to clone the repository: `git clone https://github.com/sirval/vehicle_app.git`

## Installation

Follow these steps to set up and install the backend (Laravel) project:

1. Change into the project directory: `cd vehicle_app/vehicle_app_api`

2. Install the project dependencies using Composer: `composer install`

3. Run `cp .env.example .env`:

4. Generate an application key: `php artisan key:generate`

5. Generate an JWT Secret key: `php artisan jwt:secret`

6. Configure the app database connection in `.env` file with your database credentials:

`DB_DATABASE=`
`DB_USERNAME=`
`DB_PASSWORD=`

7. Run database migrations and seed tables: `php artisan migrate --seed`

Use these VIN for test purposes
`4F2YU09161KM33122`
`JT4RN81P1M5078565`
`1HGCM56743A101083`
`1G1JC124417321654`
`5N1AR18U98C652305`
`1NXBR32E37Z890212`

## Serving the project

- To start the server, run `php artisan serve`

- To maintain the project, run `php artisan down`

- To bring back project, run `php artisan up`

## Running Test

To run the PHPUnit test provided in this app

1. Run `php artisan test`
2. if all are set, you will see about 15 passed test as seen in the screenshot below.

<a href="https://raw.githubusercontent.com/sirval/vehicle_app/vehicle_app_api/public/files/test.png" target="_blank"><img src="https://raw.githubusercontent.com/sirval/vehicle_app/vehicle_app_api/public/files/test.png" /></a>



# Setting up the frontend

1. From the root directory of the clone git repo `vehicle_app` go to the frontend folder
2. Run `cd vehicle_app_www`
3. Make sure you have `Node 18.x` or use `nvm list` to see available node versions.
    If you wish to switch, you can use `nvm use your_node_version`
4. If all are set run `npm install` and then
5 `npm run dev` your project should be served at `http://localhost:5173/`


- If you wish to find out more, shoot me a mail ohukaiv@gmail.com



