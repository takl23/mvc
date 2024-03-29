# INTRO
![image](https://github.com/takl23/mvc/assets/142892946/6ede50bf-fef4-4834-a968-b2408c024424)

This repository is mainly for teaching purposes.

Repository created to learn web design, part of University course DV1608 V24 lp4 Objektorienterade webbteknologier at Tekniska högskolan Blekinge. More info about the course is found here: [MVC course](https://dbwebb.se/kurser/mvc-v2).

## CLONE REPO
Make sure that you have PHP 8.3 or higher and the latest version of composer.

- Stand in the directory where you want to download the repository.
- Use the command git clone https://github.com/takl23/mvc
- Make sure to stand in the directory of the repository and install following:
  - composer install
  - npm install
  - npm run build

 To use SASS for styling following is required to have installed.
  - node according to [download page Node](https://nodejs.org/en/download/).
    - If using windows Node installation is required both on the mashine and in the client.
  - npm is required
  - Check versions in terminal to verify that its working.
    - $ node --version

      ![image](https://github.com/takl23/mvc/assets/142892946/63027a75-6ee7-4201-97c6-f807cef300db)
      
    - $ npm --version

      ![image](https://github.com/takl23/mvc/assets/142892946/08db93e5-2b1c-4ca6-9eab-2710f25932b7)
- Make sure to stand in the directory of the repository and install following:
  - $ npm install --save-dev normalize.css sass stylelint stylelint-config-sass-guidelines
  - Verify that package.json contains following
    
    ![image](https://github.com/takl23/mvc/assets/142892946/f0086fa5-32a1-4203-9b52-606f65690811)

  - Comands npm run style will update the style sheet and compile sass files into one css file
