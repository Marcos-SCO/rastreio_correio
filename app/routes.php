<?php

// Custom router routes
$routes[] = ['/', 'Home@index'];
$routes[] = ['/usuario/{id}', 'Home@getUser'];