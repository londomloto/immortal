<?php

function &modules() {
    static $modules = array();
    return $modules;
}

function add_module($name, $config = false) {
    $modules =& modules();
    $modules[$name] = $config;
}

/**
 * fungsi untuk mendapatkan module yang aktif saat ini
 */
function get_module($name) {
    $modules =& modules();
    return isset($modules[$name]) ? $modules[$name] : false;
}

function init_module($module) {

    $modpath = BASEPATH.'modules/'.$module.'/';
    
    if (is_dir($modpath)) {

        $modcfg = array(
            'name'     => $module,
            'path'     => $modpath,
            'validate' => 'user',
            'redirect' => 'login',
            'layout'   => 'main'
        );

        if (file_exists($modpath.'config.php')) {
            $config = include($modpath.'config.php');

            foreach($config as $key => $val) {
                $modcfg[$key] = $val;
            }
        }

        $modcfg = json_decode(json_encode($modcfg));

        add_module($module, $modcfg);

        if ($modcfg->validate) {
            if ( ! has_session($modcfg->validate)) {
                if (is_ajax()) {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'Sesi Anda telah habis !',
                        'redirect'=> site_url($modcfg->redirect)
                    ));
                    exit();
                } else {
                    redirect($modcfg->redirect);    
                }
            }
        }
    } else {
        show_404(sprintf(__("Page %s does not found!"), $module));
    }

    return get_module($module);
}