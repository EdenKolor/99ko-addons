<?php

defined('ROOT') OR exit('No direct script access allowed');

$action = (isset($_GET['action'])) ? urldecode($_GET['action']) : '';
$id = (isset($_GET['id'])) ? intval($_GET['id']) : null;
$msg = (isset($_GET['msg'])) ? urldecode($_GET['msg']) : '';
$error = false;
$faq = new faq();

switch ($action) {
    case 'save':
        if($administrator->isAuthorized()){
			if (isset($_POST['id']) && $_POST['id'] !== '') {
                if (false === $faqItem = $faq->get(intval($_POST['id']))) {
                    $faqItem = new faqItem();
                    $new = true;
                }
                $new = false;
            } else {
                $faqItem = new faqItem();
                $new = true;
            }
            //var_dump($_POST);
            //var_dump($faqItem); exit;
			$faqItem->setPosition(intval($_POST['position']));
			$faqItem->setQuestion(htmlentities($_POST['question']));
			$faqItem->setAnswer(htmlentities($_POST['answer']));

            //var_dump($faqItem); exit;

			if($faq->save($faqItem)){
                if ($new) {
                    $msg = "La nouvelle question est enregistrée !";
                } else {
                    $msg = "Les modifications ont été enregistrées";
                }
			} else {
				$msg = "Une erreur est survenue";
			}
			header('location:index.php?p=faq&msg='.urlencode($msg));
			die();
		}
        break;
    case 'edit':
        $mode = 'edit';
        if ($id !== null) {
            if (false === $faqItem = $faq->get($id)) {
                $faqItem = new faqItem();
            }
        } else {
            $faqItem = new faqItem();
        }
        break;
    case 'show':
        $mode = 'list';
        $msg = 'La question est maintenant visible !';
        $faqItem = $faq->get($id);
        $faqItem->setHidden(0);
        $faq->save($faqItem);
        break;
    case 'hide':
        $mode = 'list';
        $msg = 'La question est maintenant invisible !';
        $faqItem = $faq->get($id);
        $faqItem->setHidden(1);
        $faq->save($faqItem);
        break;
    default:
        // nothing
        $mode = 'list';
        if ($msg == '') {
            $msg = 'Version BÊTA : en cours de développement...';
        }
        break;
}


?>