<?php
/**
 * HttpEcho is a simple web service that returns the request. It is useful to debug requests.
 *
 * @package HttpEcho
 * @category public
 * @author {@link http://florianeckerstorfer.com Florian Eckerstorfer}
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License v3
 */

set_include_path(__DIR__ . '/../library' . DIRECTORY_SEPARATOR . get_include_path());

/** @see Braincrafted\HttpEcho\HttpEcho */
require_once 'Braincrafted/HttpEcho/HttpEcho.php';

use Braincrafted\HttpEcho\HttpEcho;

$httpEcho = new HttpEcho($_SERVER, $_GET, $_POST, $_COOKIE);
header('Content-type: text');
echo $httpEcho->asText();
