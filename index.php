<?php

namespace shgysk8zer0\Calendar;

spl_autoload_register('spl_autoload');
set_include_path(dirname(__DIR__, 2));

require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

echo Functions\get_page(__NAMESPACE__);
