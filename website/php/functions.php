<?php
/*
 * rsync -v -r -a ./ theseusd@theseus.dk:~/public_html/per
 * rsync --exclude '*_template' -v -r -a ./ theseusd@theseus.dk:~/public_html/per
 */

class View {
    protected $properties = array();

    public function render($template) {
        include(__DIR__ . '/'. $template);
    }

    public function __set($key, $value) {
        $this->properties[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->properties[$key]))
        {
            if (is_string($this->properties[$key]))
            {
                return  htmlspecialchars($this->properties[$key], ENT_QUOTES);
            }
            return $this->properties[$key];
        }
        return '';
    }
}

/**
 * page header
 */
function page_header($params)
{
    $view = new View();

    $view->title = $params['title'];
    $view->stylesheets = $params['stylesheets'];
    $view->use_math = $params['use_math'];
    $view->header = $params['header'];
    //$view->home = '~pmd/per';
    $view->home = 'per';

    $view->render('header.php');
}


/**
 * page footer
 */
function page_footer($sharing = false)
{
    $view = new View();
    date_default_timezone_set('Europe/Berlin');
    $view->year = date('Y');

    if ($sharing)
    {
       $view->render('footer.php');
    }

    if ($sharing)
    {
        $view->render('sharing.php');
    } 
}

