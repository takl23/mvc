# INTRO
![image](https://github.com/takl23/DV1608-V24-lp4/assets/142892946/9cbe7a78-5760-4048-9283-c4843385a9a1)

This repository is mainly for teaching purposes.

Repository created to learn web design, part of University course DV1608 V24 lp4 Objektorienterade webbteknologier at Tekniska högskolan Blekinge. More info about the course is found here: [MVC course](https://dbwebb.se/kurser/mvc-v2).

## CLONE REPO
Make sure that you have PHP 8.3 or higher and the latest version of composer.

- Stand in the directory where you want to download the repository.
- Use the command git clone https://github.com/takl23/DV1608-V24-lp4
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

      ![image](https://github.com/takl23/DV1608-V24-lp4/assets/142892946/7338fdaa-f150-446f-9d8b-4158f1af4413)
      
    - $ npm --version

      ![image](https://github.com/takl23/DV1608-V24-lp4/assets/142892946/938fee3c-e82f-4b62-817b-017ccc56f4bf)
- Make sure to stand in the directory of the repository and install following:
  - $ npm install --save-dev normalize.css sass stylelint stylelint-config-sass-guidelines
  - Verify that package.json contains following
    
    ![image](https://github.com/takl23/DV1608-V24-lp4/assets/142892946/74ec6b07-7a00-4a24-9574-910d7a8e145d)

  - Comands npm run style will update the style sheet and compile sass files into one css file