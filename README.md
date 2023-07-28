### LaraGram - Laravel Instagram Clone

![laragram banner](public/images/laragram.jpg)

> Laragram is a social media app like Instagram.

### Setup Instructions

> Clone this repository to your device and run this commands:

> Copy `.env.example` file to `.env`

```sh
cp .env.example .env
```

> Configure `.env` file with your own credentials

### With Docker
```sh
# give permission to the storage folder of the application
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# storage symlink
docker exec -it php /bin/sh -c "cd public && ln -s ../storage/app/public storage"

# start the docker containers
docker compose up

# to access the php container, use this command
docker exec -it php /bin/sh

    # install composer from the php container
    composer install
    
    # install npm packages
    npm install
    
    # build for production
    npm run build

    # generate the application key using the following command
    php artisan key:generate
    
    # migrate the tables to the database and seed fake data for testing
    php artisan migrate --seed

# check running docker containers status
docker compose ps

# shut down all running docker containers.
docker compose down
```

### Without Docker
```sh
composer install

npm install

php artisan key:generate

php artisan migrate

npm run dev

php artisan storage:link
```

### Some Screenshots

- Newsfeed
![newsfeed](public/images/screenshots/01-newsfeed.png)

- Explore
![expolore](public/images/screenshots/02-explore.png)

- Post Details
![post details](public/images/screenshots/03.1-post-details.png)

- Users list
![users list](public/images/screenshots/03.2-users-list.png)

- More menus
![More menus](public/images/screenshots/03.3-more-menus.png)

- Notifications
![Notifications](public/images/screenshots/04-notifications.png)

- Edit profile
![Edit profile](public/images/screenshots/05-edit-profile.png)

- Profile page
![Profile page](public/images/screenshots/06-profile-page.png)

- Wallet with SSLCommerz
![Wallet with SSLCommerz](public/images/screenshots/07-wallet-with-sslcommerz.png)

- Referral system
![Referral system](public/images/screenshots/08-referral-system.png)

- Chat
![Chat](public/images/screenshots/09-chat-1.png)

- Chat
![Chat](public/images/screenshots/10-chat-2.png)

- Follow email notification
![Follow email notification](public/images/screenshots/11-follow-email-notification.png)

- Usernames rules
![Usernames rules](public/images/screenshots/12-username-rules.png)

> If you like this app don't forget to give a star! ⭐ \
> Thank You!
