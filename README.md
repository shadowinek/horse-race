# Horse Racing Simulator

### Setup

1. Get the source code
    ```
    git clone git@github.com:shadowinek/horse-race.git
    ```

2. Create local config file
    ```
    cp .env.example .env
    ```

3. Set your `APP_KEY` and database connection in the `.env` file

4. Install the app dependencies
    
    ```
    composer install
    ```
    
5. Run migrations
    ```
    php artisan migrate
    ```

6. Run your local server
    ```
    php -S localhost:8000 -t public
    ```
    
7. Open the app in your browser and enjoy

### Notes/Diary 
##### 03.10.2019 0:15
- I played around the math and the first functions for the horse calculations.
- The first idea is to not save the race progress, but to calculate it on fly for every view.
- Implementation will be probably done in Lumen.
- Open questions:
  - How to recognize/mark when the race is finished?

##### 03.10.2019 11:35
- Added base migrations and base classes
- Working on the horse repository to randomly generate horses
- On the horse creation I will calculate the final time and final step when the horse finish the race. This will allow me to mark the final step of the race and by the comparison, I can decide if the race is finished or not.
- All floats will be saved as integers and divided by 10 afterwards.
- TODO:
  - remove not needed files from Lumen

##### 03.10.2019 15:40
- Functionality is finished
- TODO:
  - Improve the look
  - Add pages for Race and Horse
  - Add comments
  - Extract time format function into helper function 

##### 03.10.2019 17:30
- I am out of time, but the task is finished
- Added documentation
- What is missing:
  - There are no tests. At least the calculation should be covered with tests
  - There are no visible validations. But I consider this ok as far as there are no user value inputs.
- Challenges:
  - I wanted to avoid saving floats into the DB, but the calculations are less clear because of this.
  - I have config file for the given restrictions, but the app is not really configurable, when there are already data in the DB. The old data would be broken when I would change the values.
