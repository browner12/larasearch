# Upgrading To v1

Before upgrading to v1, please ensure that you are running a minimum PHP version of 7.0, and a minimum Laravel version of 5.5. 

If you meet these requirements, please follow these simple steps to upgrade to v1.

+ Rename your `search.php` to `larasearch.php`. We have done this in an attempt to avoid possible collisions.
+ Add the `tubes` key to your `larasearch.php` config file. Copy and paste the value from this repo.
+ In your `app.php`, rename `browner12\larasearch\SearchServiceProvider` to `browner12\larasearch\LarasearchServiceProvider`. Alternatively, if you are using Laravel auto-discover, you can remove this value completely.

