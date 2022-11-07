# Fabric Hiring Challenge

## Purpose
The purpose of this repo is to fulfill the hiring challenge that was set by Fabric

## Getting started
Please make sure the npm & composer packages are installed.
Next, please complete the .env `OMDB_API_KEY` field, at least - if you want to be extra, you may choose to fill in `OMDB_BASE_URL` and `OMDB_CACHE_TTL`, but those values already have defaults.

## Running
You may choose to run this app however you want, I just had a Laravel Valet instance with `npm run dev` in the background

## Tests
I wasn't sure what I wanted to test and I was kind of late with this assignment, so there are no tests. 
I did want to use Pest for backend testing and check wether the API returns usable data but let's just agree that it does actually return usable data.

## The task
Build an application using PHP Laravel with any Front End Framework of your choosing which has the following features:

-   3 button components which trigger API GET requests
    
-   A component that renders the API results in a presentable way
    

Clicking each button should fetch data using their own API URL (provided below). Once the data is fetched, you will need to store it in a local database.

If a record has a poster, you should store the poster in its own table and create a relevant relation to the record.

You should fetch data on the back-end.

You should only store unique data in the database.

Button 1 URL: http://www.omdbapi.com/?s=Matrix&apikey=redacted

Button 2 URL: http://www.omdbapi.com/?s=Matrix%20Reloaded&apikey=redacted

Button 3 URL: http://www.omdbapi.com/?s=Matrix%20Revolutions&apikey=redacted

You can use front-end libraries such as Bootstrap etc.

You will earn bonus points for testing your application and demonstrating architecture skills.