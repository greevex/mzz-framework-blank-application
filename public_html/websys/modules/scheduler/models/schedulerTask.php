<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/do.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 4004 2009-11-24 00:10:39Z mz $
 */

/**
 * schedulerTask
 * generated with mzz scaffolding
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerTask extends entity
{

    public function getCommand()
    {
        $command = parent::getCommand();

        if ($this->getType() == 3) {
            return $this->getTask($command);
        }
        return $command;
    }
    public function getStatusTitle()
    {
        switch ((int)$this->getStatus()) {
            case 0:
                return '<span style="color: gray">Не активно</span>';
            case 1:
                return '<span style="color: green">Активно</span>';
            case 2:
                return '<span style="color: gray;">Выполнено</span>';
            case 3:
                return '<span style="color: orange">В работе</span>';
            case -1:
                return '<span style="color: red;">Ошибка</span>';
        }
        return 'Неизвестно';
    }

    public function getTypeTitle()
    {
        switch ((int)$this->getType()) {
            case 1:
                return 'Внешн.';
            case 2:
                return 'Внутр.';
            case 3:
                return 'Задача';
        }
        return 'Неизвестно';
    }

    public function getStartDate($formatted = true)
    {
        $date = parent::getStartDate();
        if ($date == '0000-00-00' || empty($date)) {
            return '';
        }
        $date = new DateTime(parent::getStartDate());

        return $date->format('d/m/Y');
    }

    public function setStartDate($date)
    {
        $date = explode('/', $date);
        if (count($date) < 3) {
            return;
        }
        parent::setStartDate($date[2] . '-' . $date[1] . '-' . $date[0]);
    }

    public function getStartTime()
    {
        $time = parent::getStartTime();
        if (empty($time)) {
            return '';
        }
        return substr($time, 0, -3);
    }

    public function getMethodTitle()
    {
        switch ((int)$this->getMethod()) {
            case 1:
                return 'POST';
            case 2:
                return 'GET';
        }
        return '???';
    }

    /**
     *
     * @param boolean $subtask запустить подзадачу для основной задачи
     * @param boolean $force запускать задачу независимо от того, нужно ли ее запускать согласно настройкам
     * @return void
     */
    public function run($subtask = false, $force = false)
    {
        if (!$subtask && !$this->shouldBeRunned() && !$force) {
            return false;
        }

        logMe("Starting scheduled task {$this->getId()}..");
        $this->setRunning();

        $time = time();

        $run = "{$this->generateCommand()} && {$this->getCommandOnCompleted($this->getId())} &";

        $this->setLastExecution($time);

        if (!$subtask) {
            $this->mapper->save($this);
        }

        logMe('Executing a command: ' . $run);
        $respond = shell_exec($run);
        logMe("Executed task #{$this->getId()}: $respond");
    }

    public function runSubTask($command, $method, $parameters)
    {
        if (is_array($parameters)) {
            $parameters = json_encode($parameters);
        }
        $request = systemToolkit::getInstance()->getRequest();
        $command = 'http://' . $request->getServer('HTTP_HOST') . $command;
        $run = $this->buildCommand($command, $method, $parameters, true);
        logMe('Preparing to run an additional task: ' . $run);
        $respond = shell_exec($run);
        logMe("Executed additional task and got response: $respond");
    }

    public function setCompleted()
    {
        $this->setStatus(2);
    }

    public function setActive()
    {
        $this->setStatus(1);
    }

    public function setRunning()
    {
        $this->setStatus(3);
    }

    public function shouldBeRunned()
    {
        if ((int)$this->getStatus() !== 1) {
            return false;
        }

        $last_execution_date = date('d.m.Y', $this->getLastExecution());
        $start_time = $this->getStartTime();
        $start_date = $this->getStartDate();
        $interval = $this->getInterval();

        if (empty($start_time) && empty($start_date) && empty($interval)) {
            return true;
        }

        // by time
        if (!empty($start_time) && empty($start_date)) {
            if (date('d.m.Y') != $last_execution_date && $start_time < date('his')) {
                return true;
            }
            if (strpos($start_time, date('H:i')) === 0) {
                return true;
            }
        }

        // by date and interval
        if (!empty($interval) && !empty($start_date)) {
            if (date('d/m/Y') === $start_date && $this->getLastExecution() == '') {
                return true;
            }
            if (date('d/m/Y') === $start_date && time() - $this->getLastExecution() >= $interval * 60) {
                return true;
            }
            return false;
        }

        // by date
        if (empty($start_time) && !empty($start_date)) {
            if (date('d/m/Y') === $start_date) {
                return true;
            }
        }

        // by date and time
        if (!empty($start_time) && !empty($start_date)) {

            if (date('d/m/Y') === $start_date && strpos($start_time, date('H:i:')) === 0) {
                return true;
            } else {
                return false;
            }
        }

        // by interval
        if (!empty($interval)) {
            if ($this->getLastExecution() == '') {
                return true;
            }
            if (time() - $this->getLastExecution() >= $interval * 60) {
                return true;
            }
        }
    }

    private function getTask($command)
    {
        $processTaskMapper = systemToolkit::getInstance()->getMapper('process', 'processTask');
        return $processTaskMapper->searchByKey($command);
    }

    private function buildCommand($command, $method, $params, $add_token = false)
    {
        $token = systemToolkit::getInstance()->getRequest()->getString('token', SC_REQUEST);
        $data = json_decode($params, true);
        if (!is_array($data)) {
            $data = array();
        }
        $data['token'] = $token;
        $data = http_build_query($data);
        $run = "nohup curl -A \"Ultracenter\" -m 7200";

        if (((int)$method === 1 || strtolower($method) === 'post') && !empty($data)) {
            $run .= " -d \"{$data}\"";
        } else {
            $command = "\"{$command}?{$data}\"";
        }

        $run .= " {$command} > logs/task_{$this->getId()}_" . date("d-m-Y_H-i-s", time());
        logMe("Build a command for #{$this->getId()}: {$run}");
        return $run;
    }

    private function getCommandOnCompleted($id)
    {
        $completed = new url('withId');
        $completed->setAction('completedTask');
        $completed->setModule('scheduler');
        $completed->add('id', $id);
        $token = systemToolkit::getInstance()->getRequest()->getString('token', SC_REQUEST);

        return "nohup curl {$completed->get()}/?token={$token}";
    }

    private function generateCommand()
    {
        $request = systemToolkit::getInstance()->getRequest();
        if ((int)$this->getType() === 3) {
            $run = '';
            $task = $this->getCommand();
            foreach ($task->getChildTasks() as $child_task) {
                $run .= $this->buildCommand('http://' . $request->getServer('HTTP_HOST') . $child_task->getCommand(), $child_task->getMethod(), $child_task->getParameters()) . ' && ';
            }
            $run = substr($run, 0, -3);
        } else {
            if ((int)$this->getType() === 1) {
                $command  = $this->getCommand();
            } elseif ((int)$this->getType() !== 3) {
                $command = 'http://' . $request->getServer('HTTP_HOST') . $this->getCommand();
            }
            $run = $this->buildCommand($command, $this->getMethod(), $this->getParameters(), true);
        }

        return $run;
    }
}
?>