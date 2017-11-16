<?php
defined('ROOT') OR exit('No direct script access allowed');
include_once(ROOT . 'admin/header.php');
?>
<form enctype="multipart/form-data" method="post" action="index.php?p=customizer&action=upload" id="uploadForm">
    <p><label>Installer un thème: <input type="file" name="zip_file"></label><input type="submit" name="submit" value="Installer"></p>
</form>
<br><br>
<form method="post" action="index.php?p=customizer&action=change" id="customizerForm">
    <?php show::adminTokenField(); ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Auteur</th>
                <th>Version</th>
                <th>Tester</th>
                <th>Activer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($core->getThemes() as $name => $info) { ?>
                <tr>
                    <td>
                        <strong><?php echo $info['name']; ?></strong>
                    </td>
                    <td>
                        <?php echo isset($info['author']) ? $info['author'] : 'NC'; ?>
                    </td>
                    <td>
                        <?php echo isset($info['version']) && $info['version'] !== 'none' ? $info['version'] : 'NC'; ?>
                    </td>
                    <td>
                        <a target="_blank" href="<?php echo $core->getConfigVal('siteUrl') . '/?theme=' . $name; ?>">
                            <img src="<?php echo ROOT . 'plugin/page/template/link.png'; ?>" title="Actif" alt="Actif">
                        </a>
                    </td>
                    <td>
                        <?php if ($name != $core->getConfigVal('theme')) { ?>
                            <input onchange="document.getElementById('customizerForm').submit();" id="enable[<?php echo $name; ?>]" type="checkbox" name="enable[<?php echo $name; ?>]">
                        <?php } else { ?>
                            <img src="<?php echo ROOT . 'plugin/page/template/star.png'; ?>" title="Actif" alt="Actif">
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</form>

<?php include_once(ROOT . 'admin/footer.php'); ?>