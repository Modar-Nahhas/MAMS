# MAMS
Mini article management system

# How to run for the first time
* You should create the database first
* Copy the .env.example to a .env file and put it in the main path of the project.
* Change the database configuration based on your local database.
* Set the email configurations, or the mails will be written to laravel log.
* Run the following command:
<pre>
composer install
php artisan migrate:fresh --seed
php artisan serve
</pre>
* The database will be seeded with an admin user:
<pre>
Email: admin@mams.com
Password: 12345678
</pre>
* To handle the jobs responsible for sending emails, run the following command:
<pre>
php artisan queue:work -v --queue=email_notification
</pre>
And to retry failed jobs, run the following command:
<pre>
php artisan queue:retry --queue=email_notification
</pre>

# Notes
* I am using a package create by me to implement filters, sorting, 
pagination, search, and loading relations. The link to this package:
[EasyApi](https://github.com/Modar-Nahhas/easy-api).</br>
I have used this package to implement the search functionality for articles.

* The search functionality for articles is in the index api using
the search query parameter.
* I did not implement the use of cache to fetch popular articles because
the business of determining the popular article is not clear. A popular article
could be implemented using how many times the article has been read, allow
the user to like the article thus the popular articles are the ones with
the highest number of like...etc. But I will describe how would I implement this
using cache in an abstract manner:
1. First, there most be a dedicated API that the client can call to
retrieve the popular articles.
2. In this API, I would retrieve the popular articles from the cache. 
I would be using the `rememberForever` function provided by the `Cache` 
facade.
3. The `rememberForever` takes a callback function as the second parameter.
Inside this callback function, I would call a static function defined in the
`Article` model called `getPopularArticles`. This function will implement
the business related to determine the popular articles.
4. The last step is to determine when to invalidate the cache for popular articles.
Based on the business used to tell the popular articles, lets say the
article that has the most number of likes is the most popular, I would 
invalidate the cache whenever a user call the like article API.
5. You can find the postman collection in a folder "Postman Collection" in project main path.

# Run the tests
I have created test cases for the main functionalities related to articles.
These functionalities are:
1. Retrieving a paginated response of the articles with their comments for guest users.
2. Retrieving a paginated response of the articles without their comments for guest users.
3. Creating new article by a logged-in user.
4. Updating an article by its owner.
5. Deleting an article by its owner.
6. Reviewing an article by an admin.
7. Approving an article by an admin.

To run the test, run the following command:
<pre>
php artisan test
</pre>

Note: I have configured the test to use `sqllite` driver `in memory` database.
I choose this so the tests won't affect the development database, or if
we were to run the tests in the production environment, the live database won't be affected.
