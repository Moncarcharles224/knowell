# Use an official PHP image with Apache web server.
# This provides a complete environment to run your PHP application.
# We're using php:8.1-apache, which is a stable and widely used version.
FROM php:8.1-apache

# Set the working directory inside the container.
# This is the directory where Apache will serve files from.
WORKDIR /var/www/html

# Copy all the files from your project (the current directory on your computer)
# into the web root directory inside the container.
# The first '.' is the source (your project root), the second '.' is the destination.
COPY . .

# Expose port 80. This tells the container to listen on port 80,
# which is the standard port for web traffic.
EXPOSE 80
