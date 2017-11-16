<?php

defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? urldecode($_GET['action']) : '';
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$error = false;

switch ($action) {
    case 'change':
        // change le theme
        $theme = isset($_REQUEST['enable']) ? array_keys($_REQUEST['enable'])[0] : 'default';
        $core->saveConfig(array('theme' => $theme));
        $msg = 'le thème a bien été sauvegardé !';
        break;
    case 'upload':
        if ('success' === $output = install_theme()) {
            $msg = 'Thème installé correctement !';
        } else {
            $msg = "Erreur lors de l'installation du thème : $output";
        }
        break;
    default:
        // nothing
        if ($msg == '') {
            $msg = 'version bêta : en cours de développement...';
        }
        break;
}


?>