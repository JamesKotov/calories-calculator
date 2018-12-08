# Calories calculator

Test work for hireright, written in January, 2016.

## Task Description

### Task requirements:

Create a web interface to calculate the amount of calories a person is supposed to consume in a given day. It also should provide suggestions of how many calories that person must consume to lose weight while still remaining healthy.

The application should be based on the Harris Benedict Formula which bases intake on age, height, weight, gender, and exercise level.

### Additional Requirements:

- Single page web application which should use AJAX.
- Please, consider look and feel of application.

### Tasks deliverables:

- Source files.

## Solution

### Technical data

Bootstrap v3.3 used as CSS framwork to simplify page layout and get a standard design.

Angular.js v1.4 used as javascript framework. Main application logic is located at `calc.js` file.

PHP 5 used for server-side logiс. There are 2 files: `index.php`, for generate initial web-page, and `calc.php` for server handler for ajax requests. And `config.php` used to store configurable values for both other files.

And, of cource, you need any web server for serve static and php scripts. On my demo page I use Nginx.

### Demo

Demo available at http://test4.strigo.ru/
