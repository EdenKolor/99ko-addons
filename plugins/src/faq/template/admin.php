<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT . 'admin/header.php');

/*$faqItems = $faq->getItems();
var_dump($faqItems);

$faqItem4 = $faq->get(2);
var_dump($faqItem4);

$faqItem4->setPosition(2);
$faq->save($faqItem4);

$faqItems = $faq->getItems();
var_dump($faqItems);*/

?>

<?php
if ($mode === 'list') { ?>
<ul class="tabs_style">
    <li><a class="button" href="index.php?p=faq&amp;action=edit">Ajouter une question</a></li>
</ul>
<table>
    <thead>
        <tr>
            <th>Questions</th>
            <th>Affichage</th>
            <th>Edition</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($faq->getItems() as $faqItem) {
        if ($faqItem->isHidden !== 0) { ?>
        <tr>
            <td>
                <?php echo $faqItem->getQuestion();?>
                <div class="description">
					<?php echo $faqItem->getAnswer(); ?>
				</div>
            </td>
            <td>
            <?php
            if ($faqItem->isHidden()) { ?>
                <a href="index.php?p=faq&amp;action=show&amp;id=<?php echo $faqItem->getId();?>">
                    <img title="Afficher" alt="Afficher" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDUxMS42MjYgNTExLjYyNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTExLjYyNiA1MTEuNjI2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTUwNS45MTgsMjM2LjExN2MtMjYuNjUxLTQzLjU4Ny02Mi40ODUtNzguNjA5LTEwNy40OTctMTA1LjA2NWMtNDUuMDE1LTI2LjQ1Ny05Mi41NDktMzkuNjg3LTE0Mi42MDgtMzkuNjg3ICAgYy01MC4wNTksMC05Ny41OTUsMTMuMjI1LTE0Mi42MSwzOS42ODdDNjguMTg3LDE1Ny41MDgsMzIuMzU1LDE5Mi41Myw1LjcwOCwyMzYuMTE3QzEuOTAzLDI0Mi43NzgsMCwyNDkuMzQ1LDAsMjU1LjgxOCAgIGMwLDYuNDczLDEuOTAzLDEzLjA0LDUuNzA4LDE5LjY5OWMyNi42NDcsNDMuNTg5LDYyLjQ3OSw3OC42MTQsMTA3LjQ5NSwxMDUuMDY0YzQ1LjAxNSwyNi40Niw5Mi41NTEsMzkuNjgsMTQyLjYxLDM5LjY4ICAgYzUwLjA2LDAsOTcuNTk0LTEzLjE3NiwxNDIuNjA4LTM5LjUzNmM0NS4wMTItMjYuMzYxLDgwLjg1Mi02MS40MzIsMTA3LjQ5Ny0xMDUuMjA4YzMuODA2LTYuNjU5LDUuNzA4LTEzLjIyMyw1LjcwOC0xOS42OTkgICBDNTExLjYyNiwyNDkuMzQ1LDUwOS43MjQsMjQyLjc3OCw1MDUuOTE4LDIzNi4xMTd6IE0xOTQuNTY4LDE1OC4wM2MxNy4wMzQtMTcuMDM0LDM3LjQ0Ny0yNS41NTQsNjEuMjQyLTI1LjU1NCAgIGMzLjgwNSwwLDcuMDQzLDEuMzM2LDkuNzA5LDMuOTk5YzIuNjYyLDIuNjY0LDQsNS45MDEsNCw5LjcwN2MwLDMuODA5LTEuMzM4LDcuMDQ0LTMuOTk0LDkuNzA0ICAgYy0yLjY2MiwyLjY2Ny01LjkwMiwzLjk5OS05LjcwOCwzLjk5OWMtMTYuMzY4LDAtMzAuMzYyLDUuODA4LTQxLjk3MSwxNy40MTZjLTExLjYxMywxMS42MTUtMTcuNDE2LDI1LjYwMy0xNy40MTYsNDEuOTcxICAgYzAsMy44MTEtMS4zMzYsNy4wNDQtMy45OTksOS43MWMtMi42NjcsMi42NjgtNS45MDEsMy45OTktOS43MDcsMy45OTljLTMuODA5LDAtNy4wNDQtMS4zMzQtOS43MS0zLjk5OSAgIGMtMi42NjctMi42NjYtMy45OTktNS45MDMtMy45OTktOS43MUMxNjkuMDE1LDE5NS40ODIsMTc3LjUzNSwxNzUuMDY1LDE5NC41NjgsMTU4LjAzeiBNMzc5Ljg2NywzNDkuMDQgICBjLTM4LjE2NCwyMy4xMi03OS41MTQsMzQuNjg3LTEyNC4wNTQsMzQuNjg3Yy00NC41MzksMC04NS44ODktMTEuNTYtMTI0LjA1MS0zNC42ODdzLTY5LjkwMS01NC4yLTk1LjIxNS05My4yMjIgICBjMjguOTMxLTQ0LjkyMSw2NS4xOS03OC41MTgsMTA4Ljc3Ny0xMDAuNzgzYy0xMS42MSwxOS43OTItMTcuNDE3LDQxLjIwNy0xNy40MTcsNjQuMjM2YzAsMzUuMjE2LDEyLjUxNyw2NS4zMjksMzcuNTQ0LDkwLjM2MiAgIHM1NS4xNTEsMzcuNTQ0LDkwLjM2MiwzNy41NDRjMzUuMjE0LDAsNjUuMzI5LTEyLjUxOCw5MC4zNjItMzcuNTQ0czM3LjU0NS01NS4xNDYsMzcuNTQ1LTkwLjM2MiAgIGMwLTIzLjAyOS01LjgwOC00NC40NDctMTcuNDE5LTY0LjIzNmM0My41ODUsMjIuMjY1LDc5Ljg0Niw1NS44NjUsMTA4Ljc3NiwxMDAuNzgzQzQ0OS43NjcsMjk0Ljg0LDQxOC4wMzEsMzI1LjkxMywzNzkuODY3LDM0OS4wNCAgIHoiIGZpbGw9IiMwMDAwMDAiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                </a>
            <?php
            } else { ?>
                <a href="index.php?p=faq&amp;action=hide&amp;id=<?php echo $faqItem->getId();?>">
                    <img title="Cacher" alt="Cacher" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDUxMS42MjYgNTExLjYyNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTExLjYyNiA1MTEuNjI3OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTM2MS4xNjEsMjkxLjY1MmMxNS4wMzctMjEuNzk2LDIyLjU2LTQ1LjkyMiwyMi41Ni03Mi4zNzVjMC03LjQyMi0wLjc2LTE1LjQxNy0yLjI4Ni0yMy45ODRsLTc5LjkzOCwxNDMuMzIxICAgIEMzMjYuMjM1LDMyOS4xMDEsMzQ2LjEyNSwzMTMuNDM4LDM2MS4xNjEsMjkxLjY1MnoiIGZpbGw9IiMwMDAwMDAiLz4KCQk8cGF0aCBkPSJNMzcyLjg3Miw5NC4yMjFjMC4xOTEtMC4zNzgsMC4yOC0xLjIzNSwwLjI4LTIuNTY4YzAtMy4yMzctMS41MjItNS44MDItNC41NzEtNy43MTVjLTAuNTY4LTAuMzgtMi40MjMtMS40NzUtNS41NjgtMy4yODcgICAgYy0zLjEzOC0xLjgwNS02LjE0LTMuNTY3LTguOTg5LTUuMjgyYy0yLjg1NC0xLjcxMy01Ljk4OS0zLjQ3Mi05LjQyMi01LjI4Yy0zLjQyNi0xLjgwOS02LjM3NS0zLjI4NC04Ljg0Ni00LjQyNyAgICBjLTIuNDc5LTEuMTQxLTQuMTg5LTEuNzEzLTUuMTQxLTEuNzEzYy0zLjQyNiwwLTYuMDkyLDEuNTI1LTcuOTk0LDQuNTY5bC0xNS40MTMsMjcuNjk2Yy0xNy4zMTYtMy4yMzQtMzQuNDUxLTQuODU0LTUxLjM5MS00Ljg1NCAgICBjLTUxLjIwMSwwLTk4LjQwNCwxMi45NDYtMTQxLjYxMywzOC44MzFDNzAuOTk4LDE1Ni4wOCwzNC44MzYsMTkxLjM4NSw1LjcxMSwyMzYuMTE0QzEuOTAzLDI0Mi4wMTksMCwyNDguNTg2LDAsMjU1LjgxOSAgICBjMCw3LjIzMSwxLjkwMywxMy44MDEsNS43MTEsMTkuNjk4YzE2Ljc0OCwyNi4wNzMsMzYuNTkyLDQ5LjM5Niw1OS41MjgsNjkuOTQ5YzIyLjkzNiwyMC41NjEsNDguMDExLDM3LjAxOCw3NS4yMjksNDkuMzk2ICAgIGMtOC4zNzUsMTQuMjczLTEyLjU2MiwyMi41NTYtMTIuNTYyLDI0Ljg0MmMwLDMuNDI1LDEuNTI0LDYuMDg4LDQuNTcsNy45OWMyMy4yMTksMTMuMzI5LDM1Ljk3LDE5Ljk4NSwzOC4yNTYsMTkuOTg1ICAgIGMzLjQyMiwwLDYuMDg5LTEuNTI5LDcuOTkyLTQuNTc1bDEzLjk5LTI1LjQwNmMyMC4xNzctMzUuOTY3LDUwLjI0OC04OS45MzEsOTAuMjIyLTE2MS44NzggICAgQzMyMi45MDgsMTgzLjg3MSwzNTIuODg2LDEzMC4wMDUsMzcyLjg3Miw5NC4yMjF6IE0xNTguNDU2LDM2Mi44ODVDMTA4Ljk3LDM0MC42MTYsNjguMzMsMzA0LjkzLDM2LjU0NywyNTUuODIyICAgIGMyOC45MzEtNDQuOTIxLDY1LjE5LTc4LjUxOCwxMDguNzc3LTEwMC43ODNjLTExLjYxLDE5Ljc5Mi0xNy40MTcsNDEuMjA2LTE3LjQxNyw2NC4yMzdjMCwyMC4zNjUsNC42NjEsMzkuNjgsMTMuOTksNTcuOTU1ICAgIGM5LjMyNywxOC4yNzQsMjIuMjcsMzMuNCwzOC44Myw0NS4zOTJMMTU4LjQ1NiwzNjIuODg1eiBNMjY1LjUyNSwxNTUuODg3Yy0yLjY2MiwyLjY2Ny01LjkwNiwzLjk5OS05LjcxMiwzLjk5OSAgICBjLTE2LjM2OCwwLTMwLjM2MSw1LjgwOC00MS45NzEsMTcuNDE2Yy0xMS42MTMsMTEuNjE1LTE3LjQxNiwyNS42MDMtMTcuNDE2LDQxLjk3MWMwLDMuODExLTEuMzM2LDcuMDQ0LTMuOTk5LDkuNzEgICAgYy0yLjY2OCwyLjY2Ny01LjkwMiwzLjk5OS05LjcwNywzLjk5OWMtMy44MDksMC03LjA0NS0xLjMzNC05LjcxLTMuOTk5Yy0yLjY2Ny0yLjY2Ni0zLjk5OS01LjkwMy0zLjk5OS05LjcxICAgIGMwLTIzLjc5LDguNTItNDQuMjA2LDI1LjU1My02MS4yNDJjMTcuMDM0LTE3LjAzNCwzNy40NDctMjUuNTUzLDYxLjI0MS0yNS41NTNjMy44MDYsMCw3LjA0MywxLjMzNiw5LjcxMywzLjk5OSAgICBjMi42NjIsMi42NjQsMy45OTYsNS45MDEsMy45OTYsOS43MDdDMjY5LjUxNSwxNDkuOTkyLDI2OC4xODEsMTUzLjIyOCwyNjUuNTI1LDE1NS44ODd6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTUwNS45MTYsMjM2LjExNGMtMTAuODUzLTE4LjA4LTI0LjYwMy0zNS41OTQtNDEuMjU1LTUyLjUzNGMtMTYuNjQ2LTE2LjkzOS0zNC4wMjItMzEuNDk2LTUyLjEwNS00My42OGwtMTcuOTg3LDMxLjk3NyAgICBjMzEuNzg1LDIxLjg4OCw1OC42MjUsNDkuODcsODAuNTEsODMuOTM5Yy0yMy4wMjQsMzUuNzgyLTUxLjcyMyw2NS04Ni4wNyw4Ny42NDhjLTM0LjM1OCwyMi42NjEtNzEuNzEyLDM1LjY5My0xMTIuMDY1LDM5LjExNSAgICBsLTIxLjEyOSwzNy42ODhjNDIuMjU3LDAsODIuMTgtOS4wMzgsMTE5Ljc2OS0yNy4xMjFjMzcuNTktMTguMDc2LDcwLjY2OC00My40ODgsOTkuMjE2LTc2LjIyNSAgICBjMTMuMzIyLTE1LjQyMSwyMy42OTUtMjkuMjE5LDMxLjEyMS00MS40MDFjMy44MDYtNi40NzYsNS43MDgtMTMuMDQ2LDUuNzA4LTE5LjcwMiAgICBDNTExLjYyNiwyNDkuMTU3LDUwOS43MjQsMjQyLjU5LDUwNS45MTYsMjM2LjExNHoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                </a>
            <?php
            } ?>
            </td>
            <td>
                <a href="index.php?p=faq&amp;action=edit&amp;id=<?php echo $faqItem->getId();?>">
                    <img title="Editer" alt="Editer" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDUyOC44OTkgNTI4Ljg5OSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTI4Ljg5OSA1MjguODk5OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTMyOC44ODMsODkuMTI1bDEwNy41OSwxMDcuNTg5bC0yNzIuMzQsMjcyLjM0TDU2LjYwNCwzNjEuNDY1TDMyOC44ODMsODkuMTI1eiBNNTE4LjExMyw2My4xNzdsLTQ3Ljk4MS00Ny45ODEgICBjLTE4LjU0My0xOC41NDMtNDguNjUzLTE4LjU0My02Ny4yNTksMGwtNDUuOTYxLDQ1Ljk2MWwxMDcuNTksMTA3LjU5bDUzLjYxMS01My42MTEgICBDNTMyLjQ5NSwxMDAuNzUzLDUzMi40OTUsNzcuNTU5LDUxOC4xMTMsNjMuMTc3eiBNMC4zLDUxMi42OWMtMS45NTgsOC44MTIsNS45OTgsMTYuNzA4LDE0LjgxMSwxNC41NjVsMTE5Ljg5MS0yOS4wNjkgICBMMjcuNDczLDM5MC41OTdMMC4zLDUxMi42OXoiIGZpbGw9IiMwMDAwMDAiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                </a>
            </td>
        </tr>
    <?php
        }
    } ?>
    </tbody>
</table>
<?php
}

if ($mode === 'edit') {
    $currentId = $faqItem->getId();
?>
<form method="post" action="index.php?p=faq&amp;action=save">
    <?php show::adminTokenField(); ?>
    <input type="hidden" name="id" value="<?php echo $currentId; ?>" />
    <p>
        <label for="position">Position: </label>
        <select id="position" name="position">
            <option value="0">1: Au début</option>
        <?php
            $items = $faq->getItems();
            unset($items[$currentId]);
            $keys = array_keys($items);
            $selected = false;
            for ($i = 1; $i < count($keys); $i++) {
        ?>
            <option value="<?php echo $i;?>"<?php if($faqItem->getPosition() == $i) { echo ' selected'; $selected = true; }?>>
                <?php echo $i+1;?>: après '<?php echo $items["".$keys[$i-1].""]->getQuestion();?>'
            </option>
        <?php
            }
            if (count(keys) > 0) {
        ?>
            <option value="<?php echo count($keys);?>"<?php echo !$selected?' selected':'';?>><?php echo count($keys)+1;?>: A la fin</option>
        <?php
            } ?>
        </select>
    </p>
    <p>
        <label for="question">Question:</label>
        <input type="text" name="question" id="question" placeholder="Question à ajouter à la FAQ..." value="<?php echo $faqItem->getQuestion()?>">
    </p>
    <p>
        <label for="answer">Réponse:</label>
        <textarea name="answer" id="answer"><?php echo $faqItem->getAnswer()?></textarea>
    </p>
    <p>
      <button type="submit" class="button success radius">Enregistrer</button>
    </p>
</form>
<?php
} ?>

<?php include_once(ROOT . 'admin/footer.php'); ?>