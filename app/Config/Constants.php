<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// custom
//SYSTEM CODES & MSG
define('SYSTEM_ERROR_CODE', 500);
define('SYSTEM_ERROR_MSG', 'Error! System Encountered an Error, Please try again');

define('EMAIL_NOT_FOUND', 'ENF');
define('EMAIL_NOT_FOUND_MSG', 'Email does not exists');

define('PASSWORD_INCORRECT', 'PASIC');
define('PASSWORD_INCORRECT_MSG', 'Password is not correct');

define('YOU_ARE_UNAUTHORIZED', 'URUN');
define('YOU_ARE_UNAUTHORIZED_MSG', 'You are Unauthorized to login');

//status
define('ACTIVE', 'Active');
define('PENDING', 'Pending');
define('INACTIVE', 'Inactive');
define('YES', 'Yes');
define('NO', 'No');

// OTP status
define('OTP_APPROVED', 'Approved');
define('OTP_PENDING', 'Pending');
define('OTP_REJECTED', 'Rejected');

//system codes
define('SYSTEM_ID', '-1');
define('SYSTEM_STATUS_CODE_SUCCESS', 200);
define('SYSTEM_STATUS_MESSAGE_SUCCESS', 'Process Completed Successfully');
define('SYSTEM_STATUS_CODE_FAILURE', 500);
define('SYSTEM_STATUS_MESSAGE_FAILURE', 'Unable to process the request, Please try again.');

// Users table constants
define('USERS_TABLE', 'users');
define('ROLES_TABLE', 'roles');
define('USER_ROLE_MAPPING_TABLE', 'user_role_mapping');
define('USER_DOCUMENTS_TABLE', 'user_documents');
define('USER_BANK_DETAILS_TABLE', 'user_bank_details');


////////// services ////////////
define('SERVICES_TABLE', 'services');
define('PRODUCTS_TABLE', 'products');
define('ITEMS_TABLE', 'items');
