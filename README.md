<!-- ** Password Strong Regex ** -->
regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
Should have At least one Uppercase letter.
At least one Lower case letter.
Also,At least one numeric value.
And, At least one special character.
Must be more than 8 characters long.

<!-- ** Laravel Captcha ** -->
use mews/captcha package
In LoginController I have to override validate methods to get that captcha working for Login Screen

<!-- ** To Setup Fresh Project ** -->
php artisan db:seed
-- This will re-generate all database structure
-- Also will create all user roles
-- Create one administrator, few managers and analyst
-- Default permissions will be assign to manager and analyst
-- Default conuntires and locations will be added
-- Default Report Templates layout management will be add

<!-- ** if we need to run specific data seeer ** -->
php artisan db:seed --class=UserSeeder

<!-- ** Mail Trap (On/Off) ** -->
-- Under mail configuration, if we want to turn off mail then Pretend should be true

<!-- Laravel Commands Used till now -->
php artisan module:make-controller {name} {module_name}  //to make controller in module
php artisan module:make-model {name} {module_name}  //to make model in module

<!-- Migration Commands -->
php artisan migrate  <!-- run new migration created -->
php artisan make:migration {migration_name} eg: create_global_keywords_table <!--To make migration-->
php artisan migrate --path=/database/migrations/test/

<!-- Auth Permission Commands -->
php artisan auth:permission  {name} <!--To create permission with view edit add delete-->
php artisan auth:permission {name} --remove <!--to delete permission with the name given -->

<!-- ** Seeder Commands ** -->
php artisan make:seeder {filename} //make a seeder class
php artisan db:seed //run all migration and its seeders alover again
php artisan db:seed --class={filename} //run single seeder file

<!-- Composer Commands -->
composer update //To update the composer with latest packages installed
<!-- In Case composer update doesn't run successfully due to php version collapse and packages dependency on php version
     Run the following commands which skip the php version requirement -->
composer install --ignore-platform-reqs   //skip php requirement and update composer
composer dump-autoload  //It just regenerates the list of all classes that need to be included in the project 

<!-- Config Commands -->
php artisan config:clear  //remove the configuration cache file
php artisan cache:forget spatie.permission.cache //to clear permissions cache

<!-- ** Laravel Commands Used till now ** -->

<!-- ** To Clean activity logs older than 365 days, setup command on server to run daily ** -->
php artisan activitylog:clean

<!-- ** Run Institute Report Automatic Crawl Script ** -->
cd Extract-PDF-Crawl-Script
source venv/bin/activate
cd pdf/spiders/
python ORM.py  # This command to be run only once which creates the db tables - pdf, proxy and url
cd /home/sfuser/Extract-PDF-Crawl-Script
scrapy crawl root -a use_proxies=false

<!-- ** Automatic ML engine result response get ** -->
SELECT count(*) as Total_Records, `deliver_status` as Status_Code FROM `tbl_results` group by `deliver_status`
UPDATE `tbl_results` SET `deliver_status`= NULL WHERE `deliver_status` = 400

<!-- ** Package for db seed importing excel ** -->
<!-- Step- 1 -->
composer update
composer require rap2hpoutre/fast-excel  
composer require doctrine/dbal
composer dump-autoload
<!-- Step- 2 -->
<!-- Include this in config/app.php under aliases -->
'FastExcel' => Rap2hpoutre\FastExcel\Facades\FastExcel::class


<!-- ** PDF TO TEXT Package ** -->
which pdftotext
If it is installed it will return the path to the binary. which you have to define as in constant

<!-- To install the binary you can use this command on Ubuntu or Debian: -->
apt-get install poppler-utils

<!-- On a mac you can install the binary using brew -->
brew install poppler 

<!-- If you're on RedHat or CentOS use this: -->
yum install poppler-utils


<!-- ** Independent scripts working in below directories ** -->
km - KnowledgeMap
Automatic Institute script crawl - Extract-PDF-Crawl-Script
twends - Twitter API

<!-- ** Command used to test html to pdf conversion  ** -->
/usr/local/bin/wkhtmltopdf --zoom .75  http://sf.mgdsw.info/pdf-pages-table/report-1.html example3.pdf

<!-- ** .env backup of developmetn server ** -->
/home/sfuser/env_original_20201004

<!-- ** Truncate all records from SCMA ** -->
TRUNCATE TABLE `tbl_sites`;
TRUNCATE TABLE `tbl_site_categories`;
TRUNCATE TABLE `tbl_categories`;
TRUNCATE TABLE `tbl_globals`;
TRUNCATE TABLE `tbl_topics`;
TRUNCATE TABLE `tbl_topic_categories`;

TRUNCATE TABLE `tbl_results`;
TRUNCATE TABLE `tbl_crawl_events`;
TRUNCATE TABLE `tbl_crawl_logs`;


<!------********* Installation to Staging Server *********** -----> 
Before doing steps, set the db migration as per required (User & permissions, MetaData, ReportTemplates)
1. Take pull of the latest Code
2. Make changes to env file
3. composer install or update
4. php artisan db:seed

In case facing any Permission issues in db seed
1. Try to clear cache with
    php artisan config:cache or php aritsan cache:clear, php aritsan config:clear
2. Try to clear permissions cache
    php artisan cache:forget spatie.permission.cache 

5. Give access to app/storage folder in order to prevent from file_put_contents failed to open stream permission denied error