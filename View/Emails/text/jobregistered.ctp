<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
echo $content;
?>
----------------------------------------------------------
German Version
----------------------------------------------------------
Guten Tag,
sie haben soeben eine Datei auf http://optipdf.de eingereicht.
Den aktuellen Status deiner Datei kannst du unter dem folgenden Link abrufen:
Status anzeigen: http://optipdf.de/status<?php echo DS.$data['id']."\n";?>
<?php echo "\n\n";?>
----------------------------------------------------------
English Version
----------------------------------------------------------
Good day,
you entered in a file at http://optipdf.de.
You can check the current status of your file following the link below:
Show status: http://optipdf.de/status<?php echo DS.$data['id']."\n";?>
----------------------------------------------------------
<?php echo "\n\n";?>