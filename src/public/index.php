<?php

require_once '../../vendor/autoload.php';


$configuration = [
'settings' => [
'displayErrorDetails' => true,
],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);
$container = $app->getContainer();

$container['view'] = function ($container) {
    
    $view = new \Slim\Views\Twig('../templates', [
    // 'cache' => '../cache'
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    
    return $view;
};
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['view']->render($response->withStatus(404), '404.html', []);
    };
};

$app->get('/', function ($request, $respond, $args) {
    return $this->view->render($respond, "home.html", []);
});


// $app->get('/test', function ($request, $respond, $args) {
//     $time = encrypt(generateRandomString(10), ENCRYPTION_KEY);
//     return decrypt($time, ENCRYPTION_KEY);
// });

// $app->post('/test', function ($request, $respond, $args) {
//     if(!isset($_SERVER["HTTP_REFERER"])){
//         return 'nope';
//     }
//     if (getUrl().'/' != $_SERVER["HTTP_REFERER"]) {
//         return 'nope';
//     }
//     return 'ok';
// });

$app->get('/find-{id}', function ($request, $respond, $args) {
    header('Content-Type: application/json');
    return '{
        "status": true,
        "Sunday": [
        
        ],
        "Monday": {
            "1": {
                "code": "SE401",
                "section": "3171",
                "name": "Computer Network Security (LECT)",
                "time": "08.40 - 11.10",
                "room": "(RA4204)"
            },
            "2": {
                "code": "SE411",
                "section": "2531",
                "name": "Multimedia Technology (for SC, IT 5 (LECT)",
                "time": "14.00 - 16.30",
                "room": "(RB4505)"
            },
            "3": {
                "code": "SE401",
                "section": "3171",
                "name": "Computer Network Security (LECT)",
                "time": "12.00 - 14.00",
                "room": "(RA4204)"
            }
        },
        "Tuesday": {
            "1": {
                "code": "SE202",
                "section": "3191",
                "name": "Operating Systems (LECT)",
                "time": "14.00 - 16.30",
                "room": "(RB4603)"
            }
        },
        "Wednesday": {
            "1": {
                "code": "SE356",
                "section": "3191",
                "name": "Mobile Application Development I (LECT)",
                "time": "12.00 - 14.00",
                "room": "(RB4603)"
            }
        },
        "Thursday": {
            "1": {
                "code": "SE306",
                "section": "3911",
                "name": "Mobile App",
                "time": "08.40 - 11.10",
                "room": "(RB4603)"
            }
        },
        "Friday": {
            "1": {
                "code": "SE416",
                "section": "3199",
                "name": "Mobile Appl",
                "time": "14.00 - 16.30",
                "room": "(RB4603)"
            }
        },
        "Saturday": {
            "1": {
                "code": "SE401",
                "section": "3171",
                "name": "Computer Network Security (LECT)",
                "time": "08.40 - 11.10",
                "room": "(RA4204)"
            },
            "2": {
                "code": "SE411",
                "section": "2531",
                "name": "Multimedia Technology (for SC, IT 5 (LECT)",
                    "time": "14.00 - 16.30",
                "room": "(RB4505)"
            }
        }
    }';
});
function getUrl() {
    $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
    $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
    // $url .= $_SERVER["REQUEST_URI"];
    return $url;
}


// require_once 'fn.php';

$app->run();