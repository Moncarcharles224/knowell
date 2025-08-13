# Use an official PHP image with Apache web server.
# This provides a complete environment to run your PHP application.
# We're using php:8.1-apache, which is a stable and widely used version.
FROM php:8.1-apache

# Set the working directory inside the container.
# This is the directory where Apache will serve files from.
WORKDIR /var/www/html

# Copy all the files from your project (the current directory on your computer)
# into the web root directory inside the container.
COPY . .

# This is the key change to fix the "Forbidden" error.
# The 'chown' command changes the ownership of all files and directories
# inside /var/www/html to the 'www-data' user and group, which is
# the user that the Apache server runs as inside this container.
RUN chown -R www-data:www-data /var/www/html

# Expose port 80. This tells the container to listen on port 80,
# which is the standard port for web traffic.
EXPOSE 80
