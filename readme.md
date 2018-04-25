This is a WIP API for one of my upcoming projects TEMPS - a basic job site where users can create/apply to temporary 
jobs based on their role in the application

Written using the [Lumen](https://lumen.laravel.com/) framework


# Functions
Any user can:
- Sign-up as either staff or worker
- Login or logout (controlled via tokens)
- View all open jobs
- View a specific job

Staff users can:
- Create/update/delete a specific job
- View applications for a specific job
- View a specific application
- Respond to an application, with the option to automatically reject all other applications for the job in question

Worker users can:
- Create an application for a specific job, attaching their experience or education
- View their applications
- Create/update experience records
- Create/update education records



## Development commands
### Run local server
php -S localhost:8000 -t public

### Migrate and seed database
php artisan migrate --seed