FROM php:8.1-apache

# Set the working directory to the web root.
# For an Apache base image, this is typically /var/www/html.
WORKDIR /var/www/index.php

# Copy all the application files from your repository into the container.
# The first dot (.) refers to the source directory (your repo root).
# The second dot (.) refers to the destination directory inside the container.
COPY . .

# Expose port 80 to the host, as Apache runs on this port by default.
EXPOSE 80
