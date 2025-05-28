<?php

namespace HisInOneProxy\Database;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;

class DBUpdate
{
    const CFG_UPDATE_INFO_PHP = 'cfg_update_info.php';
    const CFG_UPDATE_RUNNING_PHP = 'cfg_update_running.php';
    private string $DB_UPDATE_FILE;

    private ?int $currentVersion = null;

    private string $fileVersion;
    private array|false $filecontent;
    private Log $log;
    private string $current_file;
    private $db;
    private ?\PDO $pdo;
    private string $path;
    private $lastfilecontent = [];
    private string|array $updateMsg;
    /**
     * @var int|mixed
     */
    private int $db_update_running = 0;
    /**
     * @var mixed|string|true
     */
    private mixed $error;

    /**
     * constructor
     * @throws \Exception
     */
    public function __construct()
    {
       /* $this->log = new Log();

*/
        require_once './libs/composer/vendor/autoload.php';
        $this->path = "src/Database/";

        $this->initializeConnection();
        $update_file = $this->getFileForStep();
        $this->current_file = $update_file;
        $this->DB_UPDATE_FILE = $this->path."sql/".$update_file;
        $this->checkForExistingFiles();
        $this->readDBUpdateFile();
        $file_version = $this->readFileVersion();
        $current_version = $this->getCurrentVersion();

    }

    /**
     * @throws \Exception
     */
    private function initializeConnection()
    {
        $host = GlobalSettings::getInstance()->getDatabaseHost();
        $name = GlobalSettings::getInstance()->getDatabaseDbname();
        $user = GlobalSettings::getInstance()->getDatabaseUser();
        $pass = GlobalSettings::getInstance()->getDatabasePass();
        $connection = new DbPdo($host, $name, $user, $pass);
        $this->pdo = $connection->getPdo();
        $GLOBALS['DBPDO'] = $connection->getDbPdo();
    }

    private function getFileForStep()
    {
        return "dbupdate.php";
    }

    private function initStep($i)
    {
        //
    }

    private function readDBUpdateFile()
    {
        if (!file_exists($this->DB_UPDATE_FILE))
        {
            $this->log->error('No db update file found.');
            $this->filecontent = [];
            return false;
        }

        $this->filecontent = @file($this->DB_UPDATE_FILE);
        return true;
    }

    private function getCurrentVersion(): ?int
    {
        $version = null;
        $info_file = @file(self::CFG_UPDATE_INFO_PHP);
        if(isset($info_file[0])) {
            $version = (int) $info_file[0];
        }
        if($version !== null) {
            $this->currentVersion = $version;
        }
        return $this->currentVersion;
    }

    private function setCurrentVersion($version)
    {
        file_put_contents(self::CFG_UPDATE_INFO_PHP, $version);
        $this->currentVersion = $version;
        return true;
    }

    private function readFileVersion()
    {
        $version = 0;
        reset($this->filecontent);
        $regs = array();
        foreach ($this->filecontent as $row) {
            if (preg_match('/^\<\#([0-9]+)>/', $row, $regs)) {
                $version = $regs[1];
            }
        }

        $this->fileVersion = (integer) $version;
        echo sprintf("Found %s db updates in update file, %s updates where applied.\n", $version, $this->getRunningStatus());
        return $this->fileVersion;
    }


    private function getFileVersion()
    {
        return $this->fileVersion;
    }


    private function execQuery($db,$str)
    {
        $sql = explode("\n",trim($str));
        for ($i=0; $i<count($sql); $i++)
        {
            $sql[$i] = trim($sql[$i]);
            if ($sql[$i] != "" && substr($sql[$i],0,1)!="#")
            {
                if (substr($sql[$i],-1)==";")
                {
                    $q .= " ".substr($sql[$i],0,-1);
                    $check = $this->checkQuery($q);
                    if ($check === true)
                    {
                        $r = $db->query($q);
                        if (MDB2::isError($r))
                        {
                            $this->error = $r->getMessage();
                            return false;
                        }
                    }
                    else
                    {
                        $this->error = $check;
                        return false;
                    }
                    unset($q);
                } //if
                else
                {
                    $q .= " ".$sql[$i];
                } //else
            } //if
        } //for
        if ($q != "")
        {
            echo "incomplete_statement: ".$q."<br>";
            return false;
        }
        return true;
    }


    private function checkQuery($q)
    {
        return true;
    }


    public function applyUpdate($a_break = 0)
    {
        $f = $this->fileVersion;
        $c = $this->currentVersion;

        if ($a_break > $this->currentVersion
            && $a_break < $this->fileVersion
        ) {
            $f = $a_break;
        }

        if ($c < $f) {
            $msg = array();
            for ($i = ($c + 1); $i <= $f; $i++) {
                $this->readDBUpdateFile();
                $this->initStep($i);
                if ($this->applyUpdateNr($i) == false) {
                    $msg[] = array("msg" => "Update error: " . $this->error,
                        "nr" => $i,);
                    $this->updateMsg = $msg;

                    return false;
                } else {
                    $msg[] = array("msg" => "Update applied.",
                        "nr" => $i,);
                }
            }

            $this->updateMsg = $msg;
        } else {
            $this->updateMsg = "No new db updates found.";
            echo "No new db updates found to apply.\n";
        }

        if ($f < $this->fileVersion) {
            return true;
        }
    }

    public function setRunningStatus($version): void
    {
        file_put_contents(self::CFG_UPDATE_RUNNING_PHP, $version);
        $this->db_update_running = $version;
    }


    public function getRunningStatus(): int
    {
        $version = 0;
        $running_file = @file(self::CFG_UPDATE_RUNNING_PHP);
        if(isset($running_file[0])) {
            $version = (int) $running_file[0];
        }
        $this->db_update_running = $version;
        return $version;
    }

    public function clearRunningStatus(): void
    {
        file_put_contents(self::CFG_UPDATE_RUNNING_PHP, 0);
        $this->db_update_running = 0;
    }

    private function applyUpdateNr($nr)
    {
        echo sprintf("Trying to apply update %s...\n", $nr);
        reset($this->filecontent);
        $this->setRunningStatus($nr);
        $i = 0;
        while (!preg_match("/^\<\#" . $nr . ">/", $this->filecontent[$i]) && $i < count($this->filecontent)) {
            $i++;
        }
        if ($i == count($this->filecontent)) {
            $this->error = "update_not_found";
            return false;
        }
        $i++;
        $update = array();
        while ($i < count($this->filecontent) && !preg_match("/^<#" . ($nr + 1) . ">/", $this->filecontent[$i])) {
            $update[] = trim($this->filecontent[$i]);
            $i++;
        }
        $sql = array();
        $php = array();
        $mode = "sql";

        foreach ($update as $row) {
            if (preg_match("/<\?php/", $row)) {
                if (count($sql) > 0) {
                    if (!$this->execQuery($this->db, implode("\n", $sql))) {
                        return false;
                    }
                    $sql = array();
                }
                $mode = "php";
            } elseif (preg_match("/\?>/", $row)) {
                if (count($php) > 0) {
                    $code = implode("\n", $php);
                    if (eval($code) === false) {
                        $this->error = "Parse error: " . $code;

                        return false;
                    }
                    $php = array();
                }
                $mode = "sql";
            } else {
                if ($mode == "sql") {
                    $sql[] = $row;
                }

                if ($mode == "php") {
                    $php[] = $row;
                }
            }
        }

        if ($mode == "sql" && count($sql) > 0) {
            if (!$this->execQuery($this->db, implode("\n", $sql))) {
                $this->error = "dump_error: " . $this->error;

                return false;
            }
        }

        echo sprintf("...update nr %s applied. \n", $nr);
        $this->setCurrentVersion($nr);
        return true;
    }

    private function getDBVersionStatus()
    {
        if ($this->fileVersion > $this->currentVersion)
            return false;
        else
            return true;
    }

    private function getTables()
    {
        $a = array();

        $query = "SHOW TABLES";
        $res = $this->db->query($query);
        while ($row = $res->fetchRow())
        {
            $status = $this->getTableStatus($row[0]);
            $a[] = array(
                "name" => $status["Table"],
                "table" => $row[0],
                "status" => $status["Msg_text"]
            );
        }
        return $a;
    }

    private function getTableStatus($table)
    {
        $query = "ANALYZE TABLE ".$table;
        $res = $this->db->query($query);
        $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
        return $row;
    }

    private function optimizeTables($tables)
    {
        $msg = array();
        foreach ($_POST["tables"] as $key => $value)
        {
            $query = "OPTIMIZE TABLE ".$key;
            $res = $this->db->query($query);
            $msg[] = "table $key: ok";
        }
        return $msg;
    }

    private function checkForExistingFiles()
    {
        $db_info_files = [self::CFG_UPDATE_INFO_PHP, self::CFG_UPDATE_RUNNING_PHP];
        foreach($db_info_files as $file) {
            if(! file_exists($file)) {
                echo sprintf('File: %s not found, initialising.', $file) . "\n";
                file_put_contents($file, 0);
            }
        }
        return true;
    }

}
$DBUpdate = new DBUpdate();
$DBUpdate->applyUpdate();
