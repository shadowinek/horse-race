# horse-race
Horse Racing Simulator

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
