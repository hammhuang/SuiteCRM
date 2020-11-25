<?php

namespace SuiteCRM\Custom\Robo\Plugin\Commands;

use Robo\Task\Base\loadTasks;
use Exception;
use RepairAndClear;
use LanguageManager;

class RepairCommands extends \Robo\Tasks
{

    use loadTasks;

    /**
     * Run quick repair and rebuild command line
     */
    public function repairQuickRepairAndRebuild()
    {
        $this->say("qucik repair and rebuild");
        require_once __DIR__ . '/../../../../../modules/Administration/QuickRepairAndRebuild.php';
        global $current_user;
        $current_user->is_admin = '1';
        $tool = new RepairAndClear();
        $tool->repairAndClearAll(array('clearAll'), array(translate('LBL_ALL_MODULES')), true, false, '');
        // remove the js language files
        LanguageManager::removeJSLanguageFiles();
        // remove language cache files
        LanguageManager::clearLanguageCache();

        $this->say('already rebuilt!');
    }
}
