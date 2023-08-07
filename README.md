## Basic Laravel 10 (Blade & JQuery) applicaiton for Project Task Management
# Requirement
- Create task (info to save: task name, priority, timestamps)
- Edit task
- Delete task
- Reorder tasks with drag and drop in the browser. Priority should automatically be updated based on this. #1 priority goes at top, #2 next down and so on.
Tasks should be saved to a mysql table.
BONUS POINT: add project functionality to the tasks. User should be able to select a project from a dropdown and only view tasks associated with that project.

# How to run
 - Create your mysql db and configure appropriately .env 
 - Install composer and npm packages
 - Artisan migrate project
 - Run: npm run dev & artisan serve
 - Visit application url to register new user
 - Have fun with application