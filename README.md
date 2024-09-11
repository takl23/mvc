# INTRO
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/takl23/mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/takl23/mvc/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/takl23/mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/takl23/mvc/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/takl23/mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/takl23/mvc/build-status/main)

[![Code Intelligence Status](https://scrutinizer-ci.com/g/takl23/mvc/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

![image](https://github.com/takl23/mvc/assets/142892946/6ede50bf-fef4-4834-a968-b2408c024424)

This repository is mainly for teaching purposes.

Repository created to learn web design, part of University course DV1608 V24 lp4 Objektorienterade webbteknologier at Tekniska högskolan Blekinge. More info about the course is found here: [MVC course](https://dbwebb.se/kurser/mvc-v2).

## CLONE REPO
Make sure that you have PHP 8.3 or higher and the latest version of composer.

- Stand in the directory where you want to download the repository.
- Clone the repository using the following command:
  ```bash
   git clone https://github.com/takl23/mvc
  ```
- Make sure to stand in the directory of the repository and install following:
  ```bash
  composer install
  npm install
  npm run build
  ```
 To use SASS for styling following is required to have installed.
  - **Node.js** according to [download page Node](https://nodejs.org/en/download/).
    - If using windows Node installation is required both on the mashine and in the client.
  - **npm** is required
  - Check versions in terminal to verify that its working.
    ```bash
    node --version
    npm --version
    ```
- Make sure to stand in the directory of the repository and install following:
  ```bash
  npm install --save-dev normalize.css sass stylelint stylelint-config-sass-guidelines
  ```
  - Verify that package.json contains following
    
    ![image](https://github.com/takl23/mvc/assets/142892946/f0086fa5-32a1-4203-9b52-606f65690811)

  - Run the following command to update the stylesheet and compile SASS files into one CSS file:
  ```bash
  npm run style
  ```
## INCLUDED TOOLS

This project uses several tools to ensure code quality, testing, and documentation. These tools are installed via Composer and npm:

### PHP Tools (via Composer)

- **PHPUnit**: Run unit tests.
- **PHPStan**: Static code analysis to identify bugs and improve code quality.
- **PHP CS Fixer**: Automatically fix code style issues.
- **PHP Metrics**: Analyze code complexity and generate metrics.
- **PHPDoc**: Generate project documentation.
- **PHPMD (PHP Mess Detector)**: Detect potential problems in the code, such as bad practices and security issues.

### Node.js/NPM Tools

- **SASS**: Compile SASS files into CSS.
- **Stylelint**: Ensure consistent code style in CSS/SASS files.

## HOW TO RUN THE TOOLS

### Composer-based Tools

The tools can be run using the following Composer scripts:

- **PHPUnit**: `composer phpunit`
- **PHPStan**: `composer phpstan`
- **PHP CS Fixer**: `composer csfix`
- **PHP Metrics**: `composer phpmetrics`
- **PHPDoc**: `composer phpdoc`
- **PHPMD**: `composer phpmd`

### npm-based Tools

- **Install Node modules**: `npm install`
- **Build frontend resources**: `npm run build`
- **Compile SASS to CSS**: `npm run style`

## CONTINUOUS INTEGRATION
In my project I have also integrated with Scrutinizer for continuous code review and quality assessment.

### Setting Up Scrutinizer
To integrate Scrutinizer for automated code review, follow these steps:

- **Install Scrutinizer**: Create an account on [Scrutinizer](https://scrutinizer-ci.com/) and link your GitHub repository.

- **Add Scrutinizer Configuration**: Automatically download and add the configuration file by running the following command in the root directory of your project:

   ```bash
   curl -s https://raw.githubusercontent.com/dbwebb-se/mvc/main/example/scrutinizer/.scrutinizer.yml > .scrutinizer.yml
   ```

   This command will fetch a sample `.scrutinizer.yml` file and save it in your project, allowing Scrutinizer to run analyses on your project.

3. **Activate and Run Scrutinizer**: Once the configuration file is in place and your repository is linked, Scrutinizer will automatically run analyses each time you push changes to GitHub.

For more detailed instructions on setting up Scrutinizer, visit the [Scrutinizer example in the MVC course](https://github.com/dbwebb-se/mvc/tree/main/example/scrutinizer).



  
