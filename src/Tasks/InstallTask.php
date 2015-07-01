<?php

namespace Argentum88\Phad\Tasks;

use Phalcon\CLI\Task;

class InstallTask extends Task
{
    public function mainAction()
    {
        $projectRoot = __DIR__ . '/../../../../../';
        copy(__DIR__ . '/../../templates/phad-config.php', $projectRoot . 'phad-config.php');

        mkdir($projectRoot . 'phad', 0755);
        copy(__DIR__ . '/../../templates/phad.php', $projectRoot . 'phad/phad.php');

        $this->recurseCopy(__DIR__ . '/../../templates/backend-assets', $projectRoot . 'public');
        //copy(__DIR__ . '/../../templates/backend-assets', $projectRoot . 'public');
    }

    protected function recurseCopy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
